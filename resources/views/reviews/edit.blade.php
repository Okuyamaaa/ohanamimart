@extends('layouts.app')

@section('content')
    <div class="container ohanami-container pb-5">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
                <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('restaurants.index') }}">店舗一覧</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('restaurants.show', $restaurant) }}">店舗詳細</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('restaurants.reviews.index', $restaurant) }}">レビュー</a></li>
                        <li class="breadcrumb-item active" aria-current="page">レビュー編集</li>
                    </ol>
                </nav>

                <h1 class="mb-2 text-center">{{ $restaurant->name }}</h1>
                <p class="text-center">
                    <span class="ohanami-star-rating me-1" data-rate="{{ round($restaurant->reviews->avg('score') * 2) / 2 }}"></span>
                    {{ number_format(round($restaurant->reviews->avg('score'), 2), 2) }}（{{ $restaurant->reviews->count() }}件）
                </p>

                @if (session('flash_message'))
                    <div class="alert alert-info" role="alert">
                        <p class="mb-0">{{ session('flash_message') }}</p>
                    </div>
                @endif

                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a class="nav-link link-dark" href="{{ route('restaurants.show', $restaurant) }}">トップ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-dark" href="{{ route('restaurants.reservations.create', $restaurant) }}">予約</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white ohanami-bg" aria-current="page" href="{{ route('restaurants.reviews.index', $restaurant) }}">レビュー</a>
                    </li>
                </ul>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('restaurants.reviews.update', [$restaurant, $review]) }}">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label class="form-label text-md-left fw-bold">評価</label>

                        <div>
                            <div class="form-check form-check-inline">
                                @if ($review->score === 1)
                                    <input class="form-check-input" id="score1" type="radio" name="score" value="1" checked>
                                @else
                                    <input class="form-check-input" id="score1" type="radio" name="score" value="1">
                                @endif
                                <label class="form-check-label" for="score1">1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                @if ($review->score === 2)
                                    <input class="form-check-input" id="score2" type="radio" name="score" value="2" checked>
                                @else
                                    <input class="form-check-input" id="score2" type="radio" name="score" value="2">
                                @endif
                                <label class="form-check-label" for="score2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                @if ($review->score === 3)
                                    <input class="form-check-input" id="score3" type="radio" name="score" value="3" checked>
                                @else
                                    <input class="form-check-input" id="score3" type="radio" name="score" value="3">
                                @endif
                                <label class="form-check-label" for="score3">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                @if ($review->score === 4)
                                    <input class="form-check-input" id="score4" type="radio" name="score" value="4" checked>
                                @else
                                    <input class="form-check-input" id="score4" type="radio" name="score" value="4">
                                @endif
                                <label class="form-check-label" for="score4">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                @if ($review->score === 5)
                                    <input class="form-check-input" id="score5" type="radio" name="score" value="5" checked>
                                @else
                                    <input class="form-check-input" id="score5" type="radio" name="score" value="5">
                                @endif
                                <label class="form-check-label" for="score5">5</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label text-md-left fw-bold">感想</label>

                        <div>
                            <textarea class="form-control" id="content" name="content" cols="30" rows="5">{{ old('content', $review->content) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-center mb-4">
                        <button type="submit" class="btn text-white shadow-sm w-50 ohanami-btn">更新</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection