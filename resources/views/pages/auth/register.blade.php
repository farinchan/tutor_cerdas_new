@extends('pages.auth.layout')
@section('content')
    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
        <form class="form w-120" novalidate="novalidate" id="kt_sign_up_form"
            data-kt-redirect-url="authentication/layouts/overlay/sign-in.html" action="{{ route("register.process") }}" method="POST">
            @csrf
            <div class="text-center mb-11">
                <h1 class="text-gray-900 fw-bolder mb-3">Buat Akun</h1>
                <div class="text-gray-500 fw-semibold fs-6">Buat akun sebagai:</div>
            </div>
            <div class="fv-row mb-8">
                <div data-kt-buttons="true">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="radio" class="btn-check" name="role" value="dosen" checked="checked"
                                id="kt_radio_buttons_2_option_1" />
                            <label id="role_dosen"
                                class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                                for="kt_radio_buttons_2_option_1">
                                <i class="ki-duotone ki-profile-user fs-2x me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                                <span class="d-block fw-semibold text-start">
                                    <span class="text-gray-900 fw-bold d-block fs-3">Dosen</span>
                                </span>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input type="radio" class="btn-check" name="role" value="mahasiswa"
                                id="kt_radio_buttons_2_option_2" />
                            <label id="role_mahasiswa"
                                class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center"
                                for="kt_radio_buttons_2_option_2">
                                <i class="ki-duotone ki-people fs-2x me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                                <span class="d-block fw-semibold text-start">
                                    <span class="text-gray-900 fw-bold d-block fs-3">Mahasiswa</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <div id="ket_akun"></div>
            <div class="text-start mb-5">
                <div class="image-input image-input-empty" data-kt-image-input="true"
                    style="background-image: url(/assets/media/svg/avatars/blank.svg)">
                    <div class="image-input-wrapper w-125px h-125px"
                        style="background-image: url({{ asset('assets/media/svg/avatars/blank.svg') }})"></div>
                    <label
                        class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click"
                        title="Ganti Foto">
                        <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>
                        <input type="file" name="foto" accept=".png, .jpg, .jpeg" />
                        <input type="hidden" name="avatar_remove" />
                    </label>
                    <span
                        class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click"
                        title="Batalkan Foto">
                        <i class="ki-outline ki-cross fs-3"></i>
                    </span>
                    <span
                        class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click"
                        title="Hapus Foto">
                        <i class="ki-outline ki-cross fs-3"></i>
                    </span>
                </div>
            </div>
            <div id="form_register">
            </div>
            <div class="fv-row mb-5">
                <input type="text" placeholder="Email" name="email" autocomplete="off" value="{{ old('email') }}"
                    class="form-control bg-transparent" />
                @error('email')
                    <small class="text-danger">*{{ $message }}</small>
                @enderror
            </div>
            <div class="fv-row mb-5" data-kt-password-meter="true">
                <div class="mb-1">
                    <div class="position-relative mb-3">
                        <input class="form-control bg-transparent" type="password" placeholder="Password" name="password"
                            autocomplete="off" />
                        @error('email')
                            <small class="text-danger">*{{ $message }}</small>
                        @enderror
                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                            data-kt-password-meter-control="visibility">
                            <i class="ki-duotone ki-eye-slash fs-2"></i>
                            <i class="ki-duotone ki-eye fs-2 d-none"></i>
                        </span>
                    </div>
                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                        </div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                        </div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                        </div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px">
                        </div>
                    </div>
                </div>
                <div class="text-muted">
                    Gunakan minimal 8 karakter dengan kombinasi huruf, angka & simbol untuk keamanan yang lebih baik.
                </div>
            </div>
            <div class="fv-row mb-8">
                <label class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="toc" value="1" />
                    <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
                        Saya setuju dengan <a href="#" class="ms-1 link-primary">Syarat & Ketentuan</a></span>
                </label>
            </div>
            <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                    <span class="indicator-label">Register</span>
                </button>
            </div>
            <div class="text-gray-500 text-center fw-semibold fs-6">Sudah Memiliki Akun?
                <a href="{{ route('login') }}" class="link-primary fw-semibold">Masuk Disini</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $('#role_dosen').click(
            function() {
                let form_admin = `
                <div class="fv-row mb-5">
                    <input class="form-control form-control-lg" type="number"
                        placeholder="NIDN / NIP" name="nidn" autocomplete="off" value="{{ old('nidn') }}"
                        required />
                    @error('nidn')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>
                <div class="fv-row mb-5">
                    <input class="form-control form-control-lg" type="text"
                        placeholder="Nama Lengkap" name="nama" autocomplete="off" value="{{ old('nama') }}"
                        required />
                    @error('nama')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>
                <div class="row fv-row mb-5">
                <div class="col-xl-6">
                    <select class="form-control form-control-lg" name="jenis_kelamin"
                        required>
                        <option value="" disabled selected>Jenis Kelamin</option>
                        <option @if (old('jenis_kelamin') == 'L') selected @endif value="L">Laki-laki
                        </option>
                        <option @if (old('jenis_kelamin') == 'P') selected @endif value="P">Perempuan
                        </option>
                    </select>
                    @error('jenis_kelamin')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-xl-6">
                    <select name="agama" class="form-control form-control-lg" required>
                        <option value="" disabled selected>Agama</option>
                        <option @if (old('agama') == 'Islam') selected @endif value="Islam">Islam</option>
                        <option @if (old('agama') == 'Kristen') selected @endif value="Kristen">Kristen
                        </option>
                        <option @if (old('agama') == 'Hindu') selected @endif value="Hindu">Hindu</option>
                        <option @if (old('agama') == 'Budha') selected @endif value="Budha">Budha</option>
                        <option @if (old('agama') == 'konghucu') selected @endif value="konghucu">Konghucu
                        </option>
                    </select>
                    @error('agama')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>
            </div>
                <div class="row fv-row mb-5">
                    <div class="col-xl-6">
                        <input class="form-control form-control-lg" type="text"
                            placeholder="pangkat" name="pangkat" autocomplete="off" value="{{ old('pangkat') }}"
                            required />
                        @error('pangkat')
                            <small class="text-danger">*{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-xl-6">
                        <select name="jabatan" class="form-control form-control-lg">
                            <option value="" disabled selected>Jabatan</option>
                            <option @if (old('jabatan') == 'asisten ahli') selected @endif value="asisten ahli">Asisten Ahli
                            </option>
                            <option @if (old('jabatan') == 'lektor') selected @endif value="lektor">Lektor</option>
                            <option @if (old('jabatan') == 'lektor kepala') selected @endif value="lektor kepala">Lektor
                                Kepala</option>
                            <option @if (old('jabatan') == 'guru besar') selected @endif value="guru besar">Guru Besar
                            </option>
                        </select>
                        @error('jabatan')
                            <small class="text-danger">*{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="fv-row mb-5">
                    <input class="form-control form-control-lg" type="text"
                        placeholder="Pendidilan Terakhir" name="pendidikan_terakhir" autocomplete="off"
                        value="{{ old('pendidikan_terakhir') }}" required />
                    @error('pendidikan_terakhir')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>
                <div class="fv-row mb-5">
                    <textarea class="form-control form-control-lg" type="text" placeholder="Alamat" name="alamat"
                        autocomplete="off" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <small class="text-danger">*{{ $message }}</small>
                    @enderror
                </div>`
                $('#form_register').html(form_admin);
                $('#ket_akun').html(`
                    <div class="text-start mb-10">
                        <div class="text-gray-500 fw-semibold fs-6" data-kt-translate="general-desc">
                            Silahkan isi form berikut untuk membuat akun dosen
                        </div>
                    </div>`);
            }
        );

        $('#role_dosen').click();


        $('#role_mahasiswa').click(
            function() {
                let form_mahasiswa = `
                        <div class="fv-row mb-5">
                            <input class="form-control form-control-lg" type="number"
                                placeholder="NIM" name="nim" autocomplete="off" value="{{ old('nim') }}"
                                required />
                            @error('nim')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="fv-row mb-5">
                            <input class="form-control form-control-lg" type="text"
                                placeholder="Nama Lengkap" name="nama" autocomplete="off" value="{{ old('nama') }}"
                                required />
                            @error('nama')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row fv-row mb-5">
                            <div class="col-xl-6">
                                <select class="form-control form-control-lg" name="jenis_kelamin"
                                    required>
                                    <option value="" disabled selected>Jenis Kelamin</option>
                                    <option @if (old('jenis_kelamin') == 'L') selected @endif value="L">Laki-laki
                                    </option>
                                    <option @if (old('jenis_kelamin') == 'P') selected @endif value="P">Perempuan
                                    </option>
                                </select>
                                @error('jenis_kelamin')
                                    <div
                                        class="fv-plugins message-container fv-plugins-message-container--enabled invalid-feedback">
                                        <div>
                                            - {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-xl-6">
                                <select name="agama" class="form-control form-control-lg" required>
                                    <option value="" disabled selected>Agama</option>
                                    <option @if (old('agama') == 'Islam') selected @endif value="Islam">Islam</option>
                                    <option @if (old('agama') == 'kristen') selected @endif value="kristen">Kristen
                                    </option>
                                    <option @if (old('agama') == 'Hindu') selected @endif value="Hindu">Hindu</option>
                                    <option @if (old('agama') == 'Budha') selected @endif value="Budha">Budha</option>
                                    <option @if (old('agama') == 'konghucu') selected @endif value="konghucu">Konghucu
                                    </option>
                                </select>
                                @error('agama')
                                    <small class="text-danger">*{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="fv-row mb-5">
                            <input class="form-control form-control-lg" type="text"
                                placeholder="Jurusan" name="jurusan" autocomplete="off" value="{{ old('jurusan') }}"
                                required />
                            @error('jurusan')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="fv-row mb-5">
                            <textarea class="form-control form-control-lg" type="text" placeholder="Alamat" name="alamat"
                                autocomplete="off" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                               <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>`
                $('#form_register').html(form_mahasiswa);
                $('#ket_akun').html(`
                    <div class="text-start mb-10">
                        <div class="text-gray-500 fw-semibold fs-6" data-kt-translate="general-desc">
                            Silahkan isi form berikut untuk membuat akun mahasiswa
                        </div>
                    </div>`);
            }
        );
    </script>
@endsection
