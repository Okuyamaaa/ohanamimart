<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $category_id = $request->category_id;
        $price = $request->price;
        $categories = Category::all();

        $sorts = [
            '掲載日が新しい順' => 'created_at desc'
        ];


        $sort_query = [];
        $sorted = "created_at desc";
        
        if ($request->has('select_sort')) {
            $slices = explode(' ', $request->input('select_sort'));
            $sort_query[$slices[0]] = $slices[1];
            $sorted = $request->input('select_sort');
        }
        $products = Product::sortable($sort_query)->orderBy('created_at', 'desc')->paginate(15);

        if($keyword !== null){
            $products = Product::where('name', 'like', "%{$keyword}%")->orWhereHas('categories', function($query) use ($keyword){
                $query->where('categories.name', 'like', "%{$keyword}%"); })->sortable($sort_query)->orderBy('created_at', 'desc')->paginate(15);
            $total = $products->total();
            } elseif ($category_id !== null){
                $products = product::whereHas('categories', function ($query) use ($category_id) {
                    $query->where('categories.id', '=', "{$category_id}");
                })->sortable($sort_query)->orderBy('created_at', 'desc')->paginate(15);
                $total = $products->total();
            } elseif($price !== null){
                $products = product::where('price', '<=', "{$price}")->sortable($sort_query)->orderBy('created_at', 'desc')->paginate(15);
                $total = $products->total();
            }else {
            $products = Product::sortable($sort_query)->orderBy('created_at', 'desc')->paginate(15);
            $total = $products->total();
        }


        return view('products.index', compact('keyword', 'products', 'total','categories', 'sorted', 'category_id', 'price', 'sorts'));
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
        return view('products.show', compact('product'));
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
        return to_route('products.index')->with('flash_message', '商品を削除しました。');
    }
}
