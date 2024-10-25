@extends('layouts.app')

@section('content')
<!-- レビューの削除用モーダル -->
<div class="modal fade" id="deleteReviewModal" tabindex="-1" aria-labelledby="deleteReviewModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteReviewModalLabel">商品を削除してもよろしいですか？</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-footer">
                <form action="" method="post" name="deleteReviewForm">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn text-white shadow-sm nagoyameshi-btn-danger">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <div class="container nagoyameshi-container pb-5">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
                <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">店舗一覧</a></li>
                        <li class="breadcrumb-item active" aria-current="page">店舗詳細</li>
                    </ol>
                </nav>

                <h1 class="mb-2 text-center">{{ $product->name }}</h1>
                <p class="text-center">
                    <span class="nagoyameshi-star-rating me-1" data-rate="{{ round($product->reviews->avg('score') * 2) / 2 }}"></span>
                    {{ number_format(round($product->reviews->avg('score'), 2), 2) }}（{{ $product->reviews->count() }}件）
                </p>

                @if (session('flash_message'))
                    <div class="alert alert-info" role="alert">
                        <p class="mb-0">{{ session('flash_message') }}</p>
                    </div>
                @endif

                @if($product->user_id === Auth::id())
                <ul class="nav nav-tabs mb-2">
                    <li class="nav-item">
                        <a class="nav-link active text-white nagoyameshi-bg" aria-current="page" href="{{ route('products.show', $product) }}">詳細</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-dark" href="{{route('products.edit', $product)}}">編集</a>
                    </li>
                </ul>
                @endif

                <div class="mb-2">
                    @if ($product->image !== '')
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-100">
                    @else
                        <img src="{{ asset('/images/no_image.jpg') }}" class="w-100">
                    @endif
                </div>

                <div class="container">
                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-2">
                            <span class="fw-bold">商品名</span>
                        </div>

                        <div class="col">
                            <span>{{ $product->name }}</span>
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-2">
                            <span class="fw-bold">説明</span>
                        </div>

                        <div class="col">
                            <span>{{ $product->description }}</span>
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-2">
                            <span class="fw-bold">価格</span>
                        </div>

                        <div class="col">
                            <span>{{ number_format($product->price) }}円</span>
                        </div>
                    </div>


                    <div class="row pb-2 mb-4 border-bottom">
                        <div class="col-2">
                            <span class="fw-bold">カテゴリ</span>
                        </div>

                        <div class="col d-flex">
                            @if ($product->categories()->exists())
                                @foreach ($product->categories as $index => $category)
                                    <div>
                                        @if ($index === 0)
                                            {{ $category->name }}
                                        @else
                                            {{ '、' . $category->name }}
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <span>未設定</span>
                            @endif
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-2">
                            <span class="fw-bold">出品者</span>
                        </div>
                        
                        <div class="col">
                        @if($product->user_id !== Auth::id())
                            <a href = "{{ route('user.show', $users)}}">{{ $product->user->name }}</a>
                        @else
                            <a href = "{{ route('user.index')}}">{{ $product->user->name }}</a>
                        </div>
                        @endif
                    </div>


                </div>
                
                    @guest
                        <form action="{{ route('favorites.store', $product->id) }}" method="post" class="text-center">
                            @csrf
                            <button type="submit" class="btn text-white shadow-sm w-50 nagoyameshi-btn">♥ いいね！</button>
                        </form>
                    @else

                    @if($product->user_id !== Auth::id())
                     
                        @if (Auth::user()->favorite_products()->where('product_id', $product->id)->doesntExist())
                            <form action="{{ route('favorites.store', $product->id) }}" method="post" class="text-center">
                                @csrf
                                <button type="submit" class="btn text-white shadow-sm w-50 nagoyameshi-btn">♥ いいね！</button>
                            </form>
                        @else
                            <form action="{{ route('favorites.destroy', $product->id) }}" method="post" class="text-center">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-primary shadow-sm w-50 nagoyameshi-remove-favorite-button">♥ いいね！解除</button>
                            </form>
                        @endif
                      

                    @endif
                    @endguest


                         @if($product->user_id !== Auth::id())
                     
                        @if ($cart->doesntExist())
                            <form action="{{ route('cart.store', $product->id) }}" method="post" class="text-center">
                                @csrf
                                <button type="submit" class="btn text-white shadow-sm w-50 nagoyameshi-btn">カートに入れる</button>
                            </form>
                        @else
                            <form action="{{ route('cart.destroy', $product->id) }}" method="post" class="text-center">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-primary shadow-sm w-50 nagoyameshi-remove-favorite-button">カートから解除</button>
                            </form>
                        @endif
                      

                    @endif
                    
            </div>
        
        </div>
    </div>
@endsection