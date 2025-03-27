@extends('app')

@section('styles')
@endsection

@section('content')
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <div class="col-10 col-sm-8 col-lg-6">
            <img src="{{ asset('assets/img_ext/home_banner.png') }}" class="d-block mx-lg-auto img-fluid"
                alt="Bootstrap Themes" width="700" height="500" loading="lazy">
        </div>
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold lh-1 mb-3">Tutor Cerdas</h1>
            <p class="lead">
                {{ __('home.welcome_description') }} <br>
                {{ __('home.welcome_description2') }}
            </p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <button type="button" class="btn btn-primary btn-lg px-4 me-md-2">{{ __('home.get_started') }}</button>
            </div>
        </div>
        <div class="mb-18 mt-18">
            <div class="text-center mb-12">
                <h3 class="fs-2hx  mb-5 ">
                    <a class="text-gray-900 text-hover-primary" href="#">
                        {{ __('home.lecture_title') }}
                    </a>
                </h3>
                <div class="fs-5 text-muted fw-semibold">
                    {{ __('home.lecture_description') }}
                </div>
            </div>
            <div class="tns tns-default mb-10">
                <div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="2000"
                    data-tns-autoplay="true" data-tns-autoplay-timeout="18000" data-tns-controls="true" data-tns-nav="false"
                    data-tns-items="1" data-tns-center="false" data-tns-dots="false"
                    data-tns-prev-button="#kt_team_slider_prev" data-tns-next-button="#kt_team_slider_next"
                    data-tns-responsive="{1200: {items: 3}, 992: {items: 2}}">
                    @foreach ($list_dosen as $dosen)
                        <div class="text-center">
                            <div class="octagon mx-auto mb-5 d-flex w-200px h-200px bgi-no-repeat bgi-size-cover bgi-position-center"
                                style="background-image:url('{{ $dosen->getPhoto() }}')"></div>
                            <div class="mb-0">
                                <a href="#"
                                    class="text-gray-900 fw-bold text-hover-primary fs-3">{{ $dosen->name }}</a>
                                <div class="text-muted fs-6 fw-semibold mt-1">NIDN. {{ $dosen?->dosen?->nidn }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_prev">
                    <i class="ki-outline ki-left fs-3x"></i>
                </button>
                <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_next">
                    <i class="ki-outline ki-right fs-3x"></i>
                </button>
            </div>
        </div>
        <div class="card bg-light mb-18">
            <div class="card-body py-15">
                <div class="text-center mb-12">
                    <h3 class="fs-2hx  mb-5 ">
                        <a class="text-gray-900 text-hover-primary" href="#">
                            {{ __('home.about_title') }}
                        </a>
                    </h3>
                    <div class="fs-5 text-muted fw-semibold px-lg-20">
                        {{ __('home.about_description') }}
                    </div>
                </div>
                <div class="d-flex flex-center">
                    <div class="d-flex flex-center flex-wrap mb-10 mx-auto gap-5 w-xl-900px">
                        <div class="octagon d-flex flex-center h-200px w-200px bg-body mx-lg-10">
                            <div class="text-center">
                                <i class="ki-outline ki-profile-user fs-2tx text-primary"></i>
                                <div class="mt-1">
                                    <div class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex justify-content-center">
                                        <div class="min-w-70px" data-kt-countup="true"
                                            data-kt-countup-value="{{ $dosen_count }}">0
                                        </div>
                                    </div>
                                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                                        {{ __('home.lecture') }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="octagon d-flex flex-center h-200px w-200px bg-body mx-lg-10">
                            <div class="text-center">
                                <i class="ki-outline ki-people fs-2tx text-success"></i>
                                <div class="mt-1">
                                    <div class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex justify-content-center">
                                        <div class="min-w-50px" data-kt-countup="true"
                                            data-kt-countup-value="{{ $mahasiswa_count }}">0
                                        </div>
                                    </div>
                                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                                        {{ __('home.student') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="octagon d-flex flex-center h-200px w-200px bg-body mx-lg-10">
                            <div class="text-center">
                                <i class="ki-outline ki-user-tick fs-2tx text-info"></i>
                                <div class="mt-1">
                                    <div class="fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex justify-content-center">
                                        <div class="min-w-50px" data-kt-countup="true"
                                            data-kt-countup-value="{{ $umum_count }}">0
                                        </div>
                                    </div>
                                    <span class="text-gray-600 fw-semibold fs-5 lh-0">
                                        {{ __('home.general') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
