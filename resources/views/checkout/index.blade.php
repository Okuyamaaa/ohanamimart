@extends('layouts.app')
 
 @section('content')
 <div class="container ohanami-container pb-5">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9 col-md-11">
                <nav class="my-3 col-xxl-10" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">カート一覧</a></li>
                        <li class="breadcrumb-item active" aria-current="page">ご注文内容</li>
                    </ol>
                </nav>
             <h1 class="mb-5">ご注文内容</h1>
 
             <h5 class="fw-bold mb-3">購入商品</h5>
 
             <div class="row justify-content-between">
                 <div class="col-lg-7">
                     <hr class="mt-0 mb-4">
 
                     <div class="mb-5">
                     @if($total_product == 0)
                             <div class="row">
                                 <p class="mb-0">カートの中身は空です。</p>
                             </div>
                         @else
                             @foreach ($cart_products as $cart_product)
                                 <div class="row align-items-center mb-2">
                                     <div class="col-md-3">
                                         <a href="{{ route('products.show', $cart_product->product_id) }}">
                                             @if ($cart_product->product->image)
                                                 <img src="{{ asset($cart_product->product->image) }}" class="img-thumbnail">
                                             @else
                                                 <img src="{{ asset('/images/no_image.jpg')}}" class="img-thumbnail">
                                             @endif
                                         </a>
                                     </div>
                                     <div class="col-md-9">
                                         <div class="flex-column">
                                             <p class="fs-5 mb-2">
                                                 <a href="{{ route('products.show', $cart_product->product_id) }}" class="link-dark text-decoration-none">{{ $cart_product->product->name }}</a>
                                             </p>
                                             <div class="row mb-2">
                                            
                                                 <div class="col-xxl-9">
                                                     価格：￥{{ $cart_product->product->price }}
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             @endforeach
                         @endif
                     </div>
 
                     <h5 class="fw-bold mb-3">お届け先</h5>
 
                     <hr class="mb-4">
 
                     <div class="mb-5">
                         <p class="mb-2">{{ Auth::user()->name }} 様</p>
                         <p class="mb-2">〒{{ Auth::user()->postal_code . ' ' . Auth::user()->address }}</p>
                         <p class="mb-2">{{ Auth::user()->phone }}</p>
                         <p>{{ Auth::user()->email }}</p>
                     </div>
                 </div>
                 <div class="col col-xxl-4">
                    @if($total_product == 0)
                    @elseif($total_product >= 5)
                     <div class="bg-white p-4 mb-4">
                         <div class="row mb-2">
                             <div class="col-md-5">
                                 小計
                             </div>
                             <div class="col-md-7">
                             ￥{{ number_format($total) }}
                             </div>
                         </div>
 
                         <div class="row mb-3">
                             <div class="col-md-5">
                                 送料
                             </div>
                             <div class="col-md-7">
                             ￥1000
                             </div>
                         </div>
 
                         <div class="row">
                             <div class="col-5">
                                 <span class="fs-5 fw-bold">合計</span>
                             </div>
                             <div class="col-7 d-flex align-items-center">
                                 <span class="fs-5 fw-bold">￥{{ number_format($total+1000) }}</span><span class="small">（税込）</span>
                             </div>
                         </div>
                     </div>
                     @else
                     <div class="bg-white p-4 mb-4">
                         <div class="row mb-2">
                             <div class="col-md-5">
                                 小計
                             </div>
                             <div class="col-md-7">
                             ￥{{ number_format($total) }}
                             </div>
                         </div>
 
                         <div class="row mb-3">
                             <div class="col-md-5">
                                 送料
                             </div>
                             <div class="col-md-7">
                             ￥500
                             </div>
                         </div>
 
                         <div class="row">
                             <div class="col-5">
                                 <span class="fs-5 fw-bold">合計</span>
                             </div>
                             <div class="col-5 d-flex align-items-center">
                                 <span class="fs-5 fw-bold">￥{{ number_format($total+500) }}</span>
                                 <span class="small">（税込）</span>
                             </div>
                         </div>
                     </div>
                     @endif
 
                     <div class="mb-4">
                         @if ($total > 0 && DB::table('products')->find($product->purchaser_id) == null)
                             <form action="{{ route('checkout.store') }}" method="POST">
                                 @csrf
                                 <button type="submit" class="btn text-white shadow-sm w-20 ohanami-btn">お支払い</a>
                             </form>
                         @else
                             <button class="btn text-white shadow-sm w-20 ohanami-btn disabled">お支払い</button>
                             <br>
                             <span class="text-danger">購入品がないか、すでに購入されている商品が選択されています。</span>
                             
                         @endif
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection