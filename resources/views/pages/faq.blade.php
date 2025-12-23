@extends('app')

@section('styles')
@endsection

@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <div class="card mt-5">
            <div class="card-body p-lg-15">
            {{-- Header Section --}}
            <div class="mb-13">
                <div class="mb-15 text-center">
                    <h4 class="fs-2x text-gray-800 w-bolder mb-6">{{ __('faq.title') }}</h4>
                    <p class="fw-semibold fs-4 text-gray-600 mb-2">
                        {{ __('faq.subtitle') }}
                    </p>
                </div>

                {{-- Tab Navigation --}}
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-10 fs-5 justify-content-center" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active fw-bold" data-bs-toggle="tab" href="#kt_tab_faq" role="tab">
                            <i class="ki-duotone ki-message-question fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            FAQ
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link fw-bold" data-bs-toggle="tab" href="#kt_tab_guide" role="tab">
                            <i class="ki-duotone ki-book fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                            {{ __('guide.title') }}
                        </a>
                    </li>
                </ul>

                {{-- Tab Content --}}
                <div class="tab-content">
                    {{-- FAQ Tab --}}
                    <div class="tab-pane fade show active" id="kt_tab_faq" role="tabpanel">
                        {{-- FAQ Content --}}
                        <div class="row">
                            <div class="col-12">
                                {{-- General Questions --}}
                                <div class="mb-15" id="general">
                                    <h3 class="text-gray-800 w-bolder mb-4">
                                        <i class="ki-duotone ki-question-2 fs-2 me-2 text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        {{ __('faq.general_title') }}
                                    </h3>

                                    @foreach([1, 2, 3, 4] as $num)
                                    <div class="m-0">
                                        <div class="d-flex align-items-center collapsible py-3 toggle {{ $num == 1 ? '' : 'collapsed' }} mb-0"
                                            data-bs-toggle="collapse" data-bs-target="#kt_faq_general_{{ $num }}">
                                            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                                <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <i class="ki-duotone ki-plus-square toggle-off fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </div>
                                            <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">{{ __('faq.q'.$num) }}</h4>
                                        </div>
                                        <div id="kt_faq_general_{{ $num }}" class="collapse {{ $num == 1 ? 'show' : '' }} fs-6 ms-1">
                                            <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">{{ __('faq.a'.$num) }}</div>
                                        </div>
                                        <div class="separator separator-dashed"></div>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- Student Questions --}}
                                <div class="mb-15" id="student">
                                    <h3 class="text-gray-800 w-bolder mb-4">
                                        <i class="ki-duotone ki-people fs-2 me-2 text-success">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                        {{ __('faq.student_title') }}
                                    </h3>

                                    @foreach([5, 6, 7, 8] as $num)
                                    <div class="m-0">
                                        <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0"
                                            data-bs-toggle="collapse" data-bs-target="#kt_faq_student_{{ $num }}">
                                            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                                <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <i class="ki-duotone ki-plus-square toggle-off fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </div>
                                            <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">{{ __('faq.q'.$num) }}</h4>
                                        </div>
                                        <div id="kt_faq_student_{{ $num }}" class="collapse fs-6 ms-1">
                                            <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">{{ __('faq.a'.$num) }}</div>
                                        </div>
                                        <div class="separator separator-dashed"></div>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- Lecturer Questions --}}
                                <div class="mb-15" id="lecturer">
                                    <h3 class="text-gray-800 w-bolder mb-4">
                                        <i class="ki-duotone ki-teacher fs-2 me-2 text-info">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        {{ __('faq.lecturer_title') }}
                                    </h3>

                                    @foreach([9, 10, 11, 12] as $num)
                                    <div class="m-0">
                                        <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0"
                                            data-bs-toggle="collapse" data-bs-target="#kt_faq_lecturer_{{ $num }}">
                                            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                                <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <i class="ki-duotone ki-plus-square toggle-off fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </div>
                                            <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">{{ __('faq.q'.$num) }}</h4>
                                        </div>
                                        <div id="kt_faq_lecturer_{{ $num }}" class="collapse fs-6 ms-1">
                                            <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">{{ __('faq.a'.$num) }}</div>
                                        </div>
                                        <div class="separator separator-dashed"></div>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- Technical Support --}}
                                <div class="mb-0" id="support">
                                    <h3 class="text-gray-800 w-bolder mb-4">
                                        <i class="ki-duotone ki-setting-2 fs-2 me-2 text-warning">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        {{ __('faq.support_title') }}
                                    </h3>

                                    @foreach([13, 14, 15] as $num)
                                    <div class="m-0">
                                        <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0"
                                            data-bs-toggle="collapse" data-bs-target="#kt_faq_support_{{ $num }}">
                                            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                                                <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <i class="ki-duotone ki-plus-square toggle-off fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </div>
                                            <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">{{ __('faq.q'.$num) }}</h4>
                                        </div>
                                        <div id="kt_faq_support_{{ $num }}" class="collapse fs-6 ms-1">
                                            <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">{{ __('faq.a'.$num) }}</div>
                                        </div>
                                        <div class="separator separator-dashed"></div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Guide Tab --}}
                    <div class="tab-pane fade" id="kt_tab_guide" role="tabpanel">
                        {{-- Download PDF Section --}}
                        <div class="mb-15">
                            <h3 class="text-gray-800 fw-bolder mb-8 text-center">
                                <i class="ki-duotone ki-document fs-2x me-2 text-danger">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ __('guide.download_guide_title') }}
                            </h3>
                            <p class="text-gray-600 fs-5 text-center mb-10">{{ __('guide.download_guide_desc') }}</p>

                            <div class="row g-10 justify-content-center">
                                {{-- Dosen & Admin PDF --}}
                                <div class="col-md-5">
                                    <div class="card card-flush h-100 border border-info border-hover shadow-sm">
                                        <div class="card-body text-center py-10">
                                            <div class="symbol symbol-100px mb-7">
                                                <div class="symbol-label bg-light-info">
                                                    <i class="ki-duotone ki-teacher fs-3x text-info">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            </div>
                                            <h3 class="mb-3">{{ __('guide.pdf_lecturer_title') }}</h3>
                                            <p class="text-gray-600 mb-7 fs-6">{{ __('guide.pdf_lecturer_desc') }}</p>
                                            <a href="{{ asset('storage/guides/panduan-dosen-admin.pdf') }}" class="btn btn-info btn-lg" target="_blank" download>
                                                <i class="ki-duotone ki-file-down fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                {{ __('guide.download_pdf') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- Mahasiswa & Umum PDF --}}
                                <div class="col-md-5">
                                    <div class="card card-flush h-100 border border-success border-hover shadow-sm">
                                        <div class="card-body text-center py-10">
                                            <div class="symbol symbol-100px mb-7">
                                                <div class="symbol-label bg-light-success">
                                                    <i class="ki-duotone ki-people fs-3x text-success">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </div>
                                            </div>
                                            <h3 class="mb-3">{{ __('guide.pdf_student_title') }}</h3>
                                            <p class="text-gray-600 mb-7 fs-6">{{ __('guide.pdf_student_desc') }}</p>
                                            <a href="{{ asset('storage/guides/panduan-mahasiswa-umum.pdf') }}" class="btn btn-success btn-lg" target="_blank" download>
                                                <i class="ki-duotone ki-file-down fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                {{ __('guide.download_pdf') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-15"></div>

                        {{-- Getting Started --}}
                        <div class="mb-15">
                            <h3 class="text-gray-800 fw-bolder mb-8 text-center">
                                <i class="ki-duotone ki-rocket fs-2x me-2 text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ __('guide.getting_started_title') }}
                            </h3>
                            <p class="text-gray-600 fs-5 text-center mb-10">{{ __('guide.getting_started_desc') }}</p>

                            <div class="row g-10">
                                <div class="col-md-4">
                                    <div class="card card-flush h-100 bg-light-primary">
                                        <div class="card-body text-center pt-10">
                                            <div class="symbol symbol-80px mb-5">
                                                <div class="symbol-label bg-primary">
                                                    <i class="ki-duotone ki-user-edit fs-2x text-white">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            </div>
                                            <h4 class="mb-3">1. {{ __('guide.step1_title') }}</h4>
                                            <p class="text-gray-600 mb-0">{{ __('guide.step1_desc') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-flush h-100 bg-light-success">
                                        <div class="card-body text-center pt-10">
                                            <div class="symbol symbol-80px mb-5">
                                                <div class="symbol-label bg-success">
                                                    <i class="ki-duotone ki-key fs-2x text-white">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            </div>
                                            <h4 class="mb-3">2. {{ __('guide.step2_title') }}</h4>
                                            <p class="text-gray-600 mb-0">{{ __('guide.step2_desc') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-flush h-100 bg-light-info">
                                        <div class="card-body text-center pt-10">
                                            <div class="symbol symbol-80px mb-5">
                                                <div class="symbol-label bg-info">
                                                    <i class="ki-duotone ki-entrance-right fs-2x text-white">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            </div>
                                            <h4 class="mb-3">3. {{ __('guide.step3_title') }}</h4>
                                            <p class="text-gray-600 mb-0">{{ __('guide.step3_desc') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-15"></div>

                        {{-- Student & Lecturer Guide --}}
                        <div class="row g-10">
                            {{-- Student Guide --}}
                            <div class="col-lg-6">
                                <div class="card card-flush h-100">
                                    <div class="card-header pt-7">
                                        <h3 class="card-title">
                                            <i class="ki-duotone ki-people fs-2 me-2 text-success">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                            {{ __('guide.student_guide_title') }}
                                        </h3>
                                    </div>
                                    <div class="card-body pt-5">
                                        <div class="timeline">
                                            @foreach(['student_step1', 'student_step2', 'student_step3', 'student_step4', 'student_step5', 'student_step6', 'student_step7'] as $step)
                                            <div class="timeline-item">
                                                <div class="timeline-line w-40px"></div>
                                                <div class="timeline-icon symbol symbol-circle symbol-40px">
                                                    <div class="symbol-label bg-light-success">
                                                        <i class="ki-duotone ki-check fs-2 text-success"></i>
                                                    </div>
                                                </div>
                                                <div class="timeline-content mb-10 mt-n1">
                                                    <div class="pe-3">
                                                        <div class="fs-5 fw-bold mb-2">{{ __('guide.'.$step.'_title') }}</div>
                                                        <div class="text-gray-600 fs-6">{{ __('guide.'.$step.'_desc') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Lecturer Guide --}}
                            <div class="col-lg-6">
                                <div class="card card-flush h-100">
                                    <div class="card-header pt-7">
                                        <h3 class="card-title">
                                            <i class="ki-duotone ki-teacher fs-2 me-2 text-info">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            {{ __('guide.lecturer_guide_title') }}
                                        </h3>
                                    </div>
                                    <div class="card-body pt-5">
                                        <div class="timeline">
                                            @foreach(['lecturer_step1', 'lecturer_step2', 'lecturer_step3', 'lecturer_step4', 'lecturer_step5', 'lecturer_step6'] as $step)
                                            <div class="timeline-item">
                                                <div class="timeline-line w-40px"></div>
                                                <div class="timeline-icon symbol symbol-circle symbol-40px">
                                                    <div class="symbol-label bg-light-info">
                                                        <i class="ki-duotone ki-check fs-2 text-info"></i>
                                                    </div>
                                                </div>
                                                <div class="timeline-content mb-10 mt-n1">
                                                    <div class="pe-3">
                                                        <div class="fs-5 fw-bold mb-2">{{ __('guide.'.$step.'_title') }}</div>
                                                        <div class="text-gray-600 fs-6">{{ __('guide.'.$step.'_desc') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-15"></div>

                        {{-- Tips Section --}}
                        {{-- <div class="mb-0">
                            <h3 class="text-gray-800 fw-bolder mb-8 text-center">
                                <i class="ki-duotone ki-abstract-26 fs-2x me-2 text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                {{ __('guide.tips_title') }}
                            </h3>

                            <div class="row g-5">
                                @foreach(['tip1', 'tip2', 'tip3', 'tip4'] as $index => $tip)
                                @php
                                    $colors = ['primary', 'success', 'info', 'warning'];
                                    $icons = ['profile-circle', 'notification-on', 'message-text-2', 'folder-down'];
                                @endphp
                                <div class="col-md-6 col-lg-3">
                                    <div class="card card-flush h-100 border border-{{ $colors[$index] }} border-dashed">
                                        <div class="card-body text-center">
                                            <div class="mb-5">
                                                <i class="ki-duotone ki-{{ $icons[$index] }} fs-3x text-{{ $colors[$index] }}">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </div>
                                            <h5 class="mb-3">{{ __('guide.'.$tip.'_title') }}</h5>
                                            <p class="text-gray-600 mb-0 fs-7">{{ __('guide.'.$tip.'_desc') }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

            {{-- Contact Card --}}
            <div class="card mb-4 bg-light text-center">
                <div class="card-body py-12">
                    <i class="ki-duotone ki-message-question fs-4x text-primary mb-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    <h3 class="text-gray-800 fw-bolder mb-3">{{ __('faq.contact_title') }}</h3>
                    <p class="text-gray-600 fs-5 mb-5">{{ __('faq.contact_desc') }}</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="ki-duotone ki-home fs-4 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        {{ __('home.get_started') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
