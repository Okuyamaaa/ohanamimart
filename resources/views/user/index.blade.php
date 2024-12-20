@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('/js/reservation-modal.js') }}"></script>
@endpush

@section('content')
    <div class="container ohanami-container pb-5">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>
                        <li class="breadcrumb-item active" aria-current="page">会員情報</li>
                    </ol>
                </nav>

                <h1 class="mb-3 text-center">会員情報</h1>

                <div class="d-flex justify-content-end align-items-end mb-3">
                    <div>
                        <a href="{{ route('user.edit', $user) }}">編集</a>
                    </div>
                </div>

                @if (session('flash_message'))
                    <div class="alert alert-info" role="alert">
                        <p class="mb-0">{{ session('flash_message') }}</p>
                    </div>
                @endif

                @if (session('error_message'))
                    <div class="alert alert-danger" role="alert">
                        <p class="mb-0">{{ session('error_message') }}</p>
                    </div>
                @endif

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

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">メールアドレス</span>
                        </div>

                        <div class="col">
                            <span>{{ $user->email }}</span>
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">郵便番号</span>
                        </div>

                        <div class="col">
                            <span>{{ substr($user->postal_code, 0, 3) . '-' . substr($user->postal_code, 3) }}</span>
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">住所</span>
                        </div>

                        <div class="col">
                            <span>{{ $user->address }}</span>
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">電話番号</span>
                        </div>

                        <div class="col">
                            <span>{{ $user->phone_number }}</span>
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">誕生日</span>
                        </div>

                        <div class="col">
                            <span>
                                @if ($user->birthday !== null)
                                    {{ date('n月j日', strtotime($user->birthday)) }}
                                @else
                                    未設定
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">職業</span>
                        </div>

                        <div class="col">
                            <span>
                                @if ($user->occupation !== null)
                                    {{ $user->occupation }}
                                @else
                                    未設定
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                @if($review_total !== 0)
                <div class="container ohanami-container">
                    <h1 class="mb-8 text-center">--レビュー一覧--</h1>
@foreach ($reviews as $review)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <div>
                                {{ DB::table('users')->find($review->send_user_id)->name }}さん
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
@endsection