<?php

namespace App\Http\Livewire\Frontend\Order;

use Livewire\Component;
use App\Models\ShippingMethod;
use App\Models\District;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderHistory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Coupon;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Services\OrderService;
use App\Services\StripeService;

class Checkout extends Component
{
    public $name;
    public $email;
    public $phone;
    public $shipping_address;
    public $zip_code;
    public $city;
    public $district_id;
    public $note;
    public $payment_type;
    public $selectedShippingMethodId;
    public $selectedShippingCharge = 0;

    public $cart = [];
    public $quantities = [];
    public $shippingMethods;
    public $couponCode;
    public $discountAmount = 0;
    public $appliedCoupon;
    private $cacheKey;

    protected $listeners = [
        'cartUpdated' => 'refreshCart',
    ];

    public function __construct()
    {
        $this->cacheKey = config('dbcachekey.order');
    }

    public function mount()
    {
        $this->loadCart();
        $this->loadShippingMethods();
        $this->payment_type = 'cod';

        $this->appliedCoupon = session()->get('applied_coupon', null);

        if (Auth::check()) {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $this->phone = Auth::user()->phone;
            $this->shipping_address = Auth::user()->address_line1;
        }
    }

    public function loadCart()
    {
        // Retrieve the cart from the session
        $sessionCart = session()->get('cart', []);

        $validCart = []; 

        foreach ($sessionCart as $cartKey => $item) {
            $productId = explode('-', $cartKey)[0];
            $product = Product::find($productId);

            if ($product && ($product->status == 1 || $product->status == 3) && $product->quantity > 0) {
                $validCart[$cartKey] = $item;
                $validCart[$cartKey]['name'] = $product->name;
                $validCart[$cartKey]['slug'] = $product->slug;
                $validCart[$cartKey]['offer_price'] = $product->offer_price;
                $validCart[$cartKey]['price'] = $product->base_price;
                $validCart[$cartKey]['image_url'] = $product->thumb_image;
                $validCart[$cartKey]['available_quantity'] = $product->quantity;
                $validCart[$cartKey]['discount_option'] = $product->discount_option;
                $validCart[$cartKey]['quantity'] = $item['quantity'] ?? 1;
            }
        }

        // Assign valid items to the cart
        $this->cart = $validCart;

        // Check for direct checkout first
        $directCheckout = session()->get('direct_checkout');

        if ($directCheckout && $directCheckout['is_direct_checkout']) {

            $product = Product::find($directCheckout['product_id']);

            if ($product && ($product->status == 1 || $product->status == 3) && $product->quantity > 0) {

                // Create cart key with attributes
                $cartKey = "{$product->id}";
                foreach ($directCheckout['attributes'] as $key => $value) {
                    $cartKey .= "-{$key}:{$value}";
                }

                // Convert attributes to view-friendly format
                $attributesInfo = [];
                foreach ($directCheckout['attributes'] as $key => $value) {
                    $attributesInfo[] = [
                        'name' => ucfirst($key),
                        'value' => $value,
                    ];
                }

                // Final direct checkout cart override
                $this->cart = [
                    $cartKey => [
                        'product_id' => $product->id,
                        'quantity' => $directCheckout['quantity'],
                        'attributes' => $directCheckout['attributes'],
                        'attributes_info' => $attributesInfo, 
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'offer_price' => $product->offer_price,
                        'price' => $product->base_price,
                        'image_url' => $product->thumb_image,
                        'available_quantity' => $product->quantity,
                        'discount_option' => $product->discount_option,
                    ]
                ];

                return;
            }
        }

    }

    public function applyCoupon()
    {
        if ($this->couponCode == null) {
            $this->emit('error', 'please enter your coupon code.');
            return;
        }

        $coupon = Coupon::whereRaw('BINARY code = ?', [$this->couponCode])
            ->where('status', 1)
            ->whereDate('start_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('expire_date')
                    ->orWhereDate('expire_date', '>=', now());
            })
            ->first();

        if (!$coupon) {
            $this->emit('error', 'Invalid or expired coupon code!');
            $this->couponCode = '';
            return;
        }

        $categoryIds = $coupon->categories()->pluck('categories.id')->toArray();

        $eligibleTotal = 0;
        foreach ($this->cart as $item) {
            $product = Product::find($item['product_id'] ?? explode('-', $item['id'])[0]);
            if (!$product)
                continue;

            // If coupon has categories, only count products inside them
            if (empty($categoryIds) || $product->category()->whereIn('categories.id', $categoryIds)->exists()) {
                $eligibleTotal += ($product->offer_price ?? $product->base_price) * $item['quantity'];
            }
        }

        if ($eligibleTotal <= 0) {
            $this->emit('error', 'This coupon is not applicable to your selected products.');
            $this->couponCode = '';
            return;
        }

        if ($coupon->min_purchase_amount && ($coupon->min_purchase_amount > $this->getTotalAmount())) {
            $this->emit('error', 'You need to minimum purchase ' . $coupon->min_purchase_amount . 'tk for use this coupon');
            $this->couponCode = '';
            return;
        }

        // Check usage limit
        $usage = $coupon->orders()->count();
        if ($coupon->usage_limit && ($usage >= $coupon->usage_limit)) {
            $this->emit('error', 'The coupon usage limit has been reached.');
            $this->couponCode = '';
            return;
        }

