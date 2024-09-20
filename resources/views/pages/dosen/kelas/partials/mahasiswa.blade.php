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
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                data-kt-check-target="#kt_table_users .form-check-input" value="1" />
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
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <td class="d-flex align-items-center">
                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <a href="#">
                                    <div class="symbol-label">
                                        <img src="{{ $mahasiswa_nonaktif->mahasiswa?->user?->getPhoto() }}"
                                            alt="{{ $mahasiswa_nonaktif->name }}" width="50px" />
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
                            <a href="#" class="btn btn-icon btn-light-linkedin me-2 " data-bs-toggle="modal"
                                data-bs-target="#view_user_mhs_nonaktif{{ $mahasiswa_nonaktif->id }}"><i
                                    class="far fa-eye fs-4"></i></a>
                            <form style="display: inline-block;" method="POST"
                                action="{{ route('dosen.mahasiswa.accept', $mahasiswa_nonaktif->id) }}">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-icon btn-light-twitter me-2">
                                    <i class="fas fa-check fs-4"></i>
                                </button>
                            </form>
                            <form style="display: inline-block;"
                                action="{{ route('dosen.mahasiswa.reject', $mahasiswa_nonaktif->id) }}" method="POST">
                                @csrf
                                @method('put')
                                <button type="submit" href="#" class="btn btn-icon btn-light-youtube me-2"><i
                                        class="fas fa-times fs-4"></i></button>
                            </form>

                        </td>
                    </tr>

                    <div class="modal fade" tabindex="-1" id="view_user_mhs_nonaktif{{ $mahasiswa_nonaktif->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Detail Mahasiswa</h3>

                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                        data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ki ki-close fs-1"></i>
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <div class="modal-body py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="symbol symbol-100px symbol-circle mb-4">
                                            <img src="{{ $mahasiswa_nonaktif->mahasiswa?->user?->getPhoto() }}"
                                                alt="{{ $mahasiswa_nonaktif->name }}" />
                                        </div>
                                        <h4 class="fw-bolder">{{ $mahasiswa_nonaktif->mahasiswa?->user->name }}</h4>
                                        <span class="badge badge-light-danger">Tidak Aktif</span>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">NIM</span>
                                            <span>{{ $mahasiswa_nonaktif->mahasiswa?->nim }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">Jurusan</span>
                                            <span>{{ $mahasiswa_nonaktif->mahasiswa?->jurusan }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">Email</span>
                                            <span>{{ $mahasiswa_nonaktif->mahasiswa?->user->email }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">Jenis Kelamin</span>
                                            <span>
                                                @if ($mahasiswa_nonaktif->mahasiswa?->jenis_kelamin == 'L')
                                                    Laki-laki
                                                @else
                                                    Perempuan
                                                @endif
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">Agama</span>
                                            <span>{{ $mahasiswa_nonaktif->mahasiswa?->agama }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">Alamat</span>
                                            <span>{{ $mahasiswa_nonaktif->mahasiswa?->alamat }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    class="form-control form-control-solid w-250px ps-13" placeholder="Cari Mahasiswa" />
            </div>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#invite_mahasiswa">
                    <i class="ki-duotone ki-plus fs-2"></i>
                    Invite
                </button>
            </div>
            <div class="d-flex justify-content-end align-items-center d-none">
                <div class="fw-bold me-5">
                    <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                </div>
                <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete
                    Selected</button>
            </div>

        </div>
    </div>
    <div class="card-body py-4">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="tabel_mahasiswa_aktif">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                data-kt-check-target="#kt_table_users .form-check-input" value="1" />
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
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
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
                        <td class="text-end">
                            <a href="#"
                                class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                        data-bs-target="#view_user_mhs_aktif{{ $mahasiswa->id }}">Lihat</a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                        data-bs-target="#kick_mahasiswa{{ $mahasiswa->id }}">Keluarkan</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" tabindex="-1" id="view_user_mhs_aktif{{ $mahasiswa->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Detail Mahasiswa</h3>

                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                        data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ki ki-close fs-1"></i>
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <div class="modal-body py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="symbol symbol-100px symbol-circle mb-4">
                                            <img src="{{ $mahasiswa->mahasiswa?->user?->getPhoto() }}"
                                                alt="{{ $mahasiswa->name }}" />
                                        </div>
                                        <h4 class="fw-bolder">{{ $mahasiswa->mahasiswa?->user->name }}</h4>
                                        <span class="badge badge-light-success">Aktif</span>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">NIM</span>
                                            <span>{{ $mahasiswa->mahasiswa?->nim }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">Jurusan</span>
                                            <span>{{ $mahasiswa->mahasiswa?->jurusan }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">Email</span>
                                            <span>{{ $mahasiswa->mahasiswa?->user->email }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">Jenis Kelamin</span>
                                            <span>
                                                @if ($mahasiswa->mahasiswa?->jenis_kelamin == 'L')
                                                    Laki-laki
                                                @else
                                                    Perempuan
                                                @endif
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">Agama</span>
                                            <span>{{ $mahasiswa->mahasiswa?->agama }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">Alamat</span>
                                            <span>{{ $mahasiswa->mahasiswa?->alamat }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" tabindex="-1" id="kick_mahasiswa{{ $mahasiswa->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Kick Mahasiswa</h3>

                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                        data-bs-dismiss="modal" aria-label="Close">
                                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
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
                                        <button type="submit" class="btn btn-danger">kick</button>
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

<div class="modal fade" tabindex="-1" id="invite_mahasiswa">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Invite Mahasiswa</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki ki-close fs-1"></i>
                </div>
                <!--end::Close-->
            </div>
            <form action="{{ route('dosen.mahasiswa.invite', $kelas->kode_kelas) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-10">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="NIM Mahasiswa" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Invite</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
