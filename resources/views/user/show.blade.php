@extends('layouts.app')

@section('content')
<!-- レビューの削除用モーダル -->
<div class="modal fade" id="deleteReviewModal" tabindex="-1" aria-labelledby="deleteReviewModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteReviewModalLabel">レビューを削除してもよろしいですか？</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-footer">
                @foreach($reviews as $review)
                <form action="{{route('reviews.destroy', [$review, $user])}}" method="post" name="deleteReviewForm">
                    @endforeach
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn text-white shadow-sm ohanami-btn-danger">削除</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
<div class="container ohanami-container pb-5">
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


                    <div class="container ohanami-container">
                    <h1 class="mb-8 text-center">--出品商品--</h1>
                    <div class="row row-cols-xl-10 row-cols-md-5 row-cols-10 g-1 mb-1">
                    @foreach ($products as $product)
                    <div class="col mb-1">
                        <a href="{{route('products.show', $product)}}" class="link-dark ohanami-card-link">
                            <div class="card h-1">
                                <div>
                                    <div>
                                        @if ($product->image !== '')
                                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top ohanami-vertical-card-image">
                                        @else
                                            <img src="{{ asset('/images/no_image.jpg') }}" class="card-img-top ohanami-vertical-card-image" alt="画像なし">
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
                                                                {{ $category->name }}
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

@if($review_total !== 0)
<div class="container ohanami-container">
                    <h1 class="mb-8 text-center">--レビュー一覧--</h1>
@foreach ($reviews as $review)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between">
                            
                            <div>
                                {{ $review_user->name}}さん
                            </div>
                            @if ($review->send_user_id === Auth::id())
                                <div>
                                    <a href="{{route('reviews.edit', [$user, $review])}}" class="me-2">編集</a>
                                    <a href="#" class="link-secondary" data-bs-toggle="modal" data-bs-target="#deleteReviewModal" data-review-id="{{ $review->id }}">削除</a>
                                </div>
                            @endif
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><span class="ohanami-star-rating" data-rate="{{ $review->score }}"></span></li>
                            <li class="list-group-item">{{ $review->content }}</li>
                        </ul>
                    </div>
                @endforeach
</div>
@endif
                    
                </div>
            </div>
        </div>
    </div>
@endsection