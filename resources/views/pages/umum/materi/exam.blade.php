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

        <div class="row">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Soal</h3>

                    </div>
                    <div class="card-body">
                        <div class="mb-0">
                            <div class="row g-5 justify-content-center mb-10" id="side_question">
                                @foreach ($question_list as $question_item)
                                    @if ($loop->iteration == 1)
                                        <div class="col-4">
                                            <button id="side_question_number"
                                                onclick="selectQuestion({{ $question_item->id }})"
                                                class="btn btn-icon btn-outline btn-light-primary btn-active-light-primary btn-flex flex-column flex-center w-65px h-65px border-gray-200">
                                                <span class="mb-2" style="font-size: 1.8rem;">{{ $loop->iteration }}
                                                </span>
                                            </button>
                                        </div>
                                    @else
                                        @if ($question_item->examAnswers)
                                            <div class="col-4">
                                                <button id="side_question_number"
                                                    onclick="selectQuestion({{ $question_item->id }})"
                                                    class="btn btn-icon btn-outline btn-light-success btn-active-light-primary btn-flex flex-column flex-center w-65px h-65px border-gray-200">
                                                    <span class="mb-2" style="font-size: 1.8rem;">{{ $loop->iteration }}
                                                    </span>
                                                </button>
                                            </div>
                                        @else
                                            <div class="col-4">
                                                <button id="side_question_number"
                                                    onclick="selectQuestion({{ $question_item->id }})"
                                                    class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-65px h-65px border-gray-200">
                                                    <span class="mb-2" style="font-size: 1.8rem;">{{ $loop->iteration }}
                                                    </span>
                                                </button>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-light-success fs-5 w-100 py-4" data-bs-toggle="modal"
                            data-bs-target="#end_exam">
                            Selesaikan Ujian
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card shadow-sm" style="width: 100%;">
                    <div class="card-header">
                        <h3 class="card-title">Soal</h3>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end">
                                <span class="fw-semibold fs-5 text-gray-800 me-5">Sisa Waktu:</span>
                                <span class="fw-semibold fs-5 text-danger" id="timer">00:00:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p id="question_text" class="fs-5 text-gray-800">
                            {{-- {!! $question->question !!} --}}
                        </p>
                        <div class="separator my-10"></div>
                        <div class="mb-5" id="question_choices">
                            @foreach ($question->examChoices as $choice)
                                {{-- @dd($question->examAnswers) --}}
                                <div class="d-flex fv-row">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input me-3" type="radio" name="choice"
                                            onclick="submitAnswer({{ $choice->id }})"
                                            @if ($question->examAnswers?->exam_choice_id == $choice->id) checked @endif>
                                        <label class="form-check-label">
                                            @if ($choice->choice_image)
                                                <img class="img-fluid" src="{{ $choice->getImage() }}" alt="">
                                            @endif
                                            <div class=" text-gray-800">{!! $choice->choice_text !!}</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-5"></div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end" id="question_footer">
                        @php
                            $question_last_id = end($random_exam);
                            // $random_exam = json_encode($random_exam);
                            $next_question = array_search($question->id, $random_exam) + 1;
                        @endphp
                        @if ($question->id == $question_last_id)
                            <button type="button" class="btn btn-light-success" data-bs-toggle="modal"
                                data-bs-target="#end_exam">Selesaikan Ujian {{ $question->id }} - {{ $question_last_id }}
                            </button>
                        @else
                            <button type="button" onclick="selectQuestion({{ $random_exam[$next_question] }})"
                                class="btn btn-light-primary">Selanjutnya</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="end_exam">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Selesaikan Ujian?</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form action="{{ route('umum.kelas.examSelesai', [$kode_kelas, $materi_id]) }}" id="end_exam_form"
                    method="POST">
                    @csrf

                    <input type="hidden" name="session_id" value="{{ $session_id }}">
                    <div class="modal-body">
                        <p>
                            <strong>Perhatian!</strong> Apakah kamu yakin ingin menyelesaikan ujian ini?, setelah kamu
                            menyelesaikan ujian ini, kamu tidak bisa kembali lagi.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Ya, Selesai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let question = @json($question);
        let question_list = @json($question_list);
        let session_id = @json($session_id);
        let random_exam = @json($random_exam);

        // console.log(question, question_list, session_id, random_exam);

        $('#question_text').html(question.question);


        function selectQuestion(question_id) {
            console.log('Selecting question:', question_id);
            $.ajax({
                url: '{{ route('umum.kelas.examSoal') }}',
                method: 'GET',
                data: {
                    session_id: session_id,
                    question_id: question_id,
                    random_exam: random_exam
                },
                success: function(data) {
                    console.log(data.question.exam_answers);

                    question_list = data.question_list;
                    question = data.question;
                    $('#question_text').html(data.question.question);

                    $('#question_choices').html('');
                    data.question.exam_choices.forEach(choice => {
                        $('#question_choices').append(`
                            <div class="d-flex fv-row">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input me-3" type="radio" name="choice" id=""
                                        onclick="submitAnswer(${choice.id})"
                                        ${data.question.exam_answers?.exam_choice_id == choice.id ? 'checked' : ''}>
                                    <label class="form-check-label">
                                        ${choice.choice_image ? `<img class="img-fluid" src="/storage/${choice.choice_image}" alt="">` : ''}
                                        <div class=" text-gray-800">${choice.choice_text}</div>
                                    </label>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                        `);
                    });

                    $('#side_question').html('');
                    question_list.forEach((question, index) => {
                        if (question_id == question.id) {
                            $('#side_question').append(`
                                <div class="col-4">
                                    <button id="side_question_number" onclick="selectQuestion(${question.id})"
                                        class="btn btn-icon btn-outline btn-light-primary btn-active-light-primary btn-flex flex-column flex-center w-65px h-65px border-gray-200">
                                        <span class="mb-2" style="font-size: 1.8rem;">${index + 1}
                                        </span>
                                    </button>
                                </div>
                            `);
                        } else {
                            if (question.exam_answers) {
                                $('#side_question').append(`
                                <div class="col-4">
                                    <button id="side_question_number" onclick="selectQuestion(${question.id})"
                                        class="btn btn-icon btn-outline btn-light-success btn-active-light-primary btn-flex flex-column flex-center w-65px h-65px border-gray-200">
                                        <span class="mb-2" style="font-size: 1.8rem;">${index + 1}
                                        </span>
                                    </button>
                                </div>
                            `);
                            } else {
                                $('#side_question').append(`
                                <div class="col-4">
                                    <button id="side_question_number" onclick="selectQuestion(${question.id})"
                                        class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-65px h-65px border-gray-200">
                                        <span class="mb-2" style="font-size: 1.8rem;">${index + 1}
                                        </span>
                                    </button>
                                </div>
                            `);
                            }
                        }
                    });

                    $('#question_footer').html('');
                    console.log(question_id, random_exam[random_exam.length - 1]);
                    if (question_id == random_exam[random_exam.length - 1]) {
                        $('#question_footer').append(`
                            <button type="button" class="btn btn-light-success" data-bs-toggle="modal"
                                data-bs-target="#end_exam">Selesaikan Ujian</button>
                        `);
                    } else {
                        $('#question_footer').append(`
                            <button type="button" onclick="selectQuestion(${random_exam[random_exam.indexOf(question_id) + 1]})"
                            class="btn btn-light-primary">Selanjutnya</button>
                        `);
                    }



                },
                error: function(error) {
                    console.error('Error fetching questions:', error);
                    toastr.error('Gagal mengambil soal');
                }
            });
        }





        function submitAnswer(choice_id) {
            $.ajax({
                url: '{{ route('umum.kelas.examJawab') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    choice_id: choice_id,
                    session_id: session_id,
                    question_id: question.id
                },
                success: function(data) {
                    console.log(data);
                    toastr.success('Jawaban berhasil disimpan');
                },
                error: function(error) {
                    console.error('Error submitting answer:', error);
                    toastr.error('Gagal menyimpan jawaban');
                }
            });
        }

        let start_time = @json($session->start_time ?? now());

        // Durasi dalam menit diambil dari exam.durasi
        var durationInMinutes = @json($exam->duration);

        // Waktu mulai diambil dari exam_session.start_time
        var startTime = new Date(start_time).getTime();

        console.log(startTime);
        console.log(durationInMinutes);

        // Hitung waktu selesai berdasarkan startTime + durasi
        var countDownDate = new Date(startTime + durationInMinutes * 60 * 1000).getTime();

        var x = setInterval(function() {
            var now = new Date().getTime();

            var distance = countDownDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("timer").innerHTML = days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("timer").innerHTML = "EXPIRED";

                alert('Waktu pengerjaan ujian telah habis', 'warning', 5000);
                // @this.call('endExam');
                $('#end_exam_form').submit();
            }
        }, 1000);
    </script>
@endsection
