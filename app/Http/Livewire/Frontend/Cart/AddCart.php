<?php

namespace App\Http\Livewire\Frontend\Cart;

use Livewire\Component;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;

class AddCart extends Component
{
    public $productId;
    public $quantity = 1;
    public $selectedAttributes = [];
    public $attributeErrors = [];

    protected $listeners = ['updateQuantity', 'selectAttribute'];

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function updateQuantity($quantity)
    {
        $this->quantity = intval($quantity);
    }

    public function selectAttribute($attributeName, $value)
    {
        $this->selectedAttributes[$attributeName] = $value;
        unset($this->attributeErrors[$attributeName]);
    }

    public function addToCart()
    {
        $product = Product::with('productStock.attributeOptions.attribute')->find($this->productId);

        if (!$product) {
            $this->emit('error', 'Product not found.');
            return;
        }

        // Validate required attributes based on stock
        $requiredAttributes = [];

        foreach ($product->productStock as $stock) {
            foreach ($stock->attributeOptions as $option) {
                $attrName = $option->attribute->attr_name;
                $requiredAttributes[$attrName] = true;
            }
        }

        // Check if all required attributes are selected
        foreach (array_keys($requiredAttributes) as $attrName) {
            if (empty($this->selectedAttributes[$attrName])) {
                $this->attributeErrors[$attrName] = "Please select $attrName";
            }
        }

        if (!empty($this->attributeErrors)) {
            $this->emit('error', 'Please select all required options.');
            return;
        }

        // Validate quantity
        if ($this->quantity <= 0 || !is_numeric($this->quantity)) {
            $this->emit('error', 'Invalid product quantity.');
            return;
        }

        // Build cart key dynamically
        $cart = session()->get('cart', []);

        $cartKey = "{$this->productId}";
        foreach ($this->selectedAttributes as $key => $value) {
            $cartKey .= "-{$key}:{$value}";
        }

        $existingQuantity = isset($cart[$cartKey]) ? $cart[$cartKey]['quantity'] : 0;
        $newTotalQuantity = $existingQuantity + $this->quantity;

        if ($newTotalQuantity > $product->quantity) {
            $this->emit('error', "You have exceeded available stock for {$product->name}. Only {$product->quantity} available.");
            return;
        }

        // Store in cart - FIXED: Use $newTotalQuantity instead of $this->quantity
        $cart[$cartKey] = [
            'product_id' => $this->productId,
            'quantity' => $newTotalQuantity,  // THIS WAS THE BUG
            'attributes' => $this->selectedAttributes,
            'added_at' => now(),
        ];

        session()->put('cart', $cart);
        session()->forget('applied_coupon');

        $this->emit('success', 'Product added to cart.');
        $this->emit('cartUpdated');
        $this->emit('cartAdded');
    }

    public function directCheckout()
    {
        $product = Product::with('productStock.attributeOptions.attribute')->find($this->productId);

        if (!$product) {
            $this->emit('error', 'Product not found.');
            return;
        }

        // Validate required attributes
        $requiredAttributes = [];
        foreach ($product->productStock as $stock) {
            foreach ($stock->attributeOptions as $option) {
                $attrName = $option->attribute->attr_name;
                $requiredAttributes[$attrName] = true;
            }
        }

        foreach (array_keys($requiredAttributes) as $attrName) {
            if (empty($this->selectedAttributes[$attrName])) {
                $this->attributeErrors[$attrName] = "Please select $attrName";
            }
        }

        if (!empty($this->attributeErrors)) {
            $this->emit('error', 'Please select all required options.');
            return;
        }

        // Validate quantity
        if ($this->quantity <= 0 || !is_numeric($this->quantity)) {
            $this->emit('error', 'Invalid product quantity.');
            return;
        }

        // Check stock availability
        if ($this->quantity > $product->quantity) {
            $this->emit('error', "Only {$product->quantity} items available.");
            return;
        }

        // Store product data for direct checkout
        $checkoutData = [
            'product_id' => $this->productId,
            'quantity' => $this->quantity,
            'attributes' => $this->selectedAttributes,
            'product_details' => [
                'name' => $product->name,
                'slug' => $product->slug,
                'offer_price' => $product->offer_price,
                'base_price' => $product->base_price,
                'image_url' => $product->thumb_image,
            ],
            'is_direct_checkout' => true,
            'added_at' => now(),
        ];

        session()->put('direct_checkout', $checkoutData);
        // session()->forget('cart'); // Clear regular cart
        session()->forget('buy_now_product');
        session()->forget('applied_coupon');

        return redirect()->route('checkout');
    }


    public function render()
    {
        $product = Product::with([
            'productStock.attributeOptions:id,product_stock_id,attribute_id,attribute_value_id'
        ])->find($this->productId);

        $attributes = Attribute::all();
        $attributesValues = AttributeValue::all();
        return view('livewire.frontend.cart.add-cart', compact('product', 'attributes', 'attributesValues'));
    }
}
