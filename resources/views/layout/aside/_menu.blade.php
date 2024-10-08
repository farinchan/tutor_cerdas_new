<!--begin::Aside Menu-->
<div class="hover-scroll-overlay-y my-4 mx-2 mx-lg-3" id="kt_aside_menu_wrapper" data-kt-scroll="true"
    data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
    data-kt-scroll-dependencies="#kt_header, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu"
    data-kt-scroll-offset="{lg: '25px'}">
    <!--begin::Menu-->
    <div class="menu menu-column menu-rounded menu-sub-indention menu-active-bg menu-title-gray-800 menu-state-primary menu-arrow-gray-500"
        id="#kt_aside_menu" data-kt-menu="true">

        <div data-kt-menu-trigger="click"
            class="menu-item menu-accordion @if (request()->routeIs('admin.dashboard') || request()->routeIs('admin.dashboard.*')) here show @endif"><span
                class="menu-link"><span class="menu-icon"><i class="ki-duotone ki-element-11 fs-2"><span
                            class="path1"></span><span class="path2"></span><span class="path3"></span><span
                            class="path4"></span></i></span><span class="menu-title">Dashboards</span><span
                    class="menu-arrow"></span></span>
            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link @if (request()->routeIs('admin.dashboard')) active @endif"
                        href="{{ route('admin.dashboard') }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Default</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="menu-item pt-5">
            <div class="menu-content"><span class="menu-heading fw-bold text-uppercase fs-7">Tutor Cerdas</span>
            </div>
        </div>

        <div class="menu-item">
            <a class="menu-link @if (request()->routeIs('admin.matakuliah.*')) active @endif" href="{{ route('admin.matakuliah.index') }}">
                <span class="menu-icon">
                    <i class="ki-duotone ki-medal-star fs-2 ">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                    </i>
                </span>
                <span class="menu-title">Mata Kuliah</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link @if (request()->routeIs('admin.kelas.*')) active @endif" href="{{ route('admin.kelas.index') }}">
                <span class="menu-icon">
                    <i class="ki-duotone ki-abstract-24 fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </span>
                <span class="menu-title">Kelas</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link @if (request()->routeIs('admin.materi.*')) active @endif" href="{{ route('admin.materi.index') }}">
                <span class="menu-icon">
                    <i class="ki-duotone ki-book-open fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                    </i>
                </span>
                <span class="menu-title">Materi</span>
            </a>
        </div>

        <div class="menu-item">
            <a class="menu-link @if (request()->routeIs('admin.user.*')) active @endif" href="{{ route('admin.user.index') }}">
                <span class="menu-icon">
                    <i class="ki-duotone ki-profile-user fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                    </i>
                </span>
                <span class="menu-title">Pengguna</span>
            </a>
        </div>

        <div class="menu-item pt-5">
            <div class="menu-content"><span class="menu-heading fw-bold text-uppercase fs-7">Pengaturan</span>
            </div>
        </div>

        <div data-kt-menu-trigger="click"
            class="menu-item menu-accordion @if (request()->routeIs('admin.setting.*')) here show @endif">
            <span class="menu-link">
                <span class="menu-icon">
                    <i class="ki-duotone ki-setting-2 fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </span>
                <span class="menu-title">Pengaturan</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link @if (request()->routeIs('admin.setting.website')) active @endif" href="#">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Website</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link @if (request()->routeIs('admin.setting.banner')) active @endif" href="#">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Banner</span>
                    </a>
                </div>
            </div>
        </div>




    </div>
    <!--end::Menu-->
</div>
