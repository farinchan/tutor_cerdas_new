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
        <div class="row gy-0 gx-10">
            @forelse ($kelas as $row)
            {{-- @dd($row->pretest, $row->pretest->session->isEmpty(), $row->pretest?->session?->first()?->score == null) --}}
                <div class="col-xl-4 mb-xl-10">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px"
                            style="background-image:url('{{ asset('assets/media/svg/shapes/bg-kelas.png') }}"
                            data-bs-theme="light">
                            <h3 class="card-title align-items-start flex-column text-white pt-15">
                                @if ($row->pretest  && $row->pretest?->session?->first()?->score == null)
                                    <a class="fw-bold text-white fs-2x mb-3 text-hover-info" href="#"
                                        data-bs-toggle="modal" data-bs-target="#pretest_dialog">
                                        {{-- {{ route('mahasiswa.kelas.show', $row->kode_kelas) }}  --}}
                                        {{ $row->nama_kelas }} - {{ $row->matakuliah->nama_mk }}
                                    </a>
                                @else
                                    <a class="fw-bold text-white fs-2x mb-3 text-hover-info"
                                        href="{{ route('mahasiswa.kelas.show', $row->kode_kelas) }} ">
                                        {{ $row->nama_kelas }} - {{ $row->matakuliah->nama_mk }}
                                    </a>
                                @endif
                                <div class="fs-4 text-white">
                                    <span class="opacity-75">
                                        {{ $row->tingkat }} - {{ $row->jurusan }}
                                    </span>
                                </div>
                            </h3>
                        </div>
                        <div class="card-body mt-n20 mb-10">
                            <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5">
                                <div class="d-flex flex-column">
                                    <span class="text-gray-800  mb-3">Dosen/Pengajar :</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <!--begin:: Avatar -->
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                        <a href="#">
                                            <div class="symbol-label">
                                                <img src="{{ $row->dosen?->getPhoto() }}" alt="Emma Smith" class="w-100">
                                            </div>
                                        </a>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::User details-->
                                    <div class="d-flex flex-column">
                                        <a href="#"
                                            class="text-gray-800 text-hover-primary mb-1">{{ $row->dosen?->user?->name }}</a>
                                        <span>NIDN. {{ $row->dosen?->nidn }}</span>
                                    </div>
                                    <!--begin::User details-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" tabindex="-1" id="pretest_dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Pengerjaan Pretest</h3>

                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                </div>
                                <!--end::Close-->
                            </div>

                            <div class="modal-body">
                                <p class="fs-4 fw-semibold text-muted">
                                    {{ $row->pretest?->description ?? '-' }}
                                </p>
                                <table class="fs-6 fw-semibold text-muted">
                                    <tr>
                                        <td>Waktu Pengerjaan</td>
                                        <td style="width: 20px; text-align: center">:</td>
                                        <td>{{ $row->pretest?->duration }} Menit</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Soal</td>
                                        <td style="width: 20px; text-align: center">:</td>
                                        <td>{{ $row->pretest?->soal->count() }} Soal</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <a href="{{ route("mahasiswa.kelas.pretest", $row->kode_kelas) }}" class="btn btn-primary">Kerjakan sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card">
                    <div class="card-body">
                        <div class="card-px text-center pt-15 pb-15">
                            <h2 class="fs-2x fw-bold mb-0">Belum Ada Kelas</h2>
                            <p class="text-gray-500 fs-4 fw-semibold py-7">
                                Anda belum terdaftar pada kelas manapun. <br>
                                Silahkan join ke kelas melalui tombol join kelas dibawah ini.

                            </p>
                            <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                                data-bs-target="#join_kelas">Join Kelas</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('scripts')
@endsection
