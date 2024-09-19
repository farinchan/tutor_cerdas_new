<!--begin::Header-->
<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header"
    data-kt-sticky-offset="{default: '200px', lg: '300px'}">
    <!--begin::Container-->
    <div class=" container-xxl  d-flex flex-grow-1 flex-stack">
        <!--begin::Header Logo-->
        <div class="d-flex align-items-center me-5">
            <!--begin::Heaeder menu toggle-->
            <div class="d-lg-none btn btn-icon btn-active-color-primary w-30px h-30px ms-n2 me-3"
                id="kt_header_menu_toggle">
                <i class="ki-duotone ki-abstract-14 fs-1"><span class="path1"></span><span class="path2"></span></i>
            </div>
            <!--end::Heaeder menu toggle-->
            <!--begin::Logo-->
            <a href="{{ route("home") }}">
                <img alt="Logo" src="{{ asset('assets/media/logos/demo16.svg') }}" class="h-25px h-lg-30px me-2 me-lg-9" />
            </a>
            <!--end::Logo-->
            {{-- @include("layout/header/__project") --}}
        </div>
        <!--end::Header Logo-->
        @include('layout/header/__topbar')
    </div>
    <!--end::Container-->
    <!--begin::Container-->
    <div class="header-menu-container d-flex align-items-stretch flex-stack h-lg-75px w-100" id="kt_header_nav">
        @include('layout/header/__menu')
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->
