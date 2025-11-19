<div>
    <div class="tf-product-variant">
        <div class="variant-picker-item variant-size">
            <div class="variant-picker-label">
                <div class="h4 fw-semibold">
                    Size
                    <span class="variant-picker-label-value value-currentSize">medium</span>
                </div>
                <a href="#size-guide" data-bs-toggle="modal" class="size-guide link h6 fw-medium">
                    <i class="icon icon-ruler"></i>
                    Size Guide
                </a>
            </div>
            <div class="variant-picker-values">
                <span class="size-btn" data-size="XS">XS</span>
                <span class="size-btn" data-size="S">S</span>
                <span class="size-btn" data-size="M">M</span>
                <span class="size-btn" data-size="L">L</span>
            </div>
        </div>
        <div class="variant-picker-item variant-color">
            <div class="variant-picker-label">
                <div class="h4 fw-semibold">
                    Colors
                    <span class="variant-picker-label-value value-currentColor">orange</span>
                </div>
            </div>
            <div class="variant-picker-values">
                <div class="hover-tooltip tooltip-bot color-btn active" data-color="blue">
                    <span class="check-color bg-blue-1"></span>
                    <span class="tooltip">Blue</span>
                </div>
                <div class="hover-tooltip tooltip-bot color-btn" data-color="gray">
                    <span class="check-color bg-caramel"></span>
                    <span class="tooltip">Gray</span>
                </div>
                <div class="hover-tooltip tooltip-bot color-btn" data-color="pink">
                    <span class="check-color bg-hot-pink"></span>
                    <span class="tooltip">Pink</span>
                </div>
                <div class="hover-tooltip tooltip-bot color-btn" data-color="green">
                    <span class="check-color bg-dark-jade"></span>
                    <span class="tooltip">Green</span>
                </div>
                <div class="hover-tooltip tooltip-bot color-btn" data-color="white">
                    <span class="check-color bg-white"></span>
                    <span class="tooltip">White</span>
                </div>
            </div>
        </div>
    </div>

    <div class="tf-product-total-quantity">
        <div class="group-btn">
            <div class="wg-quantity">
                <button type="button" class="btn-quantity btn-decrease" aria-label="Decrease quantity">
                    <i class="icon icon-minus"></i>
                </button>

                <input
                    class="quantity-product"
                    type="text"
                    name="number"
                    value="1"
                    data-quantity="{{ $product->quantity }}"  
                    inputmode="numeric"
                    pattern="[0-9]*"
                    />

                <button type="button" class="btn-quantity btn-increase" aria-label="Increase quantity">
                    <i class="icon icon-plus"></i>
                </button>
            </div>

            @if($product->stock_out == 1 || $product->quantity == 0)
                <button class="tf-btn btn-add-to-cart" style="background: #626262;" disabled>
                    Out Of Stock
                </button>
            @elseif ($product->pre_order == 1)
                <button class="tf-btn btn-add-to-cart" style="background: #626262;" disabled>
                    Up Coming
                </button>
            @else
                <button class="tf-btn animate-btn btn-add-to-cart" wire:click="addToCart">
                    <span wire:loading.remove wire:target="addToCart">ADD TO CART</span>
                    <span wire:loading wire:target="addToCart" class="formloader"></span>
                </button>
            @endif

            <button type="button" class="hover-tooltip box-icon btn-add-wishlist">
                <span class="icon icon-heart"></span>
                <span class="tooltip">Add to Wishlist</span>
            </button>
        </div>

        <a href="" class="tf-btn btn-primary w-100">BUY IT NOW</a>
    </div>


    @section('addcart-js')
        {{-- qty increse & decrease --}}
        <script>
            function initQuantityButtons() {
                document.querySelectorAll('.wg-quantity').forEach(wrapper => {

                    const inc = wrapper.querySelector('.btn-increase');
                    const dec = wrapper.querySelector('.btn-decrease');
                    const input = wrapper.querySelector('.quantity-product');

                    if (!inc || !dec || !input) return;

                    const max = parseInt(input.dataset.quantity) || null;
                    const min = 1;

                    const updateState = () => {
                        let val = parseInt(input.value) || min;
                        if (val < min) val = min;
                        if (max !== null && val > max) val = max;
                        input.value = val;

                        dec.disabled = val <= min;
                        inc.disabled = (max !== null && val >= max);
                    };

                    inc.onclick = () => {
                        let val = parseInt(input.value) || min;
                        if (max === null || val < max) {
                            input.value = val + 1;
                            input.dispatchEvent(new Event('input'));
                        }
                        updateState();
                    };

                    dec.onclick = () => {
                        let val = parseInt(input.value) || min;
                        if (val > min) {
                            input.value = val - 1;
                            input.dispatchEvent(new Event('input'));
                        }
                        updateState();
                    };

                    updateState();
                });
            }

            document.addEventListener("DOMContentLoaded", initQuantityButtons);
            document.addEventListener("livewire:navigated", initQuantityButtons);
            document.addEventListener("livewire:update", initQuantityButtons);
        </script>
    @endsection
</div>