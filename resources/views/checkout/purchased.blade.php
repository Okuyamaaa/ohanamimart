@extends('layouts.app')
 
 @section('content')
 <div class="container ohanami-container pb-5">
        <div class="row justify-content-center">
            <div class="col-xxl-7 col-xl-8 col-lg-9 col-md-11">
                <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">購入履歴</li>
                    </ol>
                </nav>
             <h1 class="mb-5">購入履歴</h1>
 
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
                             @foreach ($purchased_products as $purchased_product)
                                 <div class="row align-items-center mb-2">
                                     <div class="col-md-3">
                                         <a href="{{ route('products.show', $purchased_product->id) }}">
                                             @if ($purchased_product->image)
                                                 <img src="{{ asset($purchased_product->image) }}" class="img-thumbnail">
                                             @else
                                                 <img src="{{ asset('/images/no_image.jpg')}}" class="img-thumbnail">
                                             @endif
                                         </a>
                                     </div>
                                     <div class="col-md-9">
                                         <div class="flex-column">
                                             <p class="fs-5 mb-2">
                                                 <a href="{{ route('products.show', $purchased_product->id) }}" class="link-dark text-decoration-none">{{ $purchased_product->name }}</a>
                                             </p>
                                             <div class="row">
                                            
                                                 <div class="col-xxl-9">
                                                     価格：￥{{ $purchased_product->price }}
                                                 </div>
                                             </div>
                                             <div class="row">
                                            
                                             <div class="col-xxl-9">
                                               <a href="{{route('user.show', $purchased_product->user_id)}}"> {{ $purchased_product->user->name }}</a>
                                             </div>

                                             <div class="col-xxl-9">
                                               <a href="{{route('reviews.create', $purchased_product->user_id)}}">レビューを書く</a>
                                             </div>
                                   
                                        </div>
                                         </div>
                                     </div>
                                     
                                 </div>
                             @endforeach
                         @endif
                     </div>
                 </div>
              </div>
         </div>
     </div>
 </div>
 @endsection