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
                            class="form-control form-control-solid w-250px ps-12" placeholder="Cari Mata kuliah" />
                    </div>
                </div>
                <div class="card-toolbar">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add_category" class="btn btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i>
                        Tambah Mata kuliah
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
                            <th class="min-w-250px">Mata kuliah</th>
                            <th class="min-w-150px">SKS</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($list_matakuliah as $matakuliah)
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
                                                data-kt-ecommerce-category-filter="category_name">{{ $matakuliah->nama_mk }}</a>
                                            <div class="text-muted fs-7 fw-bold">Kode:
                                                {{ $matakuliah->kode_mk }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="badge">{{ $matakuliah->sks }}</div>
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
                                                data-bs-target="#edit_matakuliah{{ $loop->iteration }}">
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
                    <h3 class="modal-title">Tambah Mata Kuliah</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="{{ route('admin.matakuliah.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_mk" class="form-label required">Nama Mata Kuliah</label>
                            <input type="text" class="form-control form-control-solid" id="nama_mk" name="nama_mk"
                                placeholder="Nama Matakuliah" required>
                        </div>

                        <div class="mb-3">
                            <label for="kode_mk" class="form-label required">Kode Mata Kuliah</label>
                            <input type="text" class="form-control form-control-solid" id="kode_mk" name="kode_mk"
                                placeholder="Kode Mata Kuliah" required>
                        </div>

                        <div class="mb-3">
                            <label for="sks" class="form-label required">SKS</label>
                            <input type="number" class="form-control form-control-solid" id="sks" name="sks"
                                placeholder="SKS Mata Kuliah" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Buat Mata Kuliah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($list_matakuliah as $matakuliah)
        <div class="modal fade" tabindex="-1" id="edit_matakuliah{{ $loop->iteration }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Edit Mata Kuliah</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <form action="{{ route('admin.matakuliah.update', $matakuliah->kode_mk) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="modal-body mb-3">
                            <div class="mb-3">
                                <label for="nama_mk" class="form-label required">Nama Mata Kuliah</label>
                                <input type="text" class="form-control form-control-solid" id="nama_mk" name="nama_mk"
                                    value="{{ $matakuliah->nama_mk }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="kode_mk" class="form-label required">Kode Mata Kuliah</label>
                                <input type="text" class="form-control form-control-solid" id="kode_mk" name="kode_mk"
                                    value="{{ $matakuliah->kode_mk }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="sks" class="form-label required">SKS</label>
                                <input type="number" class="form-control form-control-solid" id="sks" name="sks"
                                    value="{{ $matakuliah->sks }}" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Edit Mata Kuliah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="delete_matakuliah{{ $loop->iteration }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">Hapus Mata Kuliah</h2>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <div class="modal-body px-5">
                        <form class="form" method="POST"
                            action="{{ route('admin.matakuliah.destroy', $matakuliah->kode_mk) }}">
                            @method('DELETE')
                            @csrf
                            <p class="text-center">
                                Apakah Anda Yakin Ingin Menghapus Matakuliah <strong>{{ $matakuliah->nama_mk }} (
                                    {{ $matakuliah->kode_mk }} )</strong> ?
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
