@extends('app')

@section('styles')

@endsection

@section('content')

        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
          <div class="col-10 col-sm-8 col-lg-6">
            <img src="{{ asset('assets/img_ext/home_banner.png') }}" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
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
        </div>
@endsection


