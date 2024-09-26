@extends('app')
@section('styles')
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
        <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-md-6 mb-7">
                        <div class="card h-lg-100">
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">

                                <div class="d-flex flex-column my-7">
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $matakuliah_count }}</span>
                                    <div class="m-0">
                                        <span class="fw-semibold fs-6 text-gray-500">Mata Kuliah</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-7">
                        <div class="card h-lg-100">
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <div class="d-flex flex-column my-7">
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $kelas_count }}</span>
                                    <div class="m-0">
                                        <span class="fw-semibold fs-6 text-gray-500">Kelas</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-7">
                        <div class="card h-lg-100">
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <div class="d-flex flex-column my-7">
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $materi_count }}</span>
                                    <div class="m-0">
                                        <span class="fw-semibold fs-6 text-gray-500">Materi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-7">
                        <div class="card h-lg-100">
                            <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                <div class="d-flex flex-column my-7">
                                    <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">{{ $user_count }}</span>
                                    <div class="m-0">
                                        <span class="fw-semibold fs-6 text-gray-500">Pengguna</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card h-md-100" dir="ltr">
                    <div class="card-body d-flex flex-column flex-center">
                        <div class="mb-2">
                            <h1 class="fw-semibold text-gray-800 text-center lh-lg">
                                Halo Admin 👋<br>
                                <span class="fw-bolder">{{ Auth::user()->name }}</span>
                            </h1>
                            <div class="py-10 text-center">
                                <img src="{{ asset('assets/media/svg/illustrations/easy/1.svg') }}"
                                    class="theme-light-show w-200px" alt="">
                                <img src="/assets/media/svg/illustrations/easy/1-dark.svg" class="theme-dark-show w-200px"
                                    alt="">
                            </div>
                        </div>
                        <div class="text-center mb-1">
                            <p>
                                Selamat datang di halaman admin Tutor Cerdas <br>
                                Dashboard ini adalah tempat untuk melihat data dan statistik dari Tutor Cerdas
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5 gx-xl-10 mb-5 mb-xl-10">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100">
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-900">Statistik Pendaftar</span>
                        </h3>
                    </div>
                    <div class="card-body pt-0 px-0">
                        {{-- INI TEMPAT STAT NYA --}}
                        <div id="chart_1" class="px-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var chart_1 = new ApexCharts(document.querySelector("#chart_1"), {

            series: [{
                name: 'Pendafaftar',
                data: [10]
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'straight'
            },
            title: {
                text: 'Pendaftar',
                align: 'left'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'],
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ['x'],
            }
        });
        chart_1.render();

        $.ajax({
            url: "{{ route('admin.stat') }}",
            type: "GET",
            success: function(response) {
                console.log(response);

                chart_1.updateSeries([{
                    data: response.user_register.map(function(item) {
                        return item.total;
                    })
                }]);
                chart_1.updateOptions({
                    xaxis: {
                        categories: response.user_register.map(function(item) {
                            return item.date;
                        })
                    }
                });
            }
        });
    </script>
@endsection
