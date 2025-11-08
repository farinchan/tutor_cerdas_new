@extends('pages.auth.layout')

@section('content')
    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
        <form class="form w-100" method="POST" action="{{ route('reset.password.process', ['token' => $token]) }}">
            @csrf
            <div class="text-center mb-10">
                <h1 class="text-gray-900 fw-bolder mb-3">Buat Password Baru</h1>
                <div class="text-gray-500 fw-semibold fs-6">Sudah reset password?
                    <a href="{{ route('login') }}" class="link-primary fw-bold">Login</a>
                </div>
            </div>

            <input type="hidden" name="email" value="{{ request('email') }}">

            <div class="fv-row mb-8" data-kt-password-meter="true">
                <div class="mb-1">
                    <div class="position-relative mb-3">
                        <input class="form-control bg-transparent @error('password') is-invalid @enderror" type="password"
                            placeholder="Password Baru" name="password" autocomplete="off" />
                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                            data-kt-password-meter-control="visibility">
                            <i class="ki-outline ki-eye-slash fs-2"></i>
                            <i class="ki-outline ki-eye fs-2 d-none"></i>
                        </span>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                    </div>
                </div>
                <div class="text-muted">Gunakan minimal 8 karakter dengan kombinasi huruf, angka & simbol.</div>
            </div>

            <div class="fv-row mb-8">
                <input type="password" placeholder="Konfirmasi Password" name="password_confirmation"
                    autocomplete="off" class="form-control bg-transparent @error('password_confirmation') is-invalid @enderror" />
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid mb-10">
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Reset Password</span>
                </button>
            </div>
        </form>
    </div>
@endsection
