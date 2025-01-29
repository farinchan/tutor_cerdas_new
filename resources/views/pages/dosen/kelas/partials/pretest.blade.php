@if ($exam)

<div class="row g-5 g-xxl-8">
    <div class="d-flex flex-column flex-lg-row">
        <div class="flex-lg-row-fluid ">
            @if ($exam)
                <div class="d-flex flex-wrap flex-stack ">
                    <h3 class="fw-bold my-2">Pre-Test Soal
                        <span class="fs-6 text-gray-500 fw-semibold ms-1">
                            ( {{ $list_exam_question->count() }} soal )
                        </span>
                        <span class="fs-6 text-gray-500 fw-semibold ms-1">
                            ( Total Bobot : {{ $list_exam_question->sum('score') }} )
                        </span>
                    </h3>
                    <div class="d-flex my-2">
                        {{-- <div class="d-flex align-items-center position-relative me-4">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute translate-middle-y top-50 ms-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <form action="" method="get">

                            <input type="text"
                                class="form-control form-control-sm form-control-solid bg-body fw-semibold fs-7 w-150px ps-11"
                                placeholder="Cari" name="q" value="{{ request()->q }}" />
                        </form>
                    </div> --}}
                        <a href="#" class='btn btn-bg-light btn-active-color-danger btn-sm'
                            data-bs-toggle="modal" data-bs-target="#reset">
                            <i class="ki-duotone ki-file-deleted fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Reset Soal</a>
                        <a href="#" class='btn btn-bg-light btn-active-color-primary btn-sm'
                            data-bs-toggle="modal" data-bs-target="#import">
                            <i class="ki-duotone ki-file-down fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Import</a>
                        <a href="{{ route('dosen.kelas.pretestQuestionCreate', $kelas->kode_kelas) }}"
                            class='btn btn-primary btn-sm fw-bolder' class="btn btn-primary">
                            <i class="ki-duotone ki-plus fs-2"></i>
                            Tambah Soal</a>
                    </div>
                </div>

                <div class="row g-6 g-xl-9">
                    @foreach ($list_exam_question as $question)
                        <div class="col-md-6 col-xl-6">
                            <a href="{{ route('dosen.kelas.pretestQuestionEdit', [$kelas->kode_kelas, $question->id]) }}"
                                class="card border-hover-primary">
                                {{-- <div class="card-header border-0 pt-5">
                                    <div class="card-title m-0">
                                        @if ($question->question_type == 'pilihan ganda')
                                            <span class="badge badge-light-primary me-2">Pilihan Ganda</span>
                                        @elseif ($question->question_type == 'pilihan ganda kompleks')
                                            <span class="badge badge-light-warning me-2">Pilihan Ganda Kompleks</span>
                                        @elseif ($question->question_type == 'menjodohkan')
                                            <span class="badge badge-light-success me-2">Menjodohkan</span>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="card-body p-9">
                                    <div class="fs-3 fw-bold text-gray-900">
                                        No. {{ $loop->iteration }}
                                    </div>

                                    <p class="text-gray-500 fw-semibold fs-5 mt-1 mb-7">
                                        Soal: {{ Str::limit(strip_tags($question->question), 100) }}
                                    </p>
                                    <div class="fs-5 text-gray-900">
                                        Bobot: {{ $question->score }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card h-md-100" dir="ltr">
                    <div class="card-body d-flex flex-column flex-center">
                        <div class="mb-2">
                            <h1 class="fw-semibold text-gray-800 text-center lh-lg">
                                Ujian Materi
                            </h1>
                            <span class="">
                                Anda Belum Membuat Ujian dari Materi ini, silahkan buat ujian terlebih dahulu
                            </span>
                            <div class="py-5 text-center">
                                {{-- <img src="{{asset("assets/media/svg/illustrations/easy/3.svg")}} " class="theme-light-show w-200px" alt="" />
                            <img src="assets/media/svg/illustrations/easy/3-dark.svg" class="theme-dark-show w-200px" alt="" /> --}}
                            </div>
                        </div>
                        <div class="text-center mb-1">
                            <a class="btn btn-sm btn-primary me-2" data-bs-target="#create_exam"
                                data-bs-toggle="modal">Buat Ujian Sekarang</a>

                        </div>
                        <div class="modal fade" tabindex="-1" id="create_exam">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Buat Ujian</h3>

                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                            data-bs-dismiss="modal" aria-label="Close">
                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>

                                    <form
                                        action="#"
                                        method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nama_kelas"
                                                    class="form-label required">Deskripsi</label>
                                                <textarea class="form-control form-control-solid" id="description" name="description" placeholder="Deskripsi Ujian"
                                                    required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama_kelas" class="form-label required">Durasi
                                                    Ujian</label>
                                                <input type="number" class="form-control form-control-solid"
                                                    id="duration" name="duration" placeholder="Durasi Ujian"
                                                    required />
                                                <span class="form-text text-muted">Durasi Ujian dalam menit</span>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-body">
        <div class="card-px text-center pt-15 pb-15">
            <h2 class="fs-2x fw-bold mb-0">Pre-Test</h2>
            <p class="text-gray-500 fs-4 fw-semibold py-7">
                Anda belum menambahkan Pre-Test pada kelas ini <br>
                Silahkan tambahkan Pre-Test terlebih dahulu
            </p>
            <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#pretest_create">Buat Pretest</a>
        </div>
        <div class="text-center pb-15 px-5">
            <img src="{{asset("assets/media/illustrations/sketchy-1/17.png")}}" alt="" class="mw-100 h-200px h-sm-325px">
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="pretest_create">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Buat Pre-Test</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                            class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <form
                action="{{ route('dosen.kelas.pretestCreate', $kelas->kode_kelas) }}"
                method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kelas"
                            class="form-label required">Deskripsi</label>
                        <textarea class="form-control form-control-solid" id="description" name="description" placeholder="Deskripsi Ujian"
                            required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label required">Durasi
                            Ujian</label>
                        <input type="number" class="form-control form-control-solid"
                            id="duration" name="duration" placeholder="Durasi Ujian"
                            required />
                        <span class="form-text text-muted">Durasi Ujian dalam menit</span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif


