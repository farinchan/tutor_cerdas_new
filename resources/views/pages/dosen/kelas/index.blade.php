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
            <a href="#" class="btn bg-body d-flex flex-center h-35px h-lg-40px" data-bs-toggle="modal"
                data-bs-target="#buat_kelas">
                <i class="ki-duotone ki-plus fs-2"></i>
                Buat Kelas
            </a>
            <div class="modal fade" tabindex="-1" id="buat_kelas">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Buat Kelas Baru</h3>
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                        class="path2"></span></i>
                            </div>
                        </div>

                        <form action="{{ route('dosen.kelas.store') }}" method="POST">
                            @csrf

                            <div class="modal-body">
                                <div class="row mb-5">
                                    <div class="col-lg-8">
                                        <label class="form-label fw-bold required">Mata Kuliah:</label>
                                        <input type="text" class="form-control form-control-solid"
                                            placeholder="Mata Kuliah" name="matakuliah" value="{{ old('') }}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label fw-bold required">SKS:</label>
                                        <input type="number" class="form-control form-control-solid" placeholder="SKS"
                                            name="sks" value="{{ old('sks') }}" />
                                    </div>
                                </div>
                                <hr>

                                <div class="mb-5 mt-5">
                                    <label class="form-label fw-bold required">Kode Kelas:</label>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="Kode Kelas" value="{{ $kode_kelas_new }}" readonly />
                                    <input type="hidden" name="kode_kelas" value="{{ $kode_kelas_new }}">
                                </div>
                                <div class="mb-5 mt-5">
                                    <label class="form-label fw-bold required">Nama Kelas:</label>
                                    <input type="text" class="form-control form-control-solid" name="nama_kelas"
                                        placeholder="Nama Kelas" value="{{ old('kode_kelas') }}" />
                                </div>
                                <div class="mb-5">
                                    <label class="form-label fw-bold required">Tingkat:</label>
                                    <select class="form-select form-select-solid" data-placeholder="Pilih Tingkat"
                                        name="tingkat" value="{{ old('tingkat') }}" required>
                                        <option>Pilih Tingkat</option>
                                        <option value="D3">Diploma 3</option>
                                        <option value="D4">Diploma 4</option>
                                        <option value="S1">Sarjana</option>
                                        <option value="S2">Magister</option>
                                        <option value="S3">Doktor</option>
                                    </select>
                                </div>
                                <div class="mb-5">
                                    <label class="form-label fw-bold required">Jurusan:</label>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="Jurusan" name="jurusan" value="{{ old('jurusan') }}" required />
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Buat Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <div class="row gy-0 gx-10">
            @foreach ($kelas as $row)
                <div class="col-xl-4 mb-xl-10">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px"
                            style="background-image:url('{{ asset('assets/media/svg/shapes/bg-kelas.png') }}"
                            data-bs-theme="light">
                            <h3 class="card-title align-items-start flex-column text-white pt-15">
                                <a class="fw-bold text-white fs-2x mb-3 text-hover-info"
                                    href="{{ route('dosen.kelas.show', $row->kode_kelas) }} ">
                                    {{ $row->nama_kelas }} - {{ $row->matakuliah->nama_mk }}
                                </a>
                                <div class="fs-4 text-white">
                                    <span class="opacity-75">
                                        {{ $row->tingkat }} - {{ $row->jurusan }}
                                    </span>
                                </div>
                            </h3>
                        </div>
                        <div class="card-body mt-n20 mb-10">
                            <div class="mt-n20 position-relative">
                                <div class="row g-3 g-lg-6">
                                    <div class="col-6">
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                            <div class="symbol symbol-30px me-5 mb-8">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-flask fs-1 text-primary">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div class="m-0">
                                                <span
                                                    class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $row->materi->count() }}</span>
                                                <span class="text-gray-500 fw-semibold fs-6">Materi</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                            <div class="symbol symbol-30px me-5 mb-8">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-people fs-1 text-primary">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div class="m-0">
                                                <span
                                                    class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $row->mahasiswa->count() }}</span>
                                                <span class="text-gray-500 fw-semibold fs-6">Mahasiswa</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('scripts')
@endsection
