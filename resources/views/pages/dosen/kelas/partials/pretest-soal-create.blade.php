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
                            <h3 class="card-title">Buat Soal - PIlihan Ganda</h3>
                        </div>
                        <form action="{{ route('dosen.kelas.pretestQuestionStore', $kode_kelas) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="mb-5">
                                    <label for="name" class=" form-label"> Soal</label>
                                    <div id="question_text_quill" style="height: 200px;">
                                        <p></p>
                                    </div>
                                    <input type="hidden" name="question_text" id="question_text">
                                </div>
                                <div class="mb">
                                    <label for="name" class=" form-label required"> Bobot</label>
                                    <input type="number" class="form-control" id="question_score" name="question_score"
                                        value="1" required step="0.01" min="0">
                                </div>
                                <div class="separator my-10"></div>

                                <div>
                                    <label for="name" class=" form-label">Pilihan ganda</label>

                                    <!--begin::Repeater-->
                                    <div id="kt_docs_repeater_basic">
                                        <!--begin::Form group-->
                                        <div class="form-group">
                                            <div data-repeater-list="choices">
                                                <div data-repeater-item>
                                                    <div class="form-group row mb-5">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Gambar:</label>
                                                            <input type="file" class="form-control mb-2 mb-md-0"
                                                                name="choice_image" accept="image/*" />
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="form-label">Text:</label>
                                                            <textarea class="form-control mb-2 mb-md-0 choice-text-editor" rows="1" name="choice_text" placeholder="text"></textarea>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div
                                                                class="form-check form-check-custom form-check-solid mt-2 mt-md-11">
                                                                <input class="form-check-input is_correct_radio"
                                                                    type="radio" name="is_correct" value="0"
                                                                    required />
                                                                <label class="form-check-label" for="form_radio">
                                                                    Jawaban Benar
                                                                </label>
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
                                <a href="{{ route('dosen.kelas.show', $kode_kelas) }}"
                                    class="btn btn-light">Batal</a>
                                <button type="submit" class="btn btn-primary">Tambah</button>
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
    <script src="https://cdn.jsdelivr.net/npm/@wiris/mathtype-ckeditor5/build/mathtype.min.js"></script>


    <script>
        var quill = new Quill('#question_text_quill', {
            modules: {
                formula: true,
                toolbar: [
                    [{
                        header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline', 'formula'],

                    [{
                        'script': 'sub'
                    }, {
                        'script': 'super'
                    }],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                    ['image'],
                    ['clean']
                ]
            },
            placeholder: 'Type your text here...',
            theme: 'snow' // or 'bubble'
        });

        $('#question_text').val(quill.root.innerHTML);
        quill.on('text-change', function() {
            $('#question_text').val(quill.root.innerHTML);
        });
    </script>
    <script>

        $('#kt_docs_repeater_basic').repeater({
            initEmpty: false,

            defaultValues: {
                'choice_text': 'text',
            },

            show: function() {
                $(this).slideDown();
                updateRadioValues();
                initCKEditor();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        function updateRadioValues() {
            var questionName = 'is_correct'; // All radio buttons will have this name

            $('#kt_docs_repeater_basic').find('[data-repeater-item]').each(function(index, item) {
                $(item).find('input[type="radio"]').attr('name', questionName).val(index);
            });
        }

        updateRadioValues();
        initCKEditor();
    </script>
@endsection
