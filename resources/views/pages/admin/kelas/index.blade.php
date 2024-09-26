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
        <div class="card card-flush">
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" data-kt-ecommerce-category-filter="search"
                            class="form-control form-control-solid w-250px ps-12" placeholder="Cari kelas" />
                    </div>
                </div>
                <div class="card-toolbar">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add_category" class="btn btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        Tambah kelas
                    </a>
                </div>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                        data-kt-check-target="#kt_ecommerce_category_table .form-check-input"
                                        value="1" />
                                </div>
                            </th>
                            <th class="min-w-200px">kelas</th>
                            <th class="min-w-150px">Info</th>
                            <th class="min-w-150px">Mata Kuliah</th>
                            <th class="min-w-150px">Dosen</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($list_kelas as $kelas)
                            <tr>
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">

                                        <div class="ms-5">
                                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold mb-1"
                                                data-kt-ecommerce-category-filter="category_name">{{ $kelas->nama_kelas }}</a>
                                            <div class="text-muted fs-7 fw-bold">Kode:
                                                {{ $kelas->kode_kelas }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <ul>
                                            <li><span class="fw-bold">Tingkat: </span>{{ $kelas->tingkat }}</li>
                                            <li><span class="fw-bold">Jurusan: </span>{{ $kelas->jurusan }}</li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    {{ $kelas->matakuliah->nama_mk }}<br>
                                    ({{ $kelas->matakuliah->kode_mk }})
                                </td>
                                <td>
                                    <a class="text-gray-800 text-hover-primary"
                                     href="#">
                                        {{ $kelas->dosen?->user?->name }}
                                    </a>
                                </td>
                                <td class="text-end">
                                    <a href="#"
                                        class="btn btn-sm btn-light btn-active-light-primary btn-flex btn-center"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#edit_kuliah{{ $loop->iteration }}">
                                                Edit</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#delete_matakuliah{{ $loop->iteration }}">
                                                Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="add_category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Tambah kelas</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="{{ route('admin.kelas.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="matkul" class="form-label required">Mata Kuliah</label>
                            <select class="form-select form-select-solid" id="matkul" name="kode_mk" data-control="select2" data-placeholder="Pilih Mata Kuliah" data-dropdown-parent="#add_category" required>
                                <option ></option>
                                @foreach ($list_matakuliah as $matakuliah)
                                    <option value="{{ $matakuliah->kode_mk }}">{{ $matakuliah->nama_mk }}
                                        ({{ $matakuliah->kode_mk }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label required">Nama kelas</label>
                            <input type="text" class="form-control form-control-solid" id="nama_kelas" name="nama_kelas" placeholder="Nama kelas"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="kode_kelas" class="form-label required">Kode kelas</label>
                            <input type="text" class="form-control form-control-solid" id="kode_kelas" name="kode_kelas" placeholder="Kode kelas" value="{{ $kode_kelas_new }}"
                             readonly
                                required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="tingkat" class="form-label required">Tingkat</label>
                                <select class="form-select form-select-solid" id="tingkat" name="tingkat" required>
                                    <option value="">Pilih Tingkat</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label for="jurusan" class="form-label required">Jurusan</label>
                                <input type="text" class="form-control form-control-solid" id="jurusan" name="jurusan" placeholder="Jurusan" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="dosen" class="form-label required">Dosen</label>
                            <select class="form-select form-select-solid" id="dosen" name="nidn"  data-control="select2" data-placeholder="Pilih Dosen" data-dropdown-parent="#add_category"> required>
                                <option></option>
                                @foreach ($list_dosen as $user_dosen)
                                    <option value="{{ $user_dosen->dosen->nidn }}">{{ $user_dosen->name }} ({{ $user_dosen->dosen->nidn }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Buat kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($list_kelas as $kelas)
        <div class="modal fade" tabindex="-1" id="edit_kuliah{{ $loop->iteration }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Edit kelas</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <form action="{{ route('admin.kelas.update', $kelas->kode_kelas) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="modal-body mb-3">
                            <div class="mb-3">
                                <label for="matkul" class="form-label required">Mata Kuliah</label>
                                <select class="form-select form-select-solid" id="matkul" name="kode_mk" required>
                                    <option disabled>Pilih Mata Kuliah</option>
                                    @foreach ($list_matakuliah as $matakuliah)
                                        <option value="{{ $matakuliah->kode_mk }}" @if ($matakuliah->kode_mk == $kelas->kode_mk) selected @endif>{{ $matakuliah->nama_mk }}
                                            ({{ $matakuliah->kode_mk }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="nama_kelas" class="form-label required">Nama kelas</label>
                                <input type="text" class="form-control form-control-solid" id="nama_kelas" name="nama_kelas" placeholder="Nama kelas"
                                    value="{{ $kelas->nama_kelas }}" required> 
                            </div>

                            <div class="mb-3">
                                <label for="kode_kelas" class="form-label required">Kode kelas</label>
                                <input type="text" class="form-control form-control-solid" id="kode_kelas" name="kode_kelas" placeholder="Kode kelas" value="{{ $kelas->kode_kelas }}"
                                    readonly required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="tingkat" class="form-label required">Tingkat</label>
                                    <select class="form-select form-select-solid" id="tingkat" name="tingkat" required>
                                        <option value="">Pilih Tingkat</option>
                                        <option value="S1" @if ($kelas->tingkat == 'S1') selected @endif>S1</option>
                                        <option value="S2" @if ($kelas->tingkat == 'S2') selected @endif>S2</option>
                                        <option value="S3" @if ($kelas->tingkat == 'S3') selected @endif>S3</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label for="jurusan" class="form-label required">Jurusan</label>
                                    <input type="text" class="form-control form-control-solid" id="jurusan" name="jurusan" placeholder="Jurusan"
                                        value="{{ $kelas->jurusan }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="dosen" class="form-label required">Dosen</label>
                                <select class="form-select form-select-solid" id="dosen" name="nidn"  required>
                                    <option disabled>Pilih Dosen</option>
                                    @foreach ($list_dosen as $user_dosen)
                                        <option value="{{ $user_dosen->dosen->nidn }}" @if ($user_dosen->dosen->nidn == $kelas->dosen->nidn) selected @endif>{{ $user_dosen->name }} ({{ $user_dosen->dosen->nidn }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Edit kelas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="delete_matakuliah{{ $loop->iteration }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">Hapus Kelas</h2>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div class="modal-body px-5">
                        <form class="form" method="POST"
                            action="{{ route('admin.kelas.destroy', $kelas->kode_kelas) }}">
                            @method('DELETE')
                            @csrf
                            <p class="text-center">
                                Apakah Anda Yakin Ingin Menghapus Kelas <strong>{{ $kelas->nama_kelas }} (
                                    {{ $kelas->kode_kelas }} )</strong> ?
                            </p>
                            <div class="text-center pt-10">
                                <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal"
                                    aria-label="Close">batal</button>
                                <button type="submit" class="btn btn-danger" data-kt-users-modal-action="submit">
                                    <span class="indicator-label">Hapus</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/categories.js') }}"></script>
@endsection
