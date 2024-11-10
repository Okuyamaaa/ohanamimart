@extends('layouts.app')

@section('content')
    <div class="col container">
        <div class="row justify-content-center">
            <div class="col-xxl-9 col-xl-10 col-lg-11">
                <h1 class="mb-4 text-center">商品一覧</h1>

                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    <form method="GET" action="{{ route('admin.products.index') }}" class="ohanami-admin-search-box mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="商品名で検索" name="keyword" value="{{ $keyword }}">
                            <button type="submit" class="btn text-white shadow-sm ohanami-btn">検索</button>
                        </div>
                    </form>

                </div>

                @if (session('flash_message'))
                    <div class="alert alert-info" role="alert">
                        <p class="mb-0">{{ session('flash_message') }}</p>
                    </div>
                @endif

                <div>
                    <p class="mb-0">計{{ number_format($total) }}件</p>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">出品者</th>
                            <th scope="col">商品名</th>
                            <th scope="col">価格</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td><a href="{{route('admin.users.show', [$product->user_id])}}">{{ $product->user->name }}</a></td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td><a href="{{ route('admin.products.show', $product) }}">詳細</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection