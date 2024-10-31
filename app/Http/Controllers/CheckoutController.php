<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index(Product $product, Cart $cart)
    {
        $user = Auth::user();
        $cart_products = Cart::where('user_id', $user->id)->paginate(50);
 
       
        $total = 0;
        $total_product = $cart_products->total();
       
        foreach ($cart_products as $c) {
            $total += $c->product->price;
         
        }

  

        return view('checkout.index', compact('cart_products', 'total', 'product', 'user', 'total_product'));
    }

    public function store(Product $product, Cart $cart, Request $request)
    {
        $user = Auth::user();
        $cart_products = Cart::where('user_id', $user->id)->paginate(50);
        $total_product = $cart_products->total();
        

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $line_items = [];

        foreach ($cart_products as $cart_product) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $cart_product->product->name,
                    ],
                    'unit_amount' => $cart_product->product->price,
                ],
                'quantity' => 1,
            ];
        }
        if ($total_product == 0) {
        }else if($total_product >= 5){
            $line_items[] = [
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => '送料',
                    ],
                    'unit_amount' => 1000,
                ],
                'quantity' => 1,
            ];
        }else{
            $line_items[] = [
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => '送料',
                    ],
                    'unit_amount' => 500,
                ],
                'quantity' => 1,
            ];
        }



        $checkout_session = Session::create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.index'),
        ]);

        return redirect($checkout_session->url);
    }

    public function success()
    {
        $user = Auth::user();
        $user_shoppingcarts = DB::table('carts')->get();


        $cart_products = Cart::where('user_id', $user->id)->paginate(50);

foreach($cart_products as $cart_product){
        Product::where('id', $cart_product->product_id)->update([
            'purchaser_id' => $user->id,
            'purchased_date' => date("Y/m/d H:i:s")
        ]);
    }

        Cart::where('user_id', Auth::user()->id)->delete();
        return view('checkout.success');
    }
    
    public function purchased(Product $product){
        $user = Auth::user();
        $purchased_products = Product::where('purchaser_id', $user->id)->paginate(50);
 
       
        
        $total_product = $purchased_products->total();
       


  

        return view('checkout.purchased', compact('purchased_products', 'product', 'user', 'total_product'));
    }
}
