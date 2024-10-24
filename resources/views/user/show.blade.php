@extends('layouts.app')

@section('content')
<div class="container nagoyameshi-container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">会員情報</li>
                    </ol>
                </nav>

                <h1 class="mb-4 text-center">{{ $user->name }}</h1>

                <div class="container mb-4">

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">氏名</span>
                        </div>

                        <div class="col">
                            <span>{{ $user->name }}</span>
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">フリガナ</span>
                        </div>

                        <div class="col">
                            <span>{{ $user->kana }}</span>
                        </div>
                    </div>


                    <div class="container nagoyameshi-container">
                    <h1 class="mb-8 text-center">--出品商品--</h1>
                    <div class="row row-cols-xl-10 row-cols-md-5 row-cols-10 g-1 mb-1">
                    @foreach ($products as $product)
                    <div class="col mb-1">
                        <a href="{{route('products.show', $product)}}" class="link-dark nagoyameshi-card-link">
                            <div class="card h-1">
                                <div>
                                    <div>
                                        @if ($product->image !== '')
                                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top nagoyameshi-vertical-card-image">
                                        @else
                                            <img src="{{ asset('/images/no_image.jpg') }}" class="card-img-top nagoyameshi-vertical-card-image" alt="画像なし">
                                        @endif
                                    </div>
                                    <div>
                                        <div class="card-body">
                                            <h3 class="card-title mb-1">{{ $product->name }}</h3>
                                            <h3 class="card-title mb-1">{{ $product->price }}円</h3>
                                            <div class="col d-flex text-secondary">
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
                                                    <span></span>
                                                @endif
                                            </div>
                                            <hr class="my-2">
                                          
                                            <p class="card-text">{{ mb_substr($product->description, 0, 20) }}@if (mb_strlen($product->description) > 20)...@endif</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
</div>
</div>


@foreach ($reviews as $review)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <div>
                                {{ $review->user->name }}さん
                            </div>
                            @if ($review->user_id === Auth::id())
                                <div>
                                    <a href="#" class="me-2">編集</a>
                                    <a href="#" class="link-secondary" data-bs-toggle="modal" data-bs-target="#deleteReviewModal" data-review-id="{{ $review->id }}">削除</a>
                                </div>
                            @endif
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><span class="nagoyameshi-star-rating" data-rate="{{ $review->score }}"></span></li>
                            <li class="list-group-item">{{ $review->content }}</li>
                        </ul>
                    </div>
                @endforeach

                    
                </div>
            </div>
        </div>
    </div>
@endsection