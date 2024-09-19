<!--begin::Menu wrapper-->
<div class="header-menu  container-xxl  flex-column align-items-stretch flex-lg-row" data-kt-drawer="true"
    data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend"
    data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
    <!--begin::Menu-->
    <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold my-5 my-lg-0 align-items-stretch flex-grow-1 px-2 px-lg-0"
        id="#kt_header_menu" data-kt-menu="true">

        <div class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2 @if (request()->routeIs('home')) here @endif">
            <a class="menu-link py-3" href="{{ route('home') }}">
                <span class="menu-title">
                    Home
                </span>
                <span class="menu-arrow d-lg-none"></span>
            </a>
        </div>

        <div class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2 @if (request()->routeIs('mahasiswa.*')) here @endif">
            <a class="menu-link py-3" href="{{ route('mahasiswa.kelas.index') }}">
                <span class="menu-title">
                    Kelas
                </span>
                <span class="menu-arrow d-lg-none"></span>
            </a>
        </div>

        <div class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2 @if (request()->routeIs('dosen.*')) here @endif">
            <a class="menu-link py-3" href="{{ route('dosen.kelas.index') }}">
                <span class="menu-title">
                    Mengajar
                </span>
                <span class="menu-arrow d-lg-none"></span>
            </a>
        </div>

        <div class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
            <span class="menu-link py-3">
                <span class="menu-title">
                    Administrator
                </span>
                <span class="menu-arrow d-lg-none"></span>
            </span>
        </div>
        <div class="menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
            <span class="menu-link py-3">
                <span class="menu-title">
                    Profil Saya
                </span>
                <span class="menu-arrow d-lg-none"></span>
            </span>
        </div>

    </div>
    <!--end::Menu-->
    <!--begin::Actions-->
    <div class="d-flex align-items-stretch flex-shrink-0 p-4 p-lg-0" id="kt_header_search_wrapper">
        @include('partials/search/_inline')
    </div>
    <!--end::Actions-->
</div>
<!--end::Menu wrapper-->
