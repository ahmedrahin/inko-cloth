
<div class="canvas-sidebar sidebar-filter canvas-filter left">
    <div class="canvas-wrapper">
        <div class="canvas-header d-xl-none">
            <span class="title h3 fw-medium">Filter</span>
            <span class="icon-close link icon-close-popup fs-24 close-filter"></span>
        </div>
        <div class="canvas-body">
            <div class="widget-facet">
                <div class="facet-title" data-bs-target="#category" role="button" data-bs-toggle="collapse"
                    aria-expanded="true" aria-controls="category">
                    <span class="h4 fw-semibold">Category</span>
                    <span class="icon icon-caret-down fs-20"></span>
                </div>
                <div id="category" class="collapse show">
                    @php
                        $categories = App\Models\Category::with(['subcategories.subsubcategories'])->where('status', 1)->where('featured',1)->get();
                    @endphp
                    <ul class="collapse-body filter-group-check group-category">
                        @foreach ($categories as $category)
                            @php
                                $isActiveCategory = $currentSlug === $category->slug;
                            @endphp

                            <li class="list-item {{ $isActiveCategory ? 'active' : '' }}">
                                <a href="{{ route('category.products', $category->slug) }}" class="link h6">
                                    {{ $category->name }}
                                    @if(config('website_settings.product_count_enabled'))
                                        <span class="count">({{ $category->product()->activeProducts()->count() }})</span>
                                    @endif
                                </a>

                                {{-- 🟢 Subcategories --}}
                                @if ($category->subcategories->count() > 0)
                                    <ul class="sub-category">
                                        @foreach ($category->subcategories as $sub)
                                            @php
                                                $isActiveSub = $currentSlug === $sub->slug;
                                            @endphp

                                            <li class="{{ $isActiveSub ? 'active' : '' }}">
                                                <a href="{{ route('category.products', [$category->slug, $sub->slug]) }}">
                                                    {{ $sub->name }}
                                                    @if(config('website_settings.product_count_enabled'))
                                                        <span class="count">({{ $sub->product()->activeProducts()->count() }})</span>
                                                    @endif
                                                </a>

                                                {{-- 🔵 SubSubcategories --}}
                                                @if ($sub->subsubcategories->count() > 0)
                                                    <ul class="sub-sub-category">
                                                        @foreach ($sub->subsubcategories as $subsub)
                                                            @php
                                                                $isActiveSubSub = $currentSlug === $subsub->slug;
                                                            @endphp

                                                            <li class="{{ $isActiveSubSub ? 'active' : '' }}">
                                                                <a href="{{ route('category.products', [$category->slug, $sub->slug, $subsub->slug]) }}">
                                                                    {{ $subsub->name }}
                                                                    @if(config('website_settings.product_count_enabled'))
                                                                        <span class="count">({{ $subsub->product()->activeProducts()->count() }})</span>
                                                                    @endif
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="widget-facet">
                <div class="facet-title" data-bs-target="#price" role="button" data-bs-toggle="collapse" aria-expanded="true"
                    aria-controls="price">
                    <span class="h4 fw-semibold">Price</span>
                    <span class="icon icon-caret-down fs-20"></span>
                </div>
                <div id="price" class="collapse show">
                    <div class="collapse-body widget-price filter-price">
                        <div class="price-val-range" id="price-value-range" data-min="0" data-max="5000"></div>
                        <div class="box-value-price">
                            <span class="h6 text-main">Price:</span>
                            <div class="price-box">
                                <div class="price-val" id="price-min-value" data-currency="$"></div>
                                <span>-</span>
                                <div class="price-val" id="price-max-value" data-currency="$"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget-facet">
                <div class="facet-title" data-bs-target="#brand" role="button" data-bs-toggle="collapse" aria-expanded="true"
                    aria-controls="brand">
                    <span class="h4 fw-semibold">Brand</span>
                    <span class="icon icon-caret-down fs-20"></span>
                </div>
                <div id="brand" class="collapse show">
                    <ul class="collapse-body filter-group-check current-scrollbar">
                        <li class="list-item">
                            <input type="checkbox" name="brand" class="tf-check" id="automet">
                            <label for="automet" class="label">AUTOMET</label>
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>
        <div class="canvas-bottom d-xl-none">
            <button id="reset-filter" class="tf-btn btn-reset">Reset Filters</button>
        </div>
    </div>
</div>

