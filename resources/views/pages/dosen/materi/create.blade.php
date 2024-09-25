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
        <form id="kt_ecommerce_add_category_form" class="form d-flex flex-column flex-lg-row" enctype="multipart/form-data">
            <div class="d-flex flex-column gap-7 gap-lg-10 w-150 w-lg-350px mb-7 me-lg-10">
                <div class="card card-flush mb-3">
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
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Status</h2>
                        </div>
                        <div class="card-toolbar">
                            <div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_category_status">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <select class="form-select mb-2" data-control="select2" data-hide-search="true" name="status" required>
                            <option value="published" selected="selected">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                        <div class="text-muted fs-7">
                            set status dari materi yang akan dibuat.
                        </div>
                        
                    </div>
                </div> 	

            </div>
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Informasi Materi</h2>
                        </div>
                    </div>
                    <input type="hidden" name="kode_kelas" value="{{ $kode_kelas }}">
                    <div class="card-body pt-0">
                        <div class="mb-10 fv-row">
                            <label class="required form-label">Judul</label>
                            <input type="text" name="judul" class="form-control mb-2" placeholder="Judul Materi"
                                value="{{ old('judul') }}" required />
                        </div>
                        <div>
                            <label class="required form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control mb-2" placeholder="Deskripsi Materi" required rows="5">{{ old('deskripsi') }}</textarea>
                            <div class="text-muted fs-7">
                                Deskripsi materi digunakan untuk memberikan informasi singkat tentang materi yang akan
                                dibuat.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Materi</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">

                        <div class="mb-10">
                            <label class="form-label">Isi Materi</label>
                            <div id="quill_isi_materi" class="min-h-400px mb-2">
                                {!! old('isi_materi') !!}
                            </div>
                            <input type="hidden" name="isi_materi" id="isi_materi">
                            <div class="text-muted fs-7">
                                Isi materi digunakan untuk memberikan informasi lengkap tentang materi yang akan dibuat.
                            </div>
                        </div>
                        <div class="mb-10">
                            <label class="form-label">Materi File</label>
                            <div class="fv-row">
                                <div class="dropzone" id="materi_file">
                                    <div class="dz-message needsclick">
                                        <i class="ki-duotone ki-file-up fs-3x text-primary"><span
                                                class="path1"></span><span class="path2"></span></i>
                                        <div class="ms-4">
                                            <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop file disini atau klik untuk
                                                upload</h3>
                                            <span class="fs-7 fw-semibold text-gray-500">Upload hingga 10 file |
                                                <span class="text-danger">
                                                    Harus menyertakan minimal 1 file berformat PDF

                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="apps/ecommerce/catalog/products.html" id="kt_ecommerce_add_product_cancel"
                        class="btn btn-light me-5">Cancel</a>
                    <button type="submit" id="submit" class="btn btn-primary">
                        <span class="indicator-label">Simpan Perubahan</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        var quill = new Quill('#quill_isi_materi', {
            modules: {
                toolbar: [

                    ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video', 'formula'],

                    [{
                        header: [1, 2, 3, 4, 5, 6, false]
                    }], // custom button values
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }, {
                        'list': 'check'
                    }],
                    [{
                        'script': 'sub'
                    }, {
                        'script': 'super'
                    }], // superscript/subscript
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }], // outdent/indent
                    [{
                        'direction': 'rtl'
                    }], // text direction

                    [{
                        'color': []
                    }, {
                        'background': []
                    }], // dropdown with defaults from theme
                    [{
                        'font': []
                    }],
                    [{
                        'align': []
                    }],
                    ['clean'] // remove formatting button
                ]
            },
            placeholder: 'Ketikkan Materi Disini...',
            theme: 'snow' // or 'bubble'
        });
        $('#isi_materi').val(quill.root.innerHTML);
        quill.on('text-change', function() {
            $('#isi_materi').val(quill.root.innerHTML);
        });
    </script>

    <script>
        var myDropzone = new Dropzone("#materi_file", {
            url: "{{ route('dosen.materi.store') }}",
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            autoProcessQueue: false,
            acceptedFiles: "application/pdf",
            parallelUploads: 10,
            uploadMultiple: true,
            enctype: "multipart/form-data",
            method: "POST",
            params: {
                _token: "{{ csrf_token() }}",
            },
            accept: function(file, done) {
                done();
            },
            init: function() {
                var submitButton = document.querySelector("#submit");

                submitButton.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });

                this.on("sending", function(file, xhr, formData) {
                    var kode_kelas = document.querySelector('input[name="kode_kelas"]').value;
                    var judul = document.querySelector('input[name="judul"]').value;
                    var deskripsi = document.querySelector('textarea[name="deskripsi"]').value;
                    var isi_materi = document.querySelector('input[name="isi_materi"]').value;
                    var status = document.querySelector('select[name="status"]').value;
                    formData.append("kode_kelas", kode_kelas);
                    formData.append("judul", judul);
                    formData.append("deskripsi", deskripsi);
                    formData.append("isi_materi", isi_materi);
                    formData.append("status", status);
                });

                this.on("success", function(file, response) {
                    // window.location.href = response.redirect;
                    console.log(response);
                    Swal.fire({
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function() {
                        window.location.href = response.redirect;
                    });
                });

                this.on("error", function(file, response) {
                    // alert(response);
                    console.log(response);
                    Swal.fire({
                        text: response.message,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                });
            }
        });
    </script>
@endsection
