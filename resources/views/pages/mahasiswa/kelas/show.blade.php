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
                                <a class="fw-bold text-white fs-2x mb-3 text-hover-info"
                                    href="{{ route('mahasiswa.kelas.show', $kelas->kode_kelas) }} ">
                                    {{ $kelas->nama_kelas }} - {{ $kelas->matakuliah->nama_mk }}
                                </a>
                                <div class="fs-4 text-white">
                                    <span class="opacity-75">
                                        {{ $kelas->tingkat }} - {{ $kelas->jurusan }}
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
                                                <img src="{{ $kelas->dosen?->user?->getPhoto() }}" alt="Emma Smith"
                                                    class="w-100">
                                            </div>
                                        </a>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::User details-->
                                    <div class="d-flex flex-column">
                                        <a href="#"
                                            class="text-gray-800 text-hover-primary mb-1">{{ $kelas->dosen?->user?->name }}</a>
                                        <span>NIDN. {{ $kelas->dosen?->nidn }}</span>
                                    </div>
                                    <!--begin::User details-->
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
                            href="#kt_user_view_mahasiswa">Anggota Kelas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                            href="#kt_user_view_penilaian">Nilai Saya</a>
                    </li>
                    
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="kt_user_view_materi" role="tabpanel">
                        <div class="card card-flush mb-6 mb-xl-9">
                            <div class="card-header mt-6">
                                <div class="card-title flex-column">
                                    <h2 class="mb-1">
                                        Materi Pembelajaran
                                    </h2>
                                    <div class="fs-6 fw-semibold text-muted">
                                        Total Materi: {{ $kelas->materi->count() }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-9 pt-4">
                                @foreach ($kelas->materi as $materi)
                                    <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6 mb-5">
                                        <div class="d-flex flex-column py-2">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('assets/media/books.png') }}" alt=""
                                                    width="80px" class="me-4">
                                                <div>
                                                    <a href="{{ route("mahasiswa.kelas.materi", [$kelas->kode_kelas, $materi->id]) }}"
                                                        class="fs-4 fw-bold text-hover-primary text-gray-800">
                                                        {{ $materi->judul }}
                                                    </a>
                                                    <div class="fs-6 fw-semibold text-gray-500">
                                                        {{ $materi->deskripsi }}
                                                    </div>
                                                    <small class="mt-2">
                                                        <span class="text-muted fs-6">Tanggal Publish:</span>
                                                        <span
                                                            class="text-primary fs-6 fw-bold">{{ $materi->created_at->diffForHumans() }}</span>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="separator separator-dashed my-7"></div>
                                            <div class="text-end">
                                                <a href="{{ route("mahasiswa.kelas.materi", [$kelas->kode_kelas, $materi->id]) }}" class="btn btn-sm btn-light btn-active-light-primary">Pelajari
                                                    Sekarang</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_user_view_mahasiswa" role="tabpanel">
                        <div class="card">
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" data-kt-user-table-filter="search"
                                            class="form-control form-control-solid w-250px ps-13"
                                            placeholder="Cari Mahasiswa" />
                                    </div>
                                </div>
                                <div class="card-toolbar">
                                    <div class="d-flex justify-content-end align-items-center d-none">
                                        <div class="fw-bold me-5">
                                            <span class="me-2"
                                                data-kt-user-table-select="selected_count"></span>Selected
                                        </div>
                                        <button type="button" class="btn btn-danger"
                                            data-kt-user-table-select="delete_selected">Delete
                                            Selected</button>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body py-4">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="tabel_mahasiswa_aktif">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th class="w-10px pe-2">
                                                <div
                                                    class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                        data-kt-check-target="#kt_table_users .form-check-input"
                                                        value="1" />
                                                </div>
                                            </th>
                                            <th class="min-w-125px">Mahasiswa</th>
                                            <th class="min-w-125px">Waktu Bergabung</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        @foreach ($list_mahasiswa as $mahasiswa)
                                            <tr>
                                                <td>
                                                    <div
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="1" />
                                                    </div>
                                                </td>
                                                <td class="d-flex align-items-center">
                                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                        <a href="#">
                                                            <div class="symbol-label">
                                                                <img src="{{ $mahasiswa->mahasiswa?->user?->getPhoto() }}"
                                                                    alt="{{ $mahasiswa->name }}" width="50px" />
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="#"
                                                            class="text-gray-800 text-hover-primary mb-1">{{ $mahasiswa->mahasiswa?->user->name }}</a>
                                                        <span>NIM. {{ $mahasiswa->mahasiswa?->nim }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $mahasiswa->created_at->diffForHumans() }}</td>
                                            </tr>
                                            <div class="modal fade" tabindex="-1"
                                                id="kick_mahasiswa{{ $mahasiswa->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title">Kick Mahasiswa</h3>

                                                            <!--begin::Close-->
                                                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="ki-duotone ki-cross fs-1"><span
                                                                        class="path1"></span><span
                                                                        class="path2"></span></i>
                                                            </div>
                                                            <!--end::Close-->
                                                        </div>
                                                        <form action="{{ route('dosen.mahasiswa.kick', $mahasiswa->id) }}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-body">
                                                                <p>
                                                                    Apakah anda yakin ingin mengeluarkan
                                                                    <strong>{{ $mahasiswa->mahasiswa?->user->name }}</strong>
                                                                    dari kelas ini?
                                                                </p>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">kick</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="kt_user_view_penilaian" role="tabpanel">
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h2>Nilai Saya</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0 pb-5">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="fw-bold fs-6 text-gray-800">
                                                <th class="text-center" colspan="6" >Nilai</th>
                                            </tr>
                                            <tr class="fw-bold fs-6 text-gray-800">
                                                <th class="text-center">Tugas</th>
                                                <th class="text-center">Quiz</th>
                                                <th class="text-center">UTS</th>
                                                <th class="text-center">UAS</th>
                                                <th class="text-center">Nilai Akhir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">{{ $nilai_saya->nilai_tugas??"-" }}</td>
                                                <td class="text-center">{{ $nilai_saya->nilai_quiz??"-" }}</td>
                                                <td class="text-center">{{ $nilai_saya->nilai_uts??"-" }}</td>
                                                <td class="text-center">{{ $nilai_saya->nilaiuas??"-" }}</td>
                                                <td class="text-center">{{ $nilai_saya->nilai_akhir??"-" }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
