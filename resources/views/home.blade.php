@extends('layouts.app')

@push('fonts')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@400;600&display=swap" rel="stylesheet">
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="{{ asset('/js/carousel.js') }}"></script>
@endpush

@section('content')
    <div>
        <div class="swiper ohanami-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="{{ asset('/images/rebon.jpg') }}"></div>
                <div class="swiper-slide"><img src="{{ asset('/images/color.jpg') }}"></div>
                <div class="swiper-slide"><img src="{{ asset('/images/ball.jpg') }}"></div>
                <div class="swiper-slide"><img src="{{ asset('/images/main4.jpg') }}"></div>
                <div class="d-flex align-items-center ohanami-overlay-background">
                    <div class="container ohanami-container ohanami-overlay-text">
                        <h1 class="text-white ohanami-catchphrase-heading">ただひとつの手作りを、<br>あなたに</h1>
                        <p class="text-white ohanami-catchphrase-paragraph">おはなみマートは、<br>ハンドメイド品専用ショッピングサイトです。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('flash_message'))
        <div class="container ohanami-container my-3">
            <div class="alert alert-info" role="alert">
                <p class="mb-0">{{ session('flash_message') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-light mb-4 py-4">
        <div class="container ohanami-container">
            <h2 class="mb-3">キーワードから探す</h2>
            <form method="GET" action="{{ route('products.index') }}" class="ohanami-user-search-box">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="店舗名・エリア・カテゴリ" name="keyword">
                    <button type="submit" class="btn text-white shadow-sm ohanami-btn">検索</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container ohanami-container">
    <h2 class="mb-3">カテゴリから探す</h2>
        <div class="row row-cols-xl-6 row-cols-md-3 row-cols-2 g-3 mb-3">
            <div class="col">
                <a href="{{ url("/products/?category_id={$categories->where('name', 'バッグ')->value('id')}") }}" class="ohanami-card-link">
                    <div class="card text-white">
                        <img src="{{ asset('/images/bag.jpg') }}" class="card-img ohanami-vertical-card-image" alt="バッグ">
                        <div class="card-img-overlay d-flex justify-content-center align-items-center ohanami-overlay-background">
                            <h3 class="card-title ohanami-category-name">バッグ</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="{{ url("/products/?category_id={$categories->where('name', '巾着')->value('id')}") }}" class="ohanami-card-link">
                    <div class="card text-white">
                        <img src="{{ asset('/images/pochi.jpg') }}" class="card-img ohanami-vertical-card-image" alt="巾着">
                        <div class="card-img-overlay d-flex justify-content-center align-items-center ohanami-overlay-background">
                            <h3 class="card-title ohanami-category-name">巾着</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="{{ url("/products/?category_id={$categories->where('name', '財布')->value('id')}") }}" class="ohanami-card-link">
                    <div class="card text-white">
                        <img src="{{ asset('/images/saifu.jpg') }}" class="card-img ohanami-vertical-card-image" alt="財布">
                        <div class="card-img-overlay d-flex justify-content-center align-items-center ohanami-overlay-background">
                            <h3 class="card-title ohanami-category-name">財布</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="{{ url("/products/?category_id={$categories->where('name', '手芸')->value('id')}") }}" class="ohanami-card-link">
                    <div class="card text-white">
                        <img src="{{ asset('/images/syugei.jpg') }}" class="card-img ohanami-vertical-card-image" alt="手芸">
                        <div class="card-img-overlay d-flex justify-content-center align-items-center ohanami-overlay-background">
                            <h3 class="card-title ohanami-category-name">手芸</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="{{ url("/products/?category_id={$categories->where('name', 'アクセサリー')->value('id')}") }}" class="ohanami-card-link">
                    <div class="card text-white">
                        <img src="{{ asset('/images/acse.jpg') }}" class="card-img ohanami-vertical-card-image" alt="アクセサリー">
                        <div class="card-img-overlay d-flex justify-content-center align-items-center ohanami-overlay-background">
                            <h3 class="card-title ohanami-category-name">アクセサリー</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col">
                <a href="{{ url("/products/?category_id={$categories->where('name', '置物')->value('id')}") }}" class="ohanami-card-link">
                    <div class="card text-white">
                        <img src="{{ asset('/images/okimono.jpg') }}" class="card-img ohanami-vertical-card-image" alt="置物">
                        <div class="card-img-overlay d-flex justify-content-center align-items-center ohanami-overlay-background">
                            <h3 class="card-title ohanami-category-name">置物</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="mb-5">
            @foreach ($categories as $category)
                @if ($category->name === 'バッグ' || $category->name === '巾着' || $category->name === '財布' || $category->name === '手芸' || $category->name === 'アクセサリー' || $category->name === '置物')
                    @continue
                @else
                    <a href="{{ url("/products/?category_id={$category->id}") }}" class="btn btn-outline-secondary btn-sm me-1 mb-2">{{ $category->name }}</a>
                @endif
            @endforeach
        </div>


    
        <h2 class="mb-3">新着商品</h2>
        <div class="row row-cols-xl-6 row-cols-md-3 row-cols-2 g-3 mb-5">
            @foreach ($user_products as $user_product)
                <div class="col">
                    <a href="{{ route('products.show', $user_product) }}" class="link-dark ohanami-card-link">
                        <div class="card h-100">
                            @if ($user_product->image !== '')
                                <img src="{{ asset('storage/' . $user_product->image) }}" class="card-img-top ohanami-vertical-card-image">
                            @else
                                <img src="{{ asset('/images/no_image.jpg') }}" class="card-img-top ohanami-vertical-card-image" alt="画像なし">
                            @endif
                            <div class="card-body">
                                <h3 class="card-title">{{ $user_product->name }}</h3>
                                
                                @if($user_product->purchaser_id !== null)
                                <div class="text-muted small mb-1">SOLD OUT</div>
                                @else
                                <div class="text-muted small mb-1">￥{{ $user_product->price }}</div>
                                @endif
                                <div class="text-muted small mb-1">
                                    @if ($user_product->categories()->exists())
                                        @foreach ($user_product->categories as $index => $category)
                                            <div class="d-inline-block">
                                                @if ($index === 0)
                                                    {{ $category->name }}
                                                @else
                                                    {{ ' ' . $category->name }}
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <span></span>
                                    @endif
                                </div>
                                <p class="card-text">{{ mb_substr($user_product->description, 0, 25) }}@if (mb_strlen($user_product->description) > 25)...@endif</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
                    {{ $user_products->appends(request()->query())->links() }}
                </div>

      
        <!-- <h2 class="mb-3">新規掲載店</h2>
        <div class="row row-cols-xl-6 row-cols-md-3 row-cols-2 g-3 mb-5">
            @foreach ($new_products as $new_product)
                <div class="col">
                    <a href="{{ route('products.show', $new_product) }}" class="link-dark ohanami-card-link">
                        <div class="card h-100">
                            @if ($new_product->image !== '')
                                <img src="{{ asset('storage/' . $new_product->image) }}" class="card-img-top ohanami-vertical-card-image">
                            @else
                                <img src="{{ asset('/images/no_image.jpg') }}" class="card-img-top ohanami-vertical-card-image" alt="画像なし">
                            @endif
                            <div class="card-body">
                                <h3 class="card-title">{{ $new_product->name }}</h3>
                                <div class="text-muted small mb-1">
                                    @if ($new_product->categories()->exists())
                                        @foreach ($new_product->categories as $index => $category)
                                            <div class="d-inline-block">
                                                @if ($index === 0)
                                                    {{ $category->name }}
                                                @else
                                                    {{ ' ' . $category->name }}
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <span></span>
                                    @endif
                                </div>
                                <p class="card-text">{{ mb_substr($new_product->description, 0, 19) }}@if (mb_strlen($new_product->description) > 19)...@endif</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div> -->
@endsection
