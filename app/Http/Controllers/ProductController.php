<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            '掲載日が新しい順' => 'created_at desc',
            '価格が安い順' => 'price asc'
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
    public function create(Product $product)
    {
        $user_id = Auth::id();
        $categories = Category::all();

        $category_ids = $product->categories->pluck('id')->toArray();

            return view('products.create', compact('product', 'categories', 'category_ids'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
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
        $product->image = $image;
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->user_id = Auth::id();
        $product->save();

        $category_ids = array_filter($request->input('category_ids'));
        $product->categories()->sync($category_ids);

        return to_route('products.index')->with('flash_message','商品を追加しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, User $user)
    {
        //  $user = Auth::id();
        // $user_products = Product::with('user')->where($product->user_id)->get();
        // $user_products = Product::with(['user' => function ($query) {
        //     $query->where('user_id', $user->id);
        // }])->get();
        $users = $product->user_id;
        $user_products = Product::where('user_id', $user->id);
        // var_dump($user_products);exit;
        return view('products.show', compact('product', 'user_products', 'user', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $user_id = Auth::id();
        $categories = Category::all();

        $category_ids = $product->categories->pluck('id')->toArray();

        if($product->user_id !== $user_id){
            return to_route('products.index', $product)->with('error_message', '不正なアクセスです。');
        }
            return view('products.edit', compact('product', 'categories', 'category_ids'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'image|max:2040',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        $product->name = $request->input('name');

        $image = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');
        }
        $product->image = $image;
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->user_id = Auth::id();
        $product->update();

        $category_ids = array_filter($request->input('category_ids'));
        $product->categories()->sync($category_ids);

        return to_route('products.index')->with('flash_message','商品を編集しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return to_route('products.index')->with('flash_message', '商品を削除しました。');
    }
}