        // Apply the discount based on coupon type
        if ($coupon->discount_type == 'percentage') {
            $this->discountAmount = $eligibleTotal * ($coupon->discount_amount / 100);
        } else {
            $this->discountAmount = min($coupon->discount_amount, $eligibleTotal);
        }


        // Store the coupon and discount amount
        session()->put('applied_coupon', [
            'code' => $this->couponCode,
            'discount' => $this->discountAmount,
        ]);
        $this->appliedCoupon = session()->get('applied_coupon');
        $this->emit('success', 'Coupon applied successfully!');
    }

    public function removeCoupon()
    {
        $this->couponCode = null;
        $this->discountAmount = 0;
        $this->appliedCoupon = [];
        session()->forget('applied_coupon');

        // $this->emit('info', 'Coupon removed.');
    }

    public function updatedDistrictId($value)
    {
        $methods = ShippingMethod::where('status', 1)->where('base_id', $value)->first();

        if ($methods) {

            $this->selectedShippingMethodId = $methods->id;
            $this->selectedShippingCharge = $methods->base_charge;
            $this->shippingMethods = collect();
        } else {
            $this->loadShippingMethods();
        }
    }

    public function loadShippingMethods()
    {
        $this->shippingMethods = ShippingMethod::where('status', 1)
            ->where('base_id', null)
            ->get();

        if ($this->shippingMethods->count() === 1) {
            $singleMethod = $this->shippingMethods->first();
            $this->selectedShippingMethodId = $singleMethod->id;
            $this->selectedShippingCharge = $singleMethod->provider_charge;
        } elseif ($this->shippingMethods->count() > 1) {
            $this->selectedShippingMethodId = null;
            $this->selectedShippingCharge = 0;
        }
    }

    public function updatedSelectedShippingMethodId()
    {
        // Validate and fetch the charge securely
        $shippingMethod = ShippingMethod::where('id', $this->selectedShippingMethodId)
            ->first();

        if ($shippingMethod) {
            $this->selectedShippingCharge = $shippingMethod->provider_charge;
        } else {
            $this->selectedShippingCharge = 0;
        }
    }

    protected $rules = [
        'name' => 'required',
        'email' => 'nullable|email',
        'phone' => 'required|numeric',
        'shipping_address' => 'required',
        'city' => 'required',
    ];

    public function order(OrderService $orderService, StripeService $stripeService)
    {
        $this->validate(); 
        
        try {
            if (empty($this->cart)) {
                throw new \Exception('Your cart is empty');
            }

            if (!$this->selectedShippingMethodId) {
                throw new \Exception('Select a shipping method');
            }

            if (!$this->payment_type) {
                throw new \Exception('Select a payment method');
            }

            if ($this->payment_type === 'cod') {
                $order = $orderService->placeOrder($this, $this->cart, 'cod');
                return redirect()->route('success.order', ['order_id' => $order->order_id])->with('success', 'Order placed successfully!');
            }

            if ($this->payment_type === 'stripe') {
                $orderData = [
                    'cart' => $this->cart,
                    'form_data' => [
                        'name' => $this->name,
                        'email' => $this->email,
                        'phone' => $this->phone,
                        'shipping_address' => $this->shipping_address,
                        'zip_code' => $this->zip_code,
                        'city' => $this->city,
                        'district_id' => $this->district_id,
                        'selectedShippingMethodId' => $this->selectedShippingMethodId,
                        'selectedShippingCharge' => $this->selectedShippingCharge,
                        'note' => $this->note,
                        'appliedCoupon' => $this->appliedCoupon ?? [],
                        'grandTotal' => $this->grandTotal(),
                        'subtotal' => $this->getTotalAmount(),
                    ]
                ];

                $stripeSessionId = 'stripe_order_' . time() . '_' . rand(1000, 9999);
                session([$stripeSessionId => $orderData]);
                $userId = auth()->check() ? auth()->id() : null;
                
                $session = $stripeService->createCheckout(
                    $this->cart, 
                    $this->grandTotal(), 
                    $userId,
                    $stripeSessionId
                );

                return redirect()->away($session->url);
            }
        } catch(\Exception $e) {
            $this->emit('error', $e->getMessage());
        }
    }


    public function refreshCart()
    {
        $this->loadCart();
    }

    public function getTotalAmount()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['quantity'] * $item['offer_price'];
        }
        return $total;
    }

    public function grandTotal()
    {
        $discount = $this->appliedCoupon ? ($this->appliedCoupon['discount'] ?? 0) : 0;
        return $this->getTotalAmount() + $this->selectedShippingCharge - $discount;
    }


    public function hydrate()
    {
        // Reset error bag and validation
        $this->resetErrorBag();
        $this->resetValidation();
    }

    private function refreshCache()
    {
        Cache::forget($this->cacheKey);
        Cache::rememberForever($this->cacheKey, function () {
            return Order::orderBy('id', 'desc')->get();
        });
    }

    public function render()
    {
        $districts = District::orderBy('name', 'asc')->where('status', 1)->get();
        return view('livewire.frontend.order.checkout', compact('districts'));
    }

}
