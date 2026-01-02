<?php
namespace App\Services;

use App\Models\{
    Order, Product, Notification, OrderHistory, ProductStockManage
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Jobs\OrderSent;

class OrderService
{
    public function placeOrder($context, array $cart, string $paymentType = 'cod', $paidAmount = null)
    {
        $orderData = $this->prepareOrderData($context, $paymentType, $paidAmount);

        $order = Order::create($orderData);

        $this->saveOrderItems($order, $cart);
        $this->afterOrderPlaced($order);

        return $order;
    }

    private function prepareOrderData($c, string $paymentType = 'cod', $paidAmount): array
    {
        return [
            'order_id' => Str::upper(Str::random(4)) . rand(1000, 9999),
            'user_id' => Auth::id() ?? null,
            'user_type' => 'customer',

            'name' => $c->name,
            'email' => $c->email,
            'phone' => $c->phone,

            'shipping_address' => $c->shipping_address,
            'zip_code' => $c->zip_code,
            'city' => $c->city,
            'district_id' => $c->district_id,

            'payment_type' => $paymentType,
            'shipping_method' => $c->selectedShippingMethodId,
            'shipping_cost' => $c->selectedShippingCharge,

            'order_date' => now(),
            'note' => $c->note,

            'paid_amount' => $paidAmount ?? 0, 
            'grand_total' => $c->grandTotal(),
            'subtotal' => $c->getTotalAmount(),

            'cupon_code' => $c->appliedCoupon['code'] ?? null,
            'coupon_discount' => $c->appliedCoupon['discount'] ?? 0,
            'order_source' => 'website',
        ];
    }

    private function saveOrderItems(Order $order, array $cart)
    {
        foreach ($cart as $item) {

            $product = Product::find($item['product_id']);

            if (!$product || $product->quantity < $item['quantity']) {
                continue;
            }

            $product->decrement('quantity', $item['quantity']);

            $orderItem = $order->orderItems()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $item['offer_price'],
            ]);

            foreach ($item['attributes'] ?? [] as $name => $value) {
                $orderItem->orderItemVariations()->create([
                    'attribute_name' => $name,
                    'attribute_value' => $value,
                ]);
            }

            if ($product->fresh()->quantity === 0) {
                ProductStockManage::create([
                    'product_id' => $product->id,
                    'stock' => 'out_of_stock',
                    'quantity' => 0,
                ]);
            }
        }
    }

    private function afterOrderPlaced(Order $order)
    {
        Notification::create([
            'type' => 'order',
            'order_id' => $order->id,
        ]);

        OrderHistory::create([
            'order_id' => $order->id,
            'status' => 'pending',
            'note' => 'Order placed, waiting for processing.',
        ]);

        if ($this->mailIsConfigured()) {
            if(config('app.email')){
                OrderSent::dispatch($order);
            }
        }

        session()->forget('cart');
        session()->forget('direct_checkout');
        session()->forget('applied_coupon');
    }

    private function mailIsConfigured(): bool
    {
        $required = [
            'mail.default',
            'mail.mailers.smtp.host',
            'mail.mailers.smtp.port',
            'mail.mailers.smtp.username',
            'mail.mailers.smtp.password',
        ];

        foreach ($required as $key) {
            if (empty(config($key))) {
                return false;
            }
        }

        return true;
    }
}
