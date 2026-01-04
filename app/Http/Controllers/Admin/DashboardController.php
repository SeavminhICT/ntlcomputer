<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $inStock = Product::where('stock', '>', 0)->count();
        $outOfStock = Product::where('stock', '<=', 0)->count();

        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'inStock' => $inStock,
            'outOfStock' => $outOfStock,
        ]);
    }
}