@push('scripts')

    <script>
        jQuery(function($) {

            // Build query params
            function getFilters() {
                let params = new URLSearchParams();

                // Limit
                if ($('#input-limit').length) {
                    params.set('limit', $('#input-limit').val());
                }

                // Sort
                if ($('#input-sort').length) {
                    let sortVal = $('#input-sort').val();
                    if (sortVal === '') {
                        params.delete('sort');
                        params.delete('order');
                    } else if (sortVal.endsWith('_desc')) {
                        params.set('sort', sortVal.replace('_desc', ''));
                        params.set('order', 'DESC');
                    } else {
                        params.set('sort', sortVal);
                        params.set('order', 'ASC');
                    }
                }

                // Collect checked filters
                $('input[name="filter[]"]:checked').each(function() {
                    params.append('filter[]', $(this).val());
                });

                return params.toString();
            }

            // Load products
            function loadProducts(customUrl = null) {
                let url = customUrl || (window.location.pathname + '?' + getFilters());

                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    beforeSend: function() {
                        $('#gridLayout').addClass('loading');
                        $('#ajax-loader').show();
                    },
                    success: function(data) {
                        $('#gridLayout').html(data);
                        if (typeof Livewire !== "undefined") {
                            Livewire.rescan();
                        }
                        history.pushState(null, '', url);
                    },
                    complete: function() {
                        $('#gridLayout').removeClass('loading');
                        $('#ajax-loader').hide();
                    },
                    error: function(xhr) {
                        console.error("AJAX ERROR:", xhr.responseText);
                        alert('Failed to load products');
                    }
                });
            }

            // Events
            $(document).on('change', 'input[name="filter[]"]', function() {
                loadProducts();
            });

            $('#input-limit, #input-sort').on('change', function() {
                loadProducts();
            });

            $(document).on('click', '#gridLayout .wg-pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                loadProducts(url);
            });

            window.onpopstate = function() {
                $.ajax({
                    url: location.href,
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(data) {
                        $('#gridLayout').html(data);
                        if (typeof Livewire !== "undefined") {
                            Livewire.rescan();
                        }
                    }
                });
            };

        });
    </script>

    <script>
        jQuery(function($) {
            let slider = document.getElementById('rang-slider');

            let min = parseInt(slider.dataset.min);
            let max = parseInt(slider.dataset.max);
            let from = parseInt(slider.dataset.from);
            let to = parseInt(slider.dataset.to);

            let inputFrom = document.getElementById('range-from');
            let inputTo = document.getElementById('range-to');

            // Create slider
            noUiSlider.create(slider, {
                start: [slider.dataset.from, slider.dataset.to],
                connect: true,
                range: {
                    'min': parseInt(slider.dataset.min),
                    'max': parseInt(slider.dataset.max)
                }
            });

            slider.noUiSlider.on('update', function(values) {
                document.getElementById('range-from').value = Math.round(values[0]);
                document.getElementById('range-to').value = Math.round(values[1]);
            });

            // User types in FROM input
            inputFrom.addEventListener('change', function() {
                let valFrom = parseInt(this.value) || min;
                let valTo = parseInt(inputTo.value) || max;
                slider.noUiSlider.set([valFrom, valTo]);
                triggerAjax(valFrom, valTo);
            });

            // User types in TO input
            inputTo.addEventListener('change', function() {
                let valFrom = parseInt(inputFrom.value) || min;
                let valTo = parseInt(this.value) || max;
                slider.noUiSlider.set([valFrom, valTo]);
                triggerAjax(valFrom, valTo);
            });

            // When user stops sliding, trigger AJAX
            slider.noUiSlider.on('change', function(values) {
                triggerAjax(Math.round(values[0]), Math.round(values[1]));
            });

            // AJAX request (same as your sorting code)
            function triggerAjax(fromVal, toVal) {
                let params = new URLSearchParams(window.location.search);
                params.set('filter_price', `${fromVal}-${toVal}`);

                // Preserve limit & sort
                let limitVal = $('#input-limit').val();
                if (limitVal) params.set('limit', limitVal);

                let sortVal = $('#input-sort').val();
                if (sortVal) {
                    if (sortVal.endsWith('_desc')) {
                        params.set('sort', sortVal.replace('_desc', ''));
                        params.set('order', 'DESC');
                    } else {
                        params.set('sort', sortVal);
                        params.set('order', 'ASC');
                    }
                }

                let url = window.location.pathname + '?' + params.toString();

                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    beforeSend: function() {
                        $('#gridLayout').addClass('loading');
                        $('#ajax-loader').show();
                    },
                    success: function(data) {
                        $('#gridLayout').html(data);
                        Livewire.rescan();
                        history.pushState(null, '', url);
                    },
                    complete: function() {
                        $('#gridLayout').removeClass('loading');
                        $('#ajax-loader').hide();
                    },
                    error: function() {
                        alert('Failed to load products');
                    }
                });
            }
        });
    </script>

    <script>
        jQuery(function($) {
            $(document).on('click', '.filter-group .label', function() {
                $(this).closest('.filter-group').toggleClass('show');
            });
        });
    </script>
    
@endpush
