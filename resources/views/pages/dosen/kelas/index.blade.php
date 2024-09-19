@extends('app')

@section('styles')
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
                                <a class="fw-bold text-white fs-2x mb-3 text-hover-info" href="{{ route('dosen.kelas.show', $row->kode_kelas) }} ">
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
