@extends('app')
@section('styles')
    <!-- KaTeX -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.16.7/katex.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.16.7/katex.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.16.7/contrib/auto-render.min.js"></script>
    {{-- <style>
        img {
            max-width: 100%;
        }
    </style> --}}
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
        {{-- @include('pages.dosen.materi.partials.content') --}}
        <div class="row g-5 g-xxl-8">
            <div class="d-flex flex-column flex-lg-row">
                <div class="flex-lg-row-fluid ">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update Soal - Pilihan Ganda</h3>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-light-danger" data-bs-toggle="modal"
                                    data-bs-target="#delete_question">
                                    <i class="ki-duotone ki-trash fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </button>
                                <div class="modal fade" tabindex="-1" id="delete_question">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title">Hapus Soal</h3>

                                                <!--begin::Close-->
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                            class="path2"></span></i>
                                                </div>
                                                <!--end::Close-->
                                            </div>
                                            <form
                                                action="{{ route('dosen.kelas.materi.ujianSoalQuestionDelete', [$kode_kelas, $materi_id, $question->id]) }}"
                                                method="post">
                                                @method('DELETE')
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Apakah anda yakin akan menghapus soal ini?</p>
                                                    <p class="text-danger"><strong>Perhatian</strong> : Seluruh data yang
                                                        terkait
                                                        dengan
                                                        soal ini akan dihapus dan tidak dapat dikembalikan.
                                                    </p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">batal</button>
                                                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form
                            action="{{ route('dosen.kelas.materi.ujianSoalQuestionUpdate', [$kode_kelas, $materi_id, $question->id]) }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Untuk mengarahkan ke method update -->

                            <div class="card-body">
                                <div class="mb-5">
                                    <label for="name" class="form-label"> Soal</label>
                                    <div id="question_text_quill" style="height: 200px;">
                                        {!! $question->question !!}
                                    </div>
                                    <input type="hidden" name="question_text" id="question_text"
                                        value="{{ $question->question }}">
                                </div>
                                <div class="mb">
                                    <label for="name" class=" form-label required"> Bobot</label>
                                    <input type="number" class="form-control" id="question_score" name="question_score"
                                        value="{{ $question->score }}" step="0.01" min="0" required>
                                </div>
                                <div class="separator my-10"></div>

                                <div>
                                    <label for="name" class="form-label">Pilihan Ganda</label>

                                    <!--begin::Repeater-->
                                    <div id="kt_docs_repeater_basic">
                                        <!--begin::Form group-->
                                        <div class="form-group">
                                            <div data-repeater-list="choices">
                                                @foreach ($question->examChoices as $index => $choice)
                                                    <div data-repeater-item>
                                                        <input type="hidden" name="choices[{{ $index }}][id]"
                                                            value="{{ $choice->id }}">
                                                        <input type="hidden"
                                                            name="choices[{{ $index }}][is_deleted]" value="0"
                                                            class="is_deleted">
                                                        <div class="form-group row mb-10">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Gambar:</label>
                                                                <input type="file" class="form-control mb-2 mb-md-0"
                                                                    name="choices[{{ isset($choice) ? $loop->index : 'new' }}][choice_image]"
                                                                    accept="image/*" />

                                                                {{-- Hanya tampilkan gambar jika pilihan sudah ada dan punya gambar --}}
                                                                @if (isset($choice) && $choice->choice_image)
                                                                    <div class="mt-2">
                                                                        <label class="form-label">Gambar saat
                                                                            ini:</label><br>
                                                                        <img src="{{ asset('storage/' . $choice->choice_image) }}"
                                                                            alt="Gambar Pilihan"
                                                                            style="max-height: 100px;">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label class="form-label ">Text:</label>
                                                                <textarea class="form-control mb-2 mb-md-0 choice-text-editor" rows="1"
                                                                    name="choices[{{ $index }}][choice_text]" placeholder="text">{{ $choice->choice_text }}</textarea>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div
                                                                    class="form-check form-check-custom form-check-solid mt-2 mt-md-11">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="is_correct" value="{{ $index }}"
                                                                        id="form_radio_{{ $index }}"
                                                                        {{ $choice->is_correct ? 'checked' : '' }}
                                                                        required>
                                                                    <label class="form-check-label"
                                                                        for="form_radio_{{ $index }}">Jawaban
                                                                        Benar</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <a href="javascript:;" data-repeater-delete
                                                                    class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                    <i class="ki-duotone ki-trash fs-5"><span
                                                                            class="path1"></span><span
                                                                            class="path2"></span><span
                                                                            class="path3"></span><span
                                                                            class="path4"></span><span
                                                                            class="path5"></span></i>
                                                                    Hapus
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!--end::Form group-->

                                        <!--begin::Form group-->
                                        <div class="form-group mt-5">
                                            <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                                <i class="ki-duotone ki-plus fs-3"></i>
                                                Tambah Pilihan
                                            </a>
                                        </div>
                                        <!--end::Form group-->
                                    </div>
                                    <!--end::Repeater-->
                                </div>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('dosen.kelas.materi.ujianSoal', [$kode_kelas, $materi_id]) }} }}"
                                    class="btn btn-light">Batal</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>

    <script>
        var quill = new Quill('#question_text_quill', {
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block']
                ]
            },
            placeholder: 'Type your text here...',
            theme: 'snow' // or 'bubble'
        });
        quill.on('text-change', function() {
            $('#question_text').val(quill.root.innerHTML);
        });
    </script>

    <script>
        $('#kt_docs_repeater_basic').repeater({
            initEmpty: false,

            defaultValues: {
                'choice_text': '',
            },

            show: function() {
                $(this).slideDown();
                updateRadioValues();
                initCKEditor();
            },

            hide: function(deleteElement) {
                // Tandai item yang dihapus dengan mengubah nilai input hidden 'is_deleted'
                $(this).find('.is_deleted').val('1');

                $(this).slideUp(deleteElement, function() {
                    // Tetap perbarui radio button setelah item dihapus
                    updateRadioValues();
                });
            }
        });

        // Function to update the name attribute of radio buttons
        function updateRadioValues() {
            var questionName = 'is_correct'; // Nama yang sama untuk semua radio button

            $('#kt_docs_repeater_basic').find('[data-repeater-item]').each(function(index, item) {
                $(item).find('input[type="radio"]').attr('name',
                    questionName); // Tetapkan nama yang sama ke semua radio
            });
        }

        // Panggil saat awal untuk memastikan name radio terupdate
        updateRadioValues();
        initCKEditor();
    </script>
@endsection
