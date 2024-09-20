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