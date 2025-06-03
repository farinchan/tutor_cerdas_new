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
        <div class="card mb-5 mb-xxl-8">
            <div class="card-body pt-9 pb-0">

                <div class="p-5">
                    <div class="d-flex flex-wrap flex-sm-nowrap align-items-center mb-4">
                        <div class="d-flex flex-column flex-grow-1">
                            <div class="d-flex flex-wrap me-2">
                                <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">
                                    {{ $materi->judul }}
                                </a>
                            </div>
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a href="#"
                                    class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-bank fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    {{ $materi->kelas?->nama_kelas }}
                                </a>
                                <a href="#"
                                    class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-user fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    {{ $materi->dosen?->user?->name }}
                                </a>
                            </div>
                            <span class="text-muted fs-6">
                                {{ $materi->deskripsi }}
                            </span>
                        </div>
                    </div>
                    <hr class=" mb-5">
                    {!! $materi->isi_materi !!}
                    @foreach ($materi->materiFiles as $file)
                        <Embed type="application/pdf" src="{{ asset('storage/' . $file->file) }}" width="600"
                            height="400"></Embed>
                    @endforeach
                    @if ($exam)
                        <div
                            class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6 mt-15">
                            <i class="ki-outline ki-pin fs-2tx text-primary me-4"></i>

                            <div class="d-flex flex-stack flex-grow-1 ">
                                <div class=" fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">{{ __('class.exam') }}</h4>
                                    <div class="fs-6 text-gray-700">
                                        {{-- @dd($exam->examSessions) --}}
                                        @if (!$exam->examSessions?->contains('status', 'lulus'))
                                            <span class="text-danger">
                                                {{ __('class.exam_not_passed') }}
                                            </span>
                                            <br>
                                        @endif

                                        {{ __('class.description') }} : {{ $materi->exam?->description ?? 'Belum ada ujian' }}
                                    </div>
                                    <div class="fs-6 text-gray-700">
                                        {{ __('class.duration') }} :
                                        {{ $materi->exam?->duration ?? 'Belum ada ujian' }}
                                    </div>
                                    <div class="fs-6 text-gray-700">
                                        {{ __('class.minimal_score') }} :
                                        {{ $materi->exam?->minimum_score ?? 'Belum ada ujian' }}
                                    </div>

                                    <a href="{{ route('umum.kelas.exam', [$kode_kelas, $materi_id]) }}"
                                        class="btn btn-light-success btn-active-light-primary btn-sm mt-3">{{ __('class.do_exam') }}</a>

                                </div>

                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row g-5 g-xxl-8">
            <div class="d-flex flex-column flex-lg-row">

                <div class="flex-lg-row-fluid ">
                    <div class="card" id="kt_chat_messenger">
                        <div class="card-header" id="">

                            <div class="card-title">
                                <div class="me-5">
                                    {{ __('class.exam_history') }}
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="kt_chat_messenger_body">
                            <div class="table-responsive">
                                <table id="kt_datatable_zero_configuration" class="table table-row-bordered gy-5 fs-4">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-muted">
                                            <th>{{ __('class.date_time') }}</th>
                                            <th>{{ __('class.score') }}</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @dd($exam) --}}
                                        @forelse ($exam?->examSessions ?? [] as $exam_session)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($exam_session->updated_at)->format('d M Y H:i') }}
                                                </td>
                                                <td>
                                                    @if ($exam_session->score >= $exam->minimum_score)
                                                        <span class="text-success">{{ $exam_session->score }}</span>
                                                    @else
                                                        <span class="text-danger">{{ $exam_session->score }}</span>
                                                    @endif

                                                </td>
                                                <td>
                                                        @if ($exam_session->status == 'lulus')
                                                            <span class="badge badge-light-success">{{ __('class.passed') }}</span>
                                                        @else
                                                            <span class="badge badge-light-danger">{{ __('class.not_passed') }}</span>
                                                        @endif
                                                </td>
                                            </tr>

                                        @empty
                                        @endforelse


                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $("#kt_datatable_zero_configuration").DataTable({
            "ordering": false
        });
    </script>
@endsection
