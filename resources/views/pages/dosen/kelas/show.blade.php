@extends('app')
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
        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
                <div class="card card-flush mb-5">
                    <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px"
                        style="background-image:url('{{ asset('assets/media/svg/shapes/bg-kelas.png') }}"
                        data-bs-theme="light">
                        <h3 class="card-title align-items-start flex-column text-white pt-15">
                            <span class="fw-bold fs-2x mb-3">
                                {{ $kelas->nama_kelas }} - {{ $kelas->matakuliah->nama_mk }}
                            </span>
                            <div class="fs-4 text-white">
                                <span class="opacity-75">
                                    {{ $kelas->tingkat }} - {{ $kelas->jurusan }}
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
                                                class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $kelas->materi->count() }}</span>
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
                                                class="text-gray-700 fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ $kelas->mahasiswa->count() }}</span>
                                            <span class="text-gray-500 fw-semibold fs-6">Mahasiswa</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-5 mb-xl-8">
                    <div class="card-header border-0">
                        <div class="card-title">
                            <h3 class="fw-bold m-0">Kode Kelas</h3>
                        </div>
                    </div>
                    <div class="card-body pt-2">
                        <div class="input-group">
                            <input id="kt_clipboard_1" type="text" class="form-control" placeholder="name@example.com"
                                value="{{ $kelas->kode_kelas }}" readonly />

                            <button class="btn btn-light-primary" data-clipboard-target="#kt_clipboard_1">
                                Salin
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-lg-row-fluid ms-lg-15">
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                            href="#kt_user_view_materi">Materi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                            href="#kt_user_view_mahasiswa">Mahasiswa
                            @if ($mahasiswa_nonaktif_count > 0)
                                <strong>( {{ $mahasiswa_nonaktif_count }} )</strong>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                            href="#kt_user_view_penilaian">penilaian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                            href="#kt_user_view_pengaturan">Pengaturan</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="kt_user_view_materi" role="tabpanel">
                        @include('pages.dosen.kelas.partials.materi')
                    </div>
                    <div class="tab-pane fade" id="kt_user_view_mahasiswa" role="tabpanel">
                        @include('pages.dosen.kelas.partials.mahasiswa')
                    </div>

                    <div class="tab-pane fade" id="kt_user_view_penilaian" role="tabpanel">
                        @include('pages.dosen.kelas.partials.penilaian')
                    </div>

                    <div class="tab-pane fade" id="kt_user_view_pengaturan" role="tabpanel">
                        @include('pages.dosen.kelas.partials.pengaturan')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let datatable_mahasiswa_aktif = $('#tabel_mahasiswa_aktif').DataTable({
            'columnDefs': [{
                    orderable: false,
                    targets: 0
                }, // Disable ordering on column 0 (checkbox)           
            ]
        });

        const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
        filterSearch.addEventListener('keyup', function(e) {
            datatable_mahasiswa_aktif.search(e.target.value).draw();
        });

        // Select elements
        const target = document.getElementById('kt_clipboard_1');
        const button = target.nextElementSibling;

        // Success action handler
        clipboard.on('success', function(e) {
            const currentLabel = button.innerHTML;

            // Exit label update when already in progress
            if (button.innerHTML === 'Copied!') {
                return;
            }

            // Update button label
            button.innerHTML = 'Copied!';

            // Revert button label after 3 seconds
            setTimeout(function() {
                button.innerHTML = currentLabel;
            }, 3000)
        });
    </script>
@endsection
