<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max255',
            'image' => 'image|max:2040',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        $product = new Product();
        $product->name = $request->input('name');

        $image = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');
        }
        $product->iamge = $image;
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();

        return to_route('products.index')->with('flash_message','商品を追加しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('addmin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return to_route('admin.products.index')->with('flash_message', '商品を削除しました。');
    }
}
