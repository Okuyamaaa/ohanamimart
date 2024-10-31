@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('/js/favorite-modal.js') }}"></script>
@endpush

@section('content')
    <!-- お気に入りの解除用モーダル -->
    <div class="modal fade" id="removeFavoriteModal" tabindex="-1" aria-labelledby="removeFavoriteModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeFavoriteModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-footer">
                    <form action="" method="post" name="removeFavoriteForm">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn text-white shadow-sm ohanami-btn-danger">解除</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container ohanami-container pb-5">
        <div class="row justify-content-center">
            <div class="col-xxl-7 col-xl-8 col-lg-9 col-md-11">
                <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">お気に入り一覧</li>
                    </ol>
                </nav>

                <h1 class="mb-3 text-center">お気に入り一覧</h1>

                @if (session('flash_message'))
                    <div class="alert alert-info" role="alert">
                        <p class="mb-0">{{ session('flash_message') }}</p>
                    </div>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">商品名</th>
                            <th scope="col">カテゴリ</th>
                            <th scope="col">価格</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($favorite_products as $favorite_product)
                            <tr>
                                <td>
                                    <a href="{{ route('products.show', $favorite_product) }}">
                                        {{ $favorite_product->name }}
                                    </a>
                                </td>
                                <td>                        <div class="col d-flex">
                            @if ($favorite_product->categories()->exists())
                                @foreach ($favorite_product->categories as $index => $category)
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
                        </div></td>
                                <td>{{ $favorite_product->price }}</td>
                                @if (DB::table('carts')->where('product_id', $favorite_product->id)->doesntExist())
                                <td> 
                            <form action="{{ route('cart.store', $favorite_product->id) }}" method="post" class="text-center">
                                @csrf
                                <button type="submit" class="btn text-white shadow-sm w-10 ohanami-btn">カートに入れる</button>
                            </form>
                        </td>
                        @else
                        <td>
                        <form action="{{ route('carts.destroy', $favorite_product->id) }}" method="post" class="text-center">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-primary shadow-sm w-10 ohanami-remove-favorite-button">カートから解除</button>
                            </form>
</td>
                        @endif
                                <td>
                                    <a href="#" class="link-secondary" data-bs-toggle="modal" data-bs-target="#removeFavoriteModal" data-restaurant-id="{{ $favorite_product->id }}" data-restaurant-name="{{ $favorite_product->name }}">解除</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $favorite_products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection