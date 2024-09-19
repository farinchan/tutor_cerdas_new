@extends('pages.auth.layout')

@section('content')
    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="index.html"
            action="{{ route('login.process') }}" method="POST">
            @csrf
            <div class="text-center mb-11">
                <h1 class="text-gray-900 fw-bolder mb-3">Masuk</h1>
                <div class="text-gray-500 fw-semibold fs-6">Masukkan email dan password anda</div>
            </div>
            <div class="fv-row mb-8">
                <input type="email" placeholder="Email" name="email"
                    class="form-control bg-transparent @if ($errors->has('email')) is-invalid @endif"
                    value="{{ old('email') }}" required />
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="fv-row mb-3">
                <input type="password" placeholder="Password" name="password"
                    class="form-control bg-transparent @if ($errors->has('password')) is-invalid @endif"
                    value="{{ old('password') }}" required />
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                <div></div>
                <a href="{{ route('forgot.password') }}" class="link-primary">Lupa Password ?</a>
            </div>
            <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                    <span class="indicator-label">Login</span>

                </button>
            </div>
            <div class="text-gray-500 text-center fw-semibold fs-6">Belum Punya Akun?
                <a href="{{ route('register') }}" class="link-primary">Daftar disini</a>
            </div>
        </form>
    </div>
@endsection
