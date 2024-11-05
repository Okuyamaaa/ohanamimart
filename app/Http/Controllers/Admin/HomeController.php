<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $total_users = User::all()->count();

        $total_products = Product::all()->count();

        $products = Product::all();

        $transaction = Product::where('purchaser_id', '!=', 'null')->count();


        return view('admin.home', compact('products', 'total_users', 'total_products', 'transaction'));

    }
}
