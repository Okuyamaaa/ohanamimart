<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index(User $user, Product $product){
        $user = Auth::user();
        $user_products = Product::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(20);
    
        
        $total_product = $user_products->total();
    
    
         
         return view('sale.index', compact('user_products', 'product', 'user', 'total_product'));
    }
}
