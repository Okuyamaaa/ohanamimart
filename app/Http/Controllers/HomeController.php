<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $user_products = Product::paginate(30);
        $categories = Category::all();
        $new_products = Product::orderBy('created_at', 'desc')->take(6)->get();

        return view('home', compact('user_products', 'categories', 'new_products'));
    }
}
