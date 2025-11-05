<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Subsubcategory;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FilterOption;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class ShopController extends Controller
{
    // show product in shop page
    public function allProducts(Request $request)
    {
        $query = Product::activeProducts();
        [$products, $perPage, $from, $to] = $this->getFilteredProducts($request, $query);

        if ($request->ajax()) {
            return view('frontend.pages.shop.product-list', compact('products'))->render();
        }

        return view('frontend.pages.shop.shop', compact('products', 'perPage', 'from', 'to'));
    }

    private function getFilteredProducts(Request $request, $query)
    {
        $perPage = $request->get('limit', config('website_settings.item_per_page'));

        // Price range filter
        $from = $request->input('from', 0);
        $to = $request->input('to', 500000);

        if ($request->filled('filter_price')) {
            [$minPrice, $maxPrice] = explode('-', $request->filter_price);
            $from = (int) $minPrice;
            $to = (int) $maxPrice;
            $query->whereBetween('offer_price', [$from, $to]);
        }

        // Sorting
        if ($request->filled('sort')) {
            $column = $request->sort;
            $direction = $request->get('order', 'ASC');
            $allowedColumns = ['offer_price', 'created_at', 'id'];
            $allowedDirections = ['ASC', 'DESC'];

            if (in_array($column, $allowedColumns) && in_array(strtoupper($direction), $allowedDirections)) {
                $query->orderBy($column, $direction);
            }
        } else {
            $query->orderBy('is_featured', 'asc')->orderBy('id', 'desc');
        }

        // Filters
        if ($request->filled('filter')) {
            $filters = [];
            foreach ($request->filter as $filter) {
                if (strpos($filter, ':') !== false) {
                    [$key, $value] = explode(':', $filter, 2);
                    $filters[$key][] = $value;
                }
            }

            foreach ($filters as $key => $values) {
                switch ($key) {
                    case 'brand':
                        $query->whereIn('brand_id', $values);
                        break;
                    default:
                        $query->whereHas('filterValues', function ($q) use ($values) {
                            $q->whereIn('filter_option_values.id', $values);
                        });
                        break;
                }
            }
        }

        // Paginate
        $products = $query->paginate($perPage)->appends($request->except('page'));

        return [$products, $perPage, $from, $to];
    }

    public function categoryProduct(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)->where('status', 1)->firstOrFail();

        $query = Product::activeProducts()->where('category_id', $category->id);

        [$products, $perPage, $from, $to] = $this->getFilteredProducts($request, $query);

        $filters = FilterOption::whereHas('categories', function ($q) use ($category) {
            $q->where('categories.id', $category->id);
        })
            ->orWhereDoesntHave('categories')
            ->with('categories')
            ->get();

        if ($request->ajax()) {
            return view('frontend.pages.shop.product-list', compact('products'))->render();
        }

        return view('frontend.pages.shop.category-product', compact('category', 'slug', 'products', 'perPage', 'from', 'to', 'filters'));
    }

    public function subcategoryProduct(Request $request, string $parent_slug, string $slug)
    {
        $parentCategory = Category::where('slug', $parent_slug)->where('status', 1)->firstOrFail();
        $category = Subcategory::where('slug', $slug)->where('category_id', $parentCategory->id)->where('status', 1)->firstOrFail();

        $query = Product::activeProducts()->where('subcategory_id', $category->id);

        [$products, $perPage, $from, $to] = $this->getFilteredProducts($request, $query);

        $filters = FilterOption::whereHas('categories', function ($q) use ($parentCategory) {
            $q->where('categories.id', $parentCategory->id);
        })
            ->orWhereDoesntHave('categories')
            ->with('categories')
            ->get();

        if ($request->ajax()) {
            return view('frontend.pages.shop.product-list', compact('products'))->render();
        }

        return view('frontend.pages.shop.subcategory-product', compact('category', 'slug', 'products', 'perPage', 'from', 'to', 'parentCategory', 'filters'));
    }

    public function subsubcategoryProduct(Request $request, string $parent_slug, string $parentsub_slug, string $slug)
    {
        $parentCategory = Category::where('slug', $parent_slug)->where('status', 1)->firstOrFail();
        $parentSubCategory = Subcategory::where('slug', $parentsub_slug)->where('status', 1)->firstOrFail();
        $category = SubSubcategory::where('slug', $slug)->where('subcategory_id', $parentSubCategory->id)->where('status', 1)->firstOrFail();

        $query = Product::activeProducts()->where('subsubcategory_id', $category->id);

        [$products, $perPage, $from, $to] = $this->getFilteredProducts($request, $query);

        $filters = FilterOption::whereHas('categories', function ($q) use ($parentCategory) {
            $q->where('categories.id', $parentCategory->id);
        })
            ->orWhereDoesntHave('categories')
            ->with('categories')
            ->get();

        if ($request->ajax()) {
            return view('frontend.pages.shop.product-list', compact('products'))->render();
        }

        return view('frontend.pages.shop.subsubcategory-product', compact('category', 'slug', 'products', 'perPage', 'from', 'to', 'parentCategory', 'filters'));
    }

    public function searchProducts(Request $request)
    {
        $searchTerm = $request->get('query');

        if (empty($searchTerm)) {
            return redirect()->route('shop');
        }

        $categories = Category::where('status', 1)->where('name', 'like', '%' . $searchTerm . '%')->get();

        $perPage = $request->get('limit', config('website_settings.item_per_page'));

        // Base query
        $query = Product::activeProducts()
            ->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhereHas('tags', function ($tagQuery) use ($searchTerm) {
                        $tagQuery->where('name', 'like', "%{$searchTerm}%");
                    });
            });

        // Sorting
        if ($request->filled('sort')) {
            $column = $request->sort;
            $direction = $request->get('order', 'ASC');

            $allowedColumns = ['offer_price', 'created_at', 'id'];
            $allowedDirections = ['ASC', 'DESC'];

            if (in_array($column, $allowedColumns) && in_array(strtoupper($direction), $allowedDirections)) {
                $query->orderBy($column, $direction);
            }
        } else {
            $query->orderBy('is_featured', 'asc')->orderBy('id', 'desc');
        }

        $count = $query->count();

        // Pagination
        $products = $query->paginate($perPage)->appends($request->except('page'));

        // Ajax load
        if ($request->ajax()) {
            return view('frontend.pages.shop.category-product-list', compact('products'))->render();
        }

        return view('frontend.pages.shop.search-product', compact('products', 'perPage', 'searchTerm', 'categories', 'count'));
    }

    // product details page
    public function productDetails(string $slug)
    {
        if ($slug) {
            $product = Product::activeProducts()
                ->where('slug', $slug)
                ->with([
                    'specifications',
                    'category:id,name,slug,image',
                    'brand:id,name',
                    'galleryImages:id,product_id,image',
                    'tags:id,product_id,name',
                    'productStock:id,product_id',
                    'productStock.attributeOptions:id,product_stock_id,attribute_id,attribute_value_id'
                ])
                ->first();

            // Check if the product exists and is active
            if (!$product) {
                return redirect()->back()->with('error', 'The product is not available.');
            }
        }

        return view('frontend.pages.product.details', compact('product'));
    }

    // product wishlist
    public function wishlist()
    {
        return view('frontend.pages.shop.wishlist');
    }

    public function compare(Request $request)
    {
        $ids = $request->get('ids', '');

        if ($ids !== '') {
            $newIds = array_filter(explode(',', $ids));
            $compare = session()->get('compare_products', []);
            foreach ($newIds as $id) {
                if (!in_array($id, $compare))
                    $compare[] = $id;
            }
            $compare = array_slice($compare, -3);
            session()->put('compare_products', $compare);
        } else {
            $compare = session()->get('compare_products', []);
        }

        $products = empty($compare)
            ? collect()
            : Product::with([
                'productStock.attributeOptions.attribute',
                'productStock.attributeOptions.attributeValue',
                'specifications',
            ])->whereIn('id', $compare)
                ->orderByRaw('FIELD(id,' . implode(',', $compare) . ')')
                ->get();

        // collect all attributes (variants)
        $allAttributes = collect();
        foreach ($products as $product) {
            foreach ($product->productStock as $stock) {
                foreach ($stock->attributeOptions as $option) {
                    $allAttributes->put($option->attribute->id, $option->attribute->attr_name);
                }
            }
        }

        // collect all specification groups + names
        $allSpecifications = collect();
        foreach ($products as $product) {
            foreach ($product->specifications as $spec) {
                $allSpecifications
                    ->put($spec->group, collect())
                    ->put($spec->group, $allSpecifications->get($spec->group)->put($spec->name, $spec->name));
            }
        }

        return view('frontend.pages.product.compare', [
            'products' => $products,
            'compareProducts' => $products,
            'allAttributes' => $allAttributes,
            'allSpecifications' => $allSpecifications,
        ]);
    }

    public function fullCompare(Request $request)
    {
        $ids = $request->get('ids', '');
        $compareIds = array_filter(explode(',', $ids));

        $products = Product::with([
            'productStock.attributeOptions.attribute',
            'productStock.attributeOptions.attributeValue',
            'specifications',
        ])->whereIn('id', $compareIds)
            ->orderByRaw('FIELD(id,' . implode(',', $compareIds) . ')')
            ->get();

        $allAttributes = collect();
        foreach ($products as $product) {
            foreach ($product->productStock as $stock) {
                foreach ($stock->attributeOptions as $option) {
                    $allAttributes->put($option->attribute->id, $option->attribute->attr_name);
                }
            }
        }

        // collect all specification groups + names
        $allSpecifications = collect();
        foreach ($products as $product) {
            foreach ($product->specifications as $spec) {
                $allSpecifications
                    ->put($spec->group, collect())
                    ->put($spec->group, $allSpecifications->get($spec->group)->put($spec->name, $spec->name));
            }
        }

        return view('frontend.pages.product.compare', [
            'products' => $products,
            'compareProducts' => $products,
            'allAttributes' => $allAttributes,
            'allSpecifications' => $allSpecifications,
        ]);
    }

    public function removeCompare($id)
    {
        $compare = session()->get('compare_products', []);

        // Remove both string and int representation
        $compare = array_values(array_diff($compare, [(string) $id, (int) $id]));

        session()->put('compare_products', $compare);

        $ids = implode(',', $compare);

        return redirect()->route('compare', ['ids' => $ids]);
    }
}
