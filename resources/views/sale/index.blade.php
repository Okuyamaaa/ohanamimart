@extends('layouts.app')

@push('scripts')
  
@endpush

@section('content')
<div class="container ohanami-container pb-5">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9 col-md-11">
                <nav class="my-3 col-xxl-10" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">出品リスト</li>
                    </ol>
                </nav>
             <h1 class="mb-5">出品リスト</h1>
 
             <h5 class="fw-bold mb-3">出品中の商品</h5>
 
             <div class="row justify-content-between">
                 <div class="col-lg-7">
                     <hr class="mt-0 mb-4">
 
                     <div class="mb-5">
                     @if($total_product == 0)
                             <div class="row">
                                 <p class="mb-0">出品中の商品はありませんで。</p>
                             </div>
                         @else
                             @foreach ($user_products as $user_product)
                                 <div class="row align-items-center mb-2">
                                     <div class="col-md-3">
                                         <a href="{{ route('products.show', $user_product->id) }}">
                                             @if ($user_product->image)
                                                 <img src="{{ asset($user_product->image) }}" class="img-thumbnail">
                                             @else
                                                 <img src="{{ asset('/images/no_image.jpg')}}" class="img-thumbnail">
                                             @endif
                                         </a>
                                     </div>
                                     <div class="col-md-9">
                                         <div class="flex-column">
                                             <p class="fs-5 mb-2">
                                                 <a href="{{ route('products.show', $user_product->id) }}" class="link-dark text-decoration-none">{{ $user_product->name }}</a>
                                             </p>
                                             @if($product->purchaser_id == null)
                                             <div class="row mb-2">
                                                 <div class="col-xxl-9">
                                                     価格：￥{{ $user_product->price }}
                                                 </div>
                                             </div>
                                             @else
                                             <div class="row mb-2">
                                                 <div class="col-xxl-9">
                                                     SOLD OUT
                                                 </div>
                                             </div>
                                             @endif

                                         </div>
                                     </div>
                                 </div>
                             @endforeach
                         @endif
                     </div>
       @endsection         