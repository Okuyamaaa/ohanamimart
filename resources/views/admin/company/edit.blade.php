@extends('layouts.app')

@section('content')
    <div class="col container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-9">
                <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.company.index') }}">会社概要</a></li>
                        <li class="breadcrumb-item active" aria-current="page">会社概要編集</li>
                    </ol>
                </nav>

                <h1 class="mb-4 text-center">会社概要編集</h1>

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

                <form method="POST" action="{{ route('admin.company.update', $company) }}">
                    @csrf
                    @method('patch')
                    <div class="form-group row mb-3">
                        <label for="name" class="col-md-5 col-form-label text-md-left fw-bold">会社名</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $company->name) }}">
                        </div>
                    </div>


                    <div class="form-group row mb-3">
                        <label for="address" class="col-md-5 col-form-label text-md-left fw-bold">所在地</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $company->address) }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="representative" class="col-md-5 col-form-label text-md-left fw-bold">代表者</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="representative" name="representative" value="{{ old('representative', $company->representative) }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="representative" class="col-md-5 col-form-label text-md-left fw-bold">電話番号</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $company->phone_number) }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="representative" class="col-md-5 col-form-label text-md-left fw-bold">受付時間</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="resption_hours" name="resption_hours" value="{{ old('resption_hours', $company->resption_hours) }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="representative" class="col-md-5 col-form-label text-md-left fw-bold">URL</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="URL" name="URL" value="{{ old('URL', $company->URL) }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="establishment_date" class="col-md-5 col-form-label text-md-left fw-bold">設立</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="establishment_date" name="establishment_date" value="{{ old('establishment_date', $company->establishment_date) }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="capital" class="col-md-5 col-form-label text-md-left fw-bold">資本金</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" id="capital" name="capital" value="{{ old('capital', $company->capital) }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="business" class="col-md-5 col-form-label text-md-left fw-bold">事業内容</label>

                        <div class="col-md-7">
                            <textarea class="form-control" id="business" name="business">{{ old('business', $company->business) }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="form-group d-flex justify-content-center mb-4">
                        <button type="submit" class="btn text-white shadow-sm w-50 ohanami-btn">更新</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection