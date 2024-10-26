@extends('layouts.app')

@section('content')
    <div class="container ohanami-container pb-5">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
                <nav class="my-3" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0"> 
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>                       
                        <li class="breadcrumb-item active" aria-current="page">会社概要</li>
                    </ol>
                </nav> 

                <h1 class="mb-4 text-center">会社概要</h1>                                    

               
                <div class="container mb-4">
                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">会社名</span>
                        </div>

                        <div class="col">
                            <span>{{ $company->name }}</span>
                        </div>
                    </div>                    

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">所在地</span>
                        </div>

                        <div class="col">
                            <span>{{$company->address }}</span>
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">代表者</span>
                        </div>

                        <div class="col">
                            <span>{{ $company->representative }}</span>
                        </div>
                    </div> 
                    
                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">電話番号</span>
                        </div>

                        <div class="col">
                            <span>{{ $company->phone_number }}</span>
                        </div>
                    </div>   

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">受付時間</span>
                        </div>

                        <div class="col">
                            <span>{{ $company->resption_hours }}</span>
                        </div>
                    </div> 

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">URL</span>
                        </div>

                        <div class="col">
                            <span>{{ $company->URL }}</span>
                        </div>
                    </div> 
                    
                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">設立</span>
                        </div>

                        <div class="col">
                            <span>{{ $company->establishment_date }}</span>
                        </div>
                    </div>   
                    
                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">資本金</span>
                        </div>

                        <div class="col">
                            <span>{{ $company->capital }}</span>
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">事業内容</span>
                        </div>

                        <div class="col">
                        {!! $company->business !!}
                        </div>
                    </div>                    
                    
                </div>                                               
            </div>                          
        </div>
    </div>       
@endsection