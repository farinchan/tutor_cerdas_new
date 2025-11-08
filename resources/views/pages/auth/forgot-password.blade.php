@extends('pages.auth.layout')

@section('content')
    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
        <form class="form w-100" method="POST" action="{{ route('forgot.password.process') }}">
            @csrf
            <div class="text-center mb-10">
                <h1 class="text-gray-900 fw-bolder mb-3">Lupa Password?</h1>
                <div class="text-gray-500 fw-semibold fs-6">Masukkan email Anda untuk mereset password.</div>
            </div>
            <div class="fv-row mb-8">
                <input type="text" placeholder="Email" name="email" autocomplete="off" value="{{ old('email') }}"
                    class="form-control bg-transparent @error('email') is-invalid @enderror" />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                <button type="submit" class="btn btn-primary me-4">
                    <span class="indicator-label">Kirim Link Reset</span>
                </button>
                <a href="{{ route('login') }}" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
@endsection
