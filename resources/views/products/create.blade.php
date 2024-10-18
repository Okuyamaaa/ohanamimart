@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('/js/preview.js') }}"></script>
@endpush

@section('content')
    <div class="col container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-9">
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">商品一覧</a></li>
                        <li class="breadcrumb-item active" aria-current="page">商品登録</li>
                    </ol>
                </nav>

                <h1 class="mb-4 text-center">商品登録</h1>

                <hr class="mb-4">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="name" class="col-md-5 col-form-label text-md-left fw-bold">商品名</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="image" class="col-md-5 col-form-label text-md-left fw-bold">商品画像</label>

                        <div class="col-md-7">
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                    </div>

                    <!-- 選択された画像の表示場所 -->
                    <div class="row" id="imagePreview"></div>

                    <div class="form-group row mb-3">
                        <label for="description" class="col-md-5 col-form-label text-md-left fw-bold">説明</label>

                        <div class="col-md-7">
                            <textarea class="form-control" id="description" name="description" cols="30" rows="5">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="lowest_price" class="col-md-5 col-form-label text-md-left fw-bold">商品価格</label>

                        <div class="col-md-7">
                            <input type='text' class="form-control" id="price" name="price">
                            
                        
                        </div>
                    </div>

                    @for ($i = 0; $i < 3; $i++)
                        <div class="form-group row mb-3">
                            <label for="category{{ $i + 1 }}" class="col-md-5 col-form-label text-md-left fw-bold">カテゴリ{{ $i + 1 }}（3つまで選択可）</label>

                            <div class="col-md-7">
                                <select class="form-control form-select" id="category{{ $i + 1 }}" name="category_ids[]">
                                    <option value="">選択なし</option>
                                    @foreach ($categories as $category)
                                        @if ($category->id == old("category_ids.{$i}"))
                                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                        @else
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endfor

                   
                    <hr class="my-4">

                    <div class="form-group d-flex justify-content-center mb-4">
                        <button type="submit" class="btn text-white shadow-sm w-50 nagoyameshi-btn">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection