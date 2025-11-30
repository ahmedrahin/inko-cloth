@php
    $categories = Cache::rememberForever(config('dbcachekey.menu_category'), function () {
        return \App\Models\Category::with('subcategories')->where('status', 1)->where('featured',1)->get();
    });
@endphp
@foreach ($categories as $category)
    <div class="col-2">
        <div class="mega-menu-item">
            <h4 class="menu-heading">
                <a href="{{ route('category.products', $category->slug) }}">{{ $category->name }}</a>
            </h4>
            <ul class="sub-menu_list">
                @foreach ($category->subcategories as $sub)
                    <li>
                        <a href="{{ route('category.products', [$category->slug, $sub->slug]) }}">
                            {{ $sub->name }}
                        </a>    
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endforeach