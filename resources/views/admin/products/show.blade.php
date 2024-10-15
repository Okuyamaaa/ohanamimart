@extends('layouts.app')

@section('content')
    <!-- 店舗の削除用モーダル -->
    <div class="modal fade" id="deleteRestaurantModal" tabindex="-1" aria-labelledby="deleteRestaurantModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRestaurantModalLabel">「{{ $product->name }}」を削除してもよろしいですか？</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.products.destroy', $product) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn text-white shadow-sm nagoyameshi-btn-danger">削除</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-9">
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">商品一覧</a></li>
                        <li class="breadcrumb-item active" aria-current="page">商品詳細</li>
                    </ol>
                </nav>

                <h1 class="mb-4 text-center">{{ $product->name }}</h1>

                <div class="d-flex justify-content-end align-items-end mb-3">
                    <div>
                        <a href="{{ route('admin.products.edit', $product) }}" class="me-2">編集</a>
                        <a href="#" class="link-secondary" data-bs-toggle="modal" data-bs-target="#deleteRestaurantModal">削除</a>
                    </div>
                </div>

                @if (session('flash_message'))
                    <div class="alert alert-info" role="alert">
                        <p class="mb-0">{{ session('flash_message') }}</p>
                    </div>
                @endif

                <div class="mb-2">
                    @if ($product->image !== '')
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-100">
                    @else
                        <img src="{{ asset('/images/no_image.jpg') }}" class="w-100">
                    @endif
                </div>

                <div class="container mb-4">
                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-2">
                            <span class="fw-bold">ID</span>
                        </div>

                        <div class="col">
                            <span>{{ $product->id }}</span>
                        </div>
                    </div>

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
                            <span>{{ $product->price }}円</span>
                        </div>
                    </div>

                   

                    <div class="row pb-2 mb-2 border-bottom">
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
                </div>
            </div>
        </div>
    </div>
@endsection