<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Product $product){

      $user = Auth::user();
       $cart_products = Cart::where('user_id', $user->id)->paginate(15);

       $total = 0;
       $total_product = $cart_products->total();
 
       foreach ($cart_products as $c) {
           $total += $c->product->price;
           
       }
        
        return view('cart.index', compact('cart_products', 'total', 'product', 'user', 'total_product'));
    }

    public function store(Product $product){

        $cart = new Cart();
        $cart->product_id = $product->id;
        $cart->user_id = Auth::id();
        $cart->save();
       

        return back()->with('flash_message', 'カートに追加しました。');
    }

    public function destroy(Cart $cart){
       
        $cart->delete();

        return back()->with('flash_message', 'カートから削除しました。');
    }
}