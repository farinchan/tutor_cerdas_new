@extends('app')

@section('styles')

@endsection

@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Row-->
        <div class="row g-5 g-lg-10">
            <!--begin::Col-->
            <div class="col-xl-4 mb-xl-10">
                @include('partials/widgets-2/mixed/_widget-19')
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xl-4">
                <!--begin::Row-->
                <div class="row g-5 g-lg-10">
                    <!--begin::Col-->
                    <div class="col-lg-6 mb-lg-10">
                        <!--begin::Tiles Widget 5-->
                        <a href="#" class="card bg-danger h-150px">
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column justify-content-between">
                                <i class="ki-duotone ki-element-11 text-white fs-2hx ms-n1 flex-grow-1"><span
                                        class="path1"></span><span class="path2"></span><span class="path3"></span><span
                                        class="path4"></span></i>
                                <div class="d-flex flex-column">
                                    <div class="text-white fw-bold fs-1 mb-0 mt-5">
                                        3,900 </div>
                                    <div class="text-white fw-semibold fs-6">
                                        Author Sales </div>
                                </div>
                            </div>
                            <!--end::Body-->
                        </a>
                        <!--end::Tiles Widget 5-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-lg-6 mb-5 mb-lg-10">
                        @include('partials/widgets-2/statistics/_widget-7')
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row g-5 g-lg-10">
                    <!--begin::Col-->
                    <div class="col-lg-6 mb-lg-10">
                        @include('partials/widgets-2/tiles/_widget-1')
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-lg-6 mb-5 mb-lg-10">
                        @include('partials/widgets-2/tiles/_widget-5')
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
                @include('partials/widgets-2/engage/_widget-4')
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xl-4 mb-xl-10">
                @include('partials/widgets-2/engage/_widget-3')
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row g-5 g-lg-10">
            <!--begin::Col-->
            <div class="col-xl-4 mb-xl-10">
                <!--begin::Image placeholder-->
                <style>
                    .statistics-widget-1 {
                        background-image: url('assets/media/svg/shapes/abstract-4.svg');
                        background-size: 30% auto;
                    }

                    [data-bs-theme="dark"] .statistics-widget-1 {
                        background-image: url('assets/media/svg/shapes/abstract-4-dark.svg');
                        background-size: 30% auto;
                    }
                </style>
                <!--end::Image placeholder-->
                <!--begin::Statistics Widget 1-->
                <div class="card bgi-no-repeat bgi-position-y-top bgi-position-x-end statistics-widget-1 h-xl-100">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4">Meeting
                            Schedule</a>
                        <div class="fw-bold text-primary my-6">3:30PM - 4:20PM</div>
                        <p class="text-gray-900-75 fw-semibold fs-5 m-0">
                            Create a headline that is informative<br />
                            and will capture readers
                        </p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Statistics Widget 1-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xl-4 mb-xl-10">
                <!--begin::Image placeholder-->
                <style>
                    .statistics-widget-2 {
                        background-image: url('assets/media/svg/shapes/abstract-2.svg');
                        background-size: 30% auto;
                    }

                    [data-bs-theme="dark"] .statistics-widget-2 {
                        background-image: url('assets/media/svg/shapes/abstract-2-dark.svg');
                        background-size: 30% auto;
                    }
                </style>
                <!--end::Image placeholder-->
                <!--begin::Statistics Widget 1-->
                <div class="card bgi-no-repeat bgi-position-y-top bgi-position-x-end statistics-widget-2 h-xl-100">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title fw-bold text-muted text-hover-primary fs-4">Meeting
                            Schedule</a>
                        <div class="fw-bold text-primary my-6">03 May 2020</div>
                        <p class="text-gray-900-75 fw-semibold fs-5 m-0">
                            Great blog posts don’t just happen
                            Even the best bloggers need it
                        </p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Statistics Widget 1-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xl-4 mb-5 mb-lg-10">
                @include('partials/widgets-2/statistics/_widget-1')
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row g-5 g-lg-10">
            <!--begin::Col-->
            <div class="col-xxl-4 col-md-4 mb-5 mb-lg-10">
                @include('partials/widgets-2/lists/_widget-5')
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xxl-4 col-md-4 mb-5 mb-lg-10">
                @include('partials/widgets-2/mixed/_widget-6')
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xxl-4 col-md-4 mb-5 mb-lg-10">
                @include('partials/widgets-2/mixed/_widget-1')
            </div>
            <!--end::Col-->
        </div>
        <!--begin::Row-->
        <div class="row g-5 g-lg-10">
            <!--begin::Col-->
            <div class="col-xl-6 mb-xl-10">
                @include('partials/widgets-2/tables/_widget-3')
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xl-6 mb-5 mb-lg-10">
                @include('partials/widgets-2/tables/_widget-6')
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        @include('partials/widgets-2/calendar/_widget-1')
    </div>
@endsection

@section('scripts')

@endsection

