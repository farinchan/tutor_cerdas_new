@extends('app')
@section('styles')
@endsection
@section('toolbar')
    <div class="toolbar py-5 py-lg-5 my-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class=" container-xxl  d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 mb-2">
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="?page=index" class="text-gray-600 text-hover-primary">
                            <i class="ki-duotone ki-home text-gray-700 fs-6"></i> </a>
                    </li>
                    <li class="breadcrumb-item">
                        <i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i>
                    </li>
                    @if (isset($menu))
                        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                            {{ $menu ?? '' }} </li>
                        <li class="breadcrumb-item">
                            <i class="ki-duotone ki-right fs-7 text-gray-700 mx-n1"></i>
                        </li>
                    @endif
                    @if (isset($title))
                        <li class="breadcrumb-item text-gray-500">
                            {{ $title ?? '' }} </li>
                    @endif
                </ul>
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-3 m-0">
                    {{ $title ?? '' }}
                    <span class="page-desc text-muted fs-7 fw-semibold pt-1">
                    </span>
                </h1>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <form id="kt_ecommerce_add_category_form" class="form d-flex flex-column flex-lg-row"
            action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Foto</h2>
                        </div>
                    </div>
                    <div class="card-body text-center pt-0">
                        <style>
                            .image-input-placeholder {
                                background-image: url('{{ asset('assets/media/svg/files/blank-image.svg') }}');
                            }

                            [data-bs-theme="dark"] .image-input-placeholder {
                                background-image: url('{{ asset('assets/media/svg/files/blank-image-dark.svg') }}');
                            }
                        </style>
                        <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                            data-kt-image-input="true">
                            <div class="image-input-wrapper w-150px h-150px"></div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah Thumbnail">
                                <i class="ki-duotone ki-pencil fs-7">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batalkan Thumbnail">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus Thumbnail">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </div>
                        <div class="text-muted fs-7">
                            Set foto anggota, hanya menerima file dengan ekstensi .png, .jpg, .jpeg
                        </div>
                    </div>
                </div>
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Role</h2>
                        </div>
                        <div class="card-toolbar">
                            <div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_category_status">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="role_mahasiswa" value="1" checked
                                id="flexCheckDefault" />
                            <label class="form-check-label" for="flexCheckDefault">
                                mahasiswa
                            </label>
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" name="role_dosen" value="1"
                                @if (old('role_dosen') == 1) checked @endif id="flexCheckDefault" />
                            <label class="form-check-label" for="flexCheckDefault">
                                Dosen
                            </label>
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" name="role_admin" value="1"
                                @if (old('role_admin') == 1) checked @endif id="flexCheckDefault" />
                            <label class="form-check-label" for="flexCheckDefault">
                                Admin
                            </label>
                        </div>
                        @error('status')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror

                    </div>
                </div>
            </div>
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Biodata umum</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-5 fv-row">
                            <label class="required form-label">Nama</label>
                            <input type="text" name="name" class="form-control mb-2" placeholder="Nama"
                                value="{{ old('name') }}" required />
                            @error('name')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5 fv-row">
                            <label class="required form-label">Email</label>
                            <input type="email" name="email" class="form-control mb-2" placeholder="Email"
                                value="{{ old('email') }}" required />
                            @error('email')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-5 fv-row">
                            <label class="required form-label">Password</label>
                            <input type="password" name="password" class="form-control mb-2" placeholder="Password"
                                required />
                            @error('password')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card card-flush py-4" id="biodata_mahasiswa">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Biodata Mahasiswa</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-5 fv-row">
                            <label class="required form-label">NIM</label>
                            <input type="text" name="nim" class="form-control mb-2"
                                placeholder="Nomor Induk Mahasiswa" value="{{ old('nim') }}" />
                            @error('nim')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-5 fv-row">
                            <label class="required form-label">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control mb-2" placeholder="Jurusan"
                                value="{{ old('jurusan') }}"  />
                            @error('jurusan')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5 fv-row">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="required form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin_mahasiswa" class="form-select mb-2" >
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" @if (old('jenis_kelamin_mahasiswa') == 'L') selected @endif>Laki-laki
                                        </option>
                                        <option value="P" @if (old('jenis_kelamin_mahasiswa') == 'P') selected @endif>Perempuan
                                        </option>
                                    </select>
                                    @error('jenis_kelamin_mahasiswa')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="required form-label">Agama</label>
                                    <select name="agama_mahasiswa" class="form-select mb-2" >
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" @if (old('agama_mahasiswa') == 'Islam') selected @endif>Islam
                                        </option>
                                        <option value="Kristen" @if (old('agama_mahasiswa') == 'Kristen') selected @endif>Kristen
                                        </option>
                                        <option value="Katolik" @if (old('agama_mahasiswa') == 'Katolik') selected @endif>Katolik
                                        </option>
                                        <option value="Hindu" @if (old('agama_mahasiswa') == 'Hindu') selected @endif>Hindu
                                        </option>
                                        <option value="Budha" @if (old('agama_mahasiswa') == 'Budha') selected @endif>Budha
                                        </option>
                                        <option value="Konghucu" @if (old('agama_mahasiswa') == 'Konghucu') selected @endif>
                                            Konghucu
                                        </option>
                                    </select>
                                    @error('agama_mahasiswa')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-5 fv-row">
                            <label class="required form-label">Alamat</label>
                            <textarea name="alamat_mahasiswa" class="form-control mb-2" placeholder="Alamat" >{{ old('alamat_mahasiswa') }}</textarea>
                            @error('alamat_mahasiswa')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card card-flush py-4" id="biodata_dosen">
                    <div class="card-header">
                        <div class="card-title mb-0">
                            <h2>Biodata Dosen</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-5 fv-row">
                            <label class="required form-label">NIDN</label>
                            <input type="text" name="nidn" class="form-control mb-2"
                                placeholder="Nomor Induk Dosen Nasional" value="{{ old('nidn') }}" />
                            @error('nidn')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5 fv-row">
                            <label class="required form-label">Jabatan</label>
                            <select name="jabatan" class="form-select mb-2" >
                                <option value="">Pilih Jabatan</option>
                                <option value="asisten ahli" @if (old('jabatan') == 'asisten ahli') selected @endif>Asisten
                                    Ahli</option>
                                <option value="lektor" @if (old('jabatan') == 'lektor') selected @endif>Lektor</option>
                                <option value="lektor kepala" @if (old('jabatan') == 'lektor kepala') selected @endif>Lektor
                                    Kepala</option>
                                <option value="guru besar" @if (old('jabatan') == 'guru besar') selected @endif>Guru Besar
                                </option>
                            </select>
                            @error('jabatan')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-5 fv-row">
                            <label class="required form-label">Pangkat</label>
                            <input type="text" name="pangkat" class="form-control mb-2" placeholder="Pangkat"
                                value="{{ old('pangkat') }}"  />
                            @error('pangkat')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-5 fv-row">
                            <label class="required form-label">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir" class="form-select mb-2" >
                                <option value="">Pilih Pendidikan Terakhir</option>
                                <option value="S1" @if (old('pendidikan_terakhir') == 'S1') selected @endif>S1</option>
                                <option value="S2" @if (old('pendidikan_terakhir') == 'S2') selected @endif>S2</option>
                                <option value="S3" @if (old('pendidikan_terakhir') == 'S3') selected @endif>S3</option>
                            </select>
                            @error('pendidikan_terakhir')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-5 fv-row">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="required form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin_dosen" class="form-select mb-2" >
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" @if (old('jenis_kelamin_dosen') == 'L') selected @endif>
                                            Laki-laki
                                        </option>
                                        <option value="P" @if (old('jenis_kelamin_dosen') == 'P') selected @endif>
                                            Perempuan
                                        </option>
                                    </select>
                                    @error('jenis_kelamin_dosen')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="required form-label">Agama</label>
                                    <select name="agama_dosen" class="form-select mb-2" >
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" @if (old('agama_dosen') == 'Islam') selected @endif>Islam
                                        </option>
                                        <option value="Kristen" @if (old('agama_dosen') == 'Kristen') selected @endif>Kristen
                                        </option>
                                        <option value="Katolik" @if (old('agama_dosen') == 'Katolik') selected @endif>Katolik
                                        </option>
                                        <option value="Hindu" @if (old('agama_dosen') == 'Hindu') selected @endif>Hindu
                                        </option>
                                        <option value="Budha" @if (old('agama_dosen') == 'Budha') selected @endif>Budha
                                        </option>
                                        <option value="Konghucu" @if (old('agama_dosen') == 'Konghucu') selected @endif>
                                            Konghucu
                                        </option>
                                    </select>
                                    @error('agama_dosen')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-5 fv-row">
                                <label class="required form-label">Alamat</label>
                                <textarea name="alamat_dosen" class="form-control mb-2" placeholder="Alamat" >{{ old('alamat_dosen') }}</textarea>
                                @error('alamat_dosen')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="d-flex justify-content-end">
                    <a href="" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Simpan Perubahan</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/custom/apps/user-management/users/list/table.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/custom/apps/user-management/users/list/add.js') }}"></script> --}}
    <script>
           if ($('input[name="role_mahasiswa"]').is(':checked')) {
                $('#biodata_mahasiswa').show();
            } else {
                $('#biodata_mahasiswa').hide();
            }
            if ($('input[name="role_dosen"]').is(':checked')) {
                $('#biodata_dosen').show();
            } else {
                $('#biodata_dosen').hide();
            }
            $('input[name="role_mahasiswa"]').change(function() {
                if ($(this).is(':checked')) {
                    $('#biodata_mahasiswa').show();
                } else {
                    $('#biodata_mahasiswa').hide();
                }
            });
            $('input[name="role_dosen"]').change(function() {
                if ($(this).is(':checked')) {
                    $('#biodata_dosen').show();
                } else {
                    $('#biodata_dosen').hide();
                }
            });
     </script>
@endsection
