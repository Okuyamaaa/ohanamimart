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
                            <th scope="col">店舗名</th>
                            <th scope="col">郵便番号</th>
                            <th scope="col">住所</th>
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
                                <td>{{ substr($favorite_product->postal_code, 0, 3) . '-' . substr($favorite_product->postal_code, 3) }}</td>
                                <td>{{ $favorite_product->address }}</td>
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