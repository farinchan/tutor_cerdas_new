@php
    $materi = \App\Models\Materi::where('kode_kelas', $kelas->kode_kelas)->pluck('id')->toArray();

@endphp

<div class="card mb-3">
    <div class="card-header card-header-stretch">
        <h3 class="card-title">{{ __('class.assessment') }}</h3>
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_7">{{ __('class.student') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_8">{{ __('class.general') }}</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="kt_tab_pane_7" role="tabpanel">

        <div class="card pt-4 mb-6 mb-xl-9">
            <div class="card-header border-0">
                <div class="card-title">
                    <h2>{{ __('class.student_assessment') }}</h2>
                </div>
            </div>
            <div class="card-body pt-0 pb-5">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                        <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                            <tr class="text-start text-muted text-uppercase gs-0">
                                <th class="min-w-100px" rowspan="2">NIM</th>
                                <th class="min-w-100px" rowspan="2">Nama</th>
                                <th class="text-center" rowspan="2">Pretest</th>
                                <th class="text-center" rowspan="2">UTS</th>
                                <th class="text-center" rowspan="2">UAS</th>
                                @if(count($materi) > 0)
                                    <th class="text-center" colspan="{{ count($materi) }}">Materi</th>
                                @endif
                                <th class="text-end" rowspan="2">Actions</th>
                            </tr>
                            @if(count($materi) > 0)
                            <tr class="text-start text-muted text-uppercase gs-0">
                                @for($i = 1; $i <= count($materi); $i++)
                                    <th class="text-center">{{ $i }}</th>
                                @endfor
                            </tr>
                            @endif
                        </thead>
                        <tbody class="fs-6 fw-semibold text-gray-600">
                            {{-- @dd($list_nilai_mahasiswa) --}}
                            @foreach ($list_nilai_mahasiswa as $nilai_mahasiswa)
                                <tr>
                                    <td>{{ $nilai_mahasiswa->nim }}</td>
                                    <td>{{ $nilai_mahasiswa->name }}</td>
                                    <td class="text-center">{{ $nilai_mahasiswa->nilai_pretest ?? '-' }}
                                    <td class="text-center">{{ $nilai_mahasiswa->nilai_uts ?? '-' }}</td>
                                    <td class="text-center">{{ $nilai_mahasiswa->nilai_uas ?? '-' }}</td>
                                    @foreach ($materi as $id_materi)
                                        <td class="text-center">
                                            @php
                                                $nilai = \App\Models\ExamSession::whereHas('exam', function (
                                                    $query,
                                                ) use ($id_materi) {
                                                    $query->where('materi_id', $id_materi);
                                                })
                                                    ->where('user_id', $nilai_mahasiswa->id)
                                                    ->orderBy('score', 'desc')
                                                    ->pluck('score')
                                                    ->first();
                                            @endphp
                                            {{ $nilai ?? '-' }}
                                        </td>
                                    @endforeach
                                    <td class="text-end">
                                        <a href="#" class="btn btn-icon btn-light-linkedin me-2 "
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal_nilai{{ $nilai_mahasiswa->nim }}">
                                            <i class="fa-solid fa-pen-to-square fs-4"></i>
                                        </a>
                                    </td>
                                </tr>

                                <div class="modal fade" tabindex="-1" id="modal_nilai{{ $nilai_mahasiswa->nim }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title">Nilai Siswa</h3>

                                                <!--begin::Close-->
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                    <i class="ki-duotone ki-cross fs-1"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                </div>
                                                <!--end::Close-->
                                            </div>

                                            <form action="{{ route('dosen.kelas.updateNilai', $kelas->kode_kelas) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">

                                                    <div class="mb-8">
                                                        <label class="form-label fw-bold required">NIM:</label>
                                                        <input type="text" class="form-control " placeholder="NIM"
                                                            value="{{ $nilai_mahasiswa->nim }}" name="nim"
                                                            readonly />
                                                    </div>
                                                    <div class="mb-8">
                                                        <label class="form-label fw-bold required">Nama:</label>
                                                        <input type="text" class="form-control " placeholder="Nama"
                                                            value="{{ $nilai_mahasiswa->name }}" readonly />
                                                    </div>
                                                    <div class="mb-8">
                                                        <label class="form-label fw-bold">Tugas:</label>
                                                        <input type="number" class="form-control " placeholder="Tugas"
                                                            name="nilai_tugas"
                                                            value="{{ $nilai_mahasiswa->nilai_tugas }}" />
                                                    </div>
                                                    <div class="mb-8">
                                                        <label class="form-label fw-bold">Quiz:</label>
                                                        <input type="number" class="form-control " placeholder="Quiz"
                                                            name="nilai_quiz"
                                                            value="{{ $nilai_mahasiswa->nilai_quiz }}" />
                                                    </div>
                                                    <div class="mb-8">
                                                        <label class="form-label fw-bold">UTS:</label>
                                                        <input type="number" class="form-control " placeholder="UTS"
                                                            name="nilai_uts"
                                                            value="{{ $nilai_mahasiswa->nilai_uts }}" />
                                                    </div>
                                                    <div class="mb-8">
                                                        <label class="form-label fw-bold">UAS:</label>
                                                        <input type="number" class="form-control " placeholder="UAS"
                                                            name="nilai_uas"
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

    <div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">
        <div class="card pt-4 mb-6 mb-xl-9">
            <div class="card-header border-0">
                <div class="card-title">
                    <h2>{{ __('class.general_user_pretest_score') }}</h2>
                </div>
            </div>
            <div class="card-body pt-0 pb-5">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                        <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                            <tr class="text-start text-muted text-uppercase gs-0">
                                <th>Name</th>
                                <th class="text-end">{{ __('class.score') }}</th>
                            </tr>
                        </thead>
                        <tbody class="fs-6 fw-semibold text-gray-600">
                            @forelse ($general_pretests as $general_pretest)
                                <tr>
                                    <td>{{ $general_pretest->user->name }}</td>
                                    <td class="text-end text-bold">{{ $general_pretest->score }}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
