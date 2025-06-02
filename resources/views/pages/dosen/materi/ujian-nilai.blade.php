@extends('app')
@section('styles')
    <style>
        img {
            max-width: 100%;
        }
    </style>
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
        @include('pages.dosen.materi.partials.content')
        <div class="row g-5 g-xxl-8">
            <div class="d-flex flex-column flex-lg-row">

                <div class="flex-lg-row-fluid ">
                    <div class="card ">
                        <div class="card-header card-header-stretch">
                            <h3 class="card-title">Nilai Ujian Materi</h3>
                            <div class="card-toolbar">
                                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_7">Mahasiswa</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_8">Umum</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="kt_tab_pane_7" role="tabpanel">
                            @forelse ($exam_mahasiswa as $list)
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <div class="py-0" data-kt-customer-payment-method="row">
                                            <div class="py-3 d-flex flex-stack flex-wrap">
                                                <div class="d-flex align-items-center collapsible collapsed rotate"
                                                    data-bs-toggle="collapse"
                                                    href="#kt_customer_view_payment_method_{{ $list->id }}"
                                                    role="button" aria-expanded="false"
                                                    aria-controls="kt_customer_view_payment_method_{{ $list->id }}">
                                                    <div class="me-3 rotate-90">
                                                        <i class="ki-outline ki-right fs-3"></i>
                                                    </div>
                                                    <img src="{{ $list->getPhoto() }}" class="w-40px me-3" alt="" />
                                                    <div class="me-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="text-gray-800 fw-bold">{{ $list->name }}</div>
                                                        </div>
                                                        <div class="text-muted">NIM. {{ $list->mahasiswa->nim }}</div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div id="kt_customer_view_payment_method_{{ $list->id }}"
                                                class="collapse fs-6 ps-10"
                                                data-bs-parent="#kt_customer_view_payment_method">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr class="fw-bold fs-6 text-gray-800">
                                                                <th>Tanggal</th>
                                                                <th>Nilai</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($list->examSessions as $session)
                                                                <tr>
                                                                    <td>{{ \Carbon\Carbon::parse($session->updated_at)->format('d M Y H:i') }}
                                                                    </td>
                                                                    <td>
                                                                        @if ($session->score >= $session->exam->minimum_score)
                                                                            <span
                                                                                class="text-success">{{ $session->score }}</span>
                                                                        @else
                                                                            <span
                                                                                class="text-danger">{{ $session->score }}</span>
                                                                        @endif

                                                                    </td>
                                                                    <td>
                                                                        @if ($session->endtime)
                                                                            @if ($session->status == 'lulus')
                                                                                <span
                                                                                    class="badge badge-light-success">Lulus</span>
                                                                            @else
                                                                                <span class="badge badge-light-danger">Tidak
                                                                                    Lulus</span>
                                                                            @endif
                                                                        @else
                                                                            <span class="badge badge-light-warning">Sedang
                                                                                berlangsung</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @empty
                                <div class="card">

                                </div>
                            @endforelse


                        </div>

                        <div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">
                            ...
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
