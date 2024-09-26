<!--begin::Toolbar wrapper-->
<div class="topbar d-flex align-items-stretch flex-shrink-0" id="kt_topbar">
    <!--begin::Activities-->
    {{-- <div class="d-flex align-items-center ms-2 ms-lg-4">
        <!--begin::Drawer toggle-->
        <div class="btn btn-icon btn-custom w-30px h-30px w-lg-40px h-lg-40px btn-color-warning"
            id="kt_activities_toggle">
            <i class="ki-duotone ki-chart-line fs-1"><span class="path1"></span><span class="path2"></span></i>
        </div>
        <!--end::Drawer toggle-->
    </div> --}}
    <!--end::Activities-->
    <!--begin::Chat-->
    {{-- <div class="d-flex align-items-center ms-2 ms-lg-4">
        <!--begin::Menu wrapper-->
        <div class="btn btn-icon btn-custom w-30px h-30px w-lg-40px h-lg-40px btn-color-success position-relative"
            id="kt_drawer_chat_toggle">
            <i class="ki-duotone ki-message-text fs-1"><span class="path1"></span><span class="path2"></span><span
                    class="path3"></span></i>
            <span
                class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle ms-7 mb-3 animation-blink">
            </span>
        </div>
        <!--end::Menu wrapper-->
    </div> --}}
    <!--end::Chat-->
    <!--begin::Quick links-->
    {{-- <div class="d-flex align-items-center ms-2 ms-lg-4">
        <!--begin::Menu wrapper-->
        <div class="btn btn-icon btn-custom w-30px h-30px w-lg-40px h-lg-40px btn-color-primary"
            data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <i class="ki-duotone ki-category fs-1"><span class="path1"></span><span class="path2"></span><span
                    class="path3"></span><span class="path4"></span></i>
        </div>
        @include('partials/menus/_menu-2')
        <!--end::Menu wrapper-->
    </div> --}}
    <!--end::Quick links-->
    <!--begin::User menu-->
    <div class="d-flex align-items-center ms-2 ms-lg-4" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="cursor-pointer symbol symbol-30px symbol-lg-40px"
            data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom-end">
            <img class="symbol symbol-30px symbol-lg-40px" src="{{ Auth::user()?->getPhoto() }}" alt="user" />
        </div>
        @include('partials/menus/_user-account-menu')
        <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->
    <!--begin::Invite-->
    <div class="d-flex align-items-center ms-2 ms-lg-4">
        <a href="#"
            class="btn btn-flex flex-center btn-primary align-self-center px-0 px-md-3 h-30px w-30px w-md-auto h-lg-40px ms-2 ms-lg-4"
            data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
            <i class="ki-duotone ki-plus-square fs-2 p-0 m-0"><span class="path1"></span><span
                    class="path2"></span><span class="path3"></span></i> <span
                class="d-none d-md-inline ms-2">Join Kelas</span>
        </a>
    </div>
    <!--end::Invite-->
    <!--begin::Heaeder menu toggle-->
    <!--end::Heaeder menu toggle-->
</div>
<!--end::Toolbar wrapper-->
