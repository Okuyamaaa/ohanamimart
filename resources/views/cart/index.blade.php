@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('/js/cart-modal.js') }}"></script>
@endpush

@section('content')
    <!-- お気に入りの解除用モーダル -->
    <div class="modal fade" id="deleteCartModal" tabindex="-1" aria-labelledby="deleteCartModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCartModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-footer">
                    <form action="" method="post" name="deleteCartForm">
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
                        <li class="breadcrumb-item active" aria-current="page">カート一覧</li>
                    </ol>
                </nav>

                <h1 class="mb-3 text-center">カート一覧</h1>

                @if (session('flash_message'))
                    <div class="alert alert-info" role="alert">
                        <p class="mb-0">{{ session('flash_message') }}</p>
                    </div>
                @endif
                @if($total_product == 0)
                <h2 class="border-dark" >カート内に商品がありません</h2>
                @else

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">商品名</th>
                            <th scope="col">価格</th>
                            
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart_products as $cart_product)
                            <tr>
                                <td>
                                    <a href="{{ route('products.show', $cart_product->product_id) }}">
                                        {{ $cart_product->product->name }}
                                    </a>
                                </td>
                                <td>{{ ($cart_product->product->price) }}</td>
                                
                                <td>
                                    <a href="#" class="link-secondary" data-bs-toggle="modal" data-bs-target="#deleteCartModal" data-restaurant-id="{{ $cart_product->id }}" data-restaurant-name="{{ $cart_product->product->name }}">削除</a>
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
@endif
                
 <div class="offset-8 col-4">
     <div class="row">
         <div class="col-6">
         @if($total_product == 0)
         @elseif($total_product >= 5)
         <h6>送料</h6>
             <h2>合計</h2>
         </div>
         <div class="col-5">
           <h6>1000円</h6>
             <h2>{{$total+1000}}円</h2>
         </div>
         <div class="col-12 d-flex justify-content-end">
             表示価格は税込みです
         </div>
         @else
         <h6>送料</h6>
             <h2>合計</h2>
         </div>
         <div class="col-5">
           <h6>500円</h6>
             <h2>{{$total+500}}円</h2>
         </div>
         <div class="col-12 d-flex justify-content-end">
             表示価格は税込みです
         </div>
    @endif
     </div>
 </div>
 
 <div class="d-flex justify-content-end mt-3">
             <a href="{{route('products.index')}}" class="btn ohanami-favorite-button shadow-sm w-20 border-dark ">
                 買い物を続ける
             </a>
             @if ($total > 0)
             <a href="{{ route('checkout.index') }}" class="btn text-white shadow-sm w-20 ohanami-btn">購入に進む</a>
             @else
             <button class="btn text-white shadow-sm w-20 ohanami-btn disabled">購入に進む</button>
             @endif
</div>

                <div class="d-flex justify-content-center">
                    {{ $cart_products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection