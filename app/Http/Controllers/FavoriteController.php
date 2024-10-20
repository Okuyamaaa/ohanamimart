<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index(){

       $favorite_products = Auth::user()->favorite_products()->orderBy('created_at', 'desc')->paginate(15);

        return view('favorites.index', compact('favorite_products'));
    }

    public function store($product_id){

        Auth::user()->favorite_products()->attach($product_id);

        return back()->with('flash_message', 'いいね！しました。');
    }

    public function destroy($product_id){

        Auth::user()->favorite_products()->detach($product_id);

        return back()->with('flash_message', 'いいね！を解除しました。');
    }
}
