<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\SizeGuide;

class ProductOptionController extends Controller
{
    public function brands()
    {
        $brands = Brand::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'brands' => $brands,
        ]);
    }


    public function categories()
    {
        $categories = Category::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'categories' => $categories,
        ]);
    }


    public function collections()
    {
        $collections = Collection::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'collections' => $collections,
        ]);
    }


    public function sizes()
    {
        $sizes = SizeGuide::query()
            ->select('id', 'size')
            ->orderBy('id')
            ->get();

        return response()->json([
            'sizes' => $sizes,
        ]);
    }
}
