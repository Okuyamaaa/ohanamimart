<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        if($keyword !== null){
            $products = Product::where('name', 'like', "%{$keyword}%")->paginate(15);
            $total = $product->total();
        } else {
            $products = Product::paginate(15);
            $total = $products->total();
        }

        return view('admin.products.index', compact('keyword', 'products', 'total'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
       return view('admin.products.show', compact('product'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return to_route('admin.products.index')->with('flash_message', '商品を削除しました。');
    }
}
