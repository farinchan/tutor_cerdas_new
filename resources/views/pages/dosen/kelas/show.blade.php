@extends('app')
@section('subheader')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">View User Details</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="index.html" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">User Management</li>
                    <li class="breadcrumb-item text-gray-600">Users</li>
                    <li class="breadcrumb-item text-gray-500">View User</li>
                </ul>
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
                                <strong>{{ $mahasiswa_nonaktif_count }}</strong>
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
                                <div class="card-toolbar">
                                    <a href="{{ route('dosen.materi.create', $kelas->kode_kelas) }}"
                                        class="btn btn-light-primary btn-sm">
                                        <i class="ki-duotone ki-plus fs-3">
                                        </i>Tambah Materi
                                    </a>
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
                                                    <a href="#"
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
                                                <button class="btn btn-sm btn-light btn-active-light-primary">Pelajari
                                                    Sekarang</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kt_user_view_mahasiswa" role="tabpanel">
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h2>Permintaan Bergabung</h2>
                                </div>
                            </div>
                            <div class="card-body py-4">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">

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
                                            <th class="min-w-125px">status</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        @foreach ($list_mahasiswa_nonaktif as $mahasiswa_nonaktif)
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
                                                                <img src="{{ $mahasiswa_nonaktif->mahasiswa?->getPhoto() }}"
                                                                    alt="{{ $mahasiswa_nonaktif->name }}"
                                                                    width="50px" />
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <a href="#"
                                                            class="text-gray-800 text-hover-primary mb-1">{{ $mahasiswa_nonaktif->mahasiswa?->user->name }}</a>
                                                        <span>NIM. {{ $mahasiswa_nonaktif->mahasiswa?->nim }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-light-danger">Tidak Aktif</span>
                                                </td>
                                                <td class="text-end min-w-200px">
                                                    <a href="#" class="btn btn-icon btn-light-linkedin me-2 "
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#view_user{{ $mahasiswa_nonaktif->id }}"><i
                                                            class="far fa-eye fs-4"></i></a>
                                                    <form style="display: inline-block;" action="" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-icon btn-light-twitter me-2">
                                                            <i class="fas fa-check fs-4"></i>
                                                        </button>
                                                    </form>
                                                    <a href="#" class="btn btn-icon btn-light-youtube me-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_delete_user{{ $mahasiswa_nonaktif->id }}"><i
                                                            class="fas fa-times fs-4"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">


                                        <button type="button" class="btn btn-primary">
                                            <i class="ki-duotone ki-plus fs-2"></i>Invite</button>
                                    </div>
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
                                            <th class="text-end min-w-100px">Actions</th>
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
                                                                <img src="{{ $mahasiswa->mahasiswa?->getPhoto() }}"
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
                                                <td class="text-end">
                                                    <a href="#"
                                                        class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                                        data-kt-menu-trigger="click"
                                                        data-kt-menu-placement="bottom-end">Actions
                                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                        data-kt-menu="true">
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#kick_mahasiswa{{ $mahasiswa->id }}">Keluarkan</a>
                                                        </div>
                                                    </div>
                                                </td>
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
                                    <h2>Penilaian Mahasiswa</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0 pb-5">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed gy-5"
                                        id="kt_table_users_login_session">
                                        <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                            <tr class="text-start text-muted text-uppercase gs-0">
                                                <th class="min-w-100px">NIM</th>
                                                <th>Nama</th>
                                                <th class="text-center">Tugas</th>
                                                <th class="text-center">Quiz</th>
                                                <th class="text-center">UTS</th>
                                                <th class="text-center">UAS</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fs-6 fw-semibold text-gray-600">
                                            @foreach ($list_nilai_mahasiswa as $nilai_mahasiswa)
                                                <tr>
                                                    <td>{{ $nilai_mahasiswa->nim }}</td>
                                                    <td>{{ $nilai_mahasiswa->name }}</td>
                                                    <td class="text-center">{{ $nilai_mahasiswa->nilai_tugas ?? '-' }}
                                                    </td>
                                                    <td class="text-center">{{ $nilai_mahasiswa->nilai_quiz ?? '-' }}</td>
                                                    <td class="text-center">{{ $nilai_mahasiswa->nilai_uts ?? '-' }}</td>
                                                    <td class="text-center">{{ $nilai_mahasiswa->nilai_uas ?? '-' }}</td>
                                                    <td class="text-end">
                                                        <a href="#" class="btn btn-icon btn-light-linkedin me-2 "
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modal_nilai{{ $nilai_mahasiswa->nim }}">
                                                            <i class="fa-solid fa-pen-to-square fs-4"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                                <div class="modal fade" tabindex="-1"
                                                    id="modal_nilai{{ $nilai_mahasiswa->nim }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title">Nilai Siswa</h3>

                                                                <!--begin::Close-->
                                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="ki-duotone ki-cross fs-1"><span
                                                                            class="path1"></span><span
                                                                            class="path2"></span></i>
                                                                </div>
                                                                <!--end::Close-->
                                                            </div>

                                                            <form
                                                                action="{{ route('dosen.kelas.updateNilai', $kelas->kode_kelas) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">

                                                                    <div class="mb-8">
                                                                        <label
                                                                            class="form-label fw-bold required">NIM:</label>
                                                                        <input type="text" class="form-control "
                                                                            placeholder="NIM"
                                                                            value="{{ $nilai_mahasiswa->nim }}"
                                                                            name="nim" readonly />
                                                                    </div>
                                                                    <div class="mb-8">
                                                                        <label
                                                                            class="form-label fw-bold required">Nama:</label>
                                                                        <input type="text" class="form-control "
                                                                            placeholder="Nama"
                                                                            value="{{ $nilai_mahasiswa->name }}"
                                                                            readonly />
                                                                    </div>
                                                                    <div class="mb-8">
                                                                        <label class="form-label fw-bold">Tugas:</label>
                                                                        <input type="number" class="form-control "
                                                                            placeholder="Tugas" name="nilai_tugas"
                                                                            value="{{ $nilai_mahasiswa->nilai_tugas }}" />
                                                                    </div>
                                                                    <div class="mb-8">
                                                                        <label class="form-label fw-bold">Quiz:</label>
                                                                        <input type="number" class="form-control "
                                                                            placeholder="Quiz" name="nilai_quiz"
                                                                            value="{{ $nilai_mahasiswa->nilai_quiz }}" />
                                                                    </div>
                                                                    <div class="mb-8">
                                                                        <label class="form-label fw-bold">UTS:</label>
                                                                        <input type="number" class="form-control "
                                                                            placeholder="UTS" name="nilai_uts"
                                                                            value="{{ $nilai_mahasiswa->nilai_uts }}" />
                                                                    </div>
                                                                    <div class="mb-8">
                                                                        <label class="form-label fw-bold">UAS:</label>
                                                                        <input type="number" class="form-control "
                                                                            placeholder="UAS" name="nilai_uas"
                                                                            value="{{ $nilai_mahasiswa->nilai_uas }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        changes</button>
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
                    </div>

                    <div class="tab-pane fade" id="kt_user_view_pengaturan" role="tabpanel">
                        <div class="card pt-4 mb-6 mb-xl-9">
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h2>Pengaturan Kelas</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0 pb-5">
                                <form action="{{ route('dosen.kelas.store') }}" method="POST">
                                    @csrf

                                    <div class="modal-body">
                                        <div class="row mb-8">
                                            <div class="col-lg-8">
                                                <label class="form-label fw-bold required">Mata Kuliah:</label>
                                                <input type="text" class="form-control " placeholder="Mata Kuliah"
                                                    name="matakuliah" value="{{ old('') }}" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="form-label fw-bold required">SKS:</label>
                                                <input type="number" class="form-control " placeholder="SKS"
                                                    name="sks" value="{{ old('sks') }}" />
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="mb-8 mt-8">
                                            <label class="form-label fw-bold required">Kode Kelas:</label>
                                            <input type="text" class="form-control " placeholder="Kode Kelas"
                                                value="{{ $kelas->kode_kelas }}" readonly />
                                        </div>
                                        <div class="mb-8 mt-5">
                                            <label class="form-label fw-bold required">Nama Kelas:</label>
                                            <input type="text" class="form-control " name="nama_kelas"
                                                placeholder="Nama Kelas" value="{{ $kelas->nama_kelas }}" />
                                        </div>
                                        <div class="mb-8">
                                            <label class="form-label fw-bold required">Tingkat:</label>
                                            <select class="form-select" data-placeholder="Pilih Tingkat" name="tingkat"
                                                required>
                                                <option>Pilih Tingkat</option>
                                                <option value="D3" {{ $kelas->tingkat == 'D3' ? 'selected' : '' }}>D3
                                                </option>
                                                <option value="D4" {{ $kelas->tingkat == 'D4' ? 'selected' : '' }}>D4
                                                </option>
                                                <option value="S1" {{ $kelas->tingkat == 'S1' ? 'selected' : '' }}>S1
                                                </option>
                                                <option value="S2" {{ $kelas->tingkat == 'S2' ? 'selected' : '' }}>S2
                                                </option>
                                                <option value="S3" {{ $kelas->tingkat == 'S3' ? 'selected' : '' }}>S3
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-8">
                                            <label class="form-label fw-bold required">Jurusan:</label>
                                            <input type="text" class="form-control " placeholder="Jurusan"
                                                name="jurusan" value="{{ $kelas->jurusan }}" required />
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-light"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Buat Sekarang</button>
                                    </div>
                                </form>
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
