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
    @auth
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
        @role('mahasiswa')
            <div class="d-flex align-items-center ms-2 ms-lg-4">
                <a href="#"
                    class="btn btn-flex flex-center btn-primary align-self-center px-0 px-md-3 h-30px w-30px w-md-auto h-lg-40px ms-2 ms-lg-4"
                    data-bs-toggle="modal" data-bs-target="#join_kelas">
                    <i class="ki-duotone ki-plus-square fs-2 p-0 m-0">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    <span class="d-none d-md-inline ms-2">Join Kelas</span>
                </a>
            </div>
            <div class="modal fade" tabindex="-1" id="join_kelas">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">

                        <div class="card border-0 h-md-100" data-bs-theme="light" style="background-color: #1C325E;"> 
                            <div class="card-body"> 
                                <form action="{{ route('mahasiswa.kelas.join') }}" method="POST">
                                    @csrf
                                <div class="row align-items-center h-100">
                                    <div class="col-7 ps-xl-13">
                                        <div class="text-white mb-6 pt-6">
                                            <span class="fs-2qx fw-bold">Join Kelas</span>
                                        </div>
                                        <span class="fw-semibold text-white fs-6 mb-8 d-block opacity-75">
                                            Join kelas dengan memasukkan kode kelas yang diberikan oleh dosen
                                        </span>
                                        <div class="d-flex align-items-center flex-wrap d-grid gap-2 mb-10 mb-xl-20">
                                            <div class="d-flex align-items-center me-5 me-xl-13">
                                                <input type="text" class="form-control form-control-lg form-control-solid" placeholder="Masukkan Kode Kelas" name="kode_kelas" />
                                            </div>                       
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row d-grid gap-2">
                                            <button  type="submit" class="btn btn-success flex-shrink-0 me-lg-2" >join</button>
                                            <button type="button" data-bs-dismiss="modal" class="btn btn-primary flex-shrink-0" style="background: rgba(255, 255, 255, 0.2)" >Batal</button>
                                        </div>
                                    </div>
                                    <div class="col-5 pt-10">
                                        <div class="bgi-no-repeat bgi-size-contain bgi-position-x-end h-225px" style="background-image:url('{{ asset("assets/media/illustrations/sigma-1/17-dark.png") }}">                 
                                        </div>
                                    </div>
                                </form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endrole
    @else
        {{-- <a href="#" class="btn btn-secondary">
            <i class="ki-duotone ki-entrance-right fs-4 me-1">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
            Login
        </a> --}}
        <a href="{{ route('login') }}"
            class="btn btn-flex flex-center btn-primary align-self-center px-0 px-md-3 h-30px w-30px w-md-auto h-lg-40px ms-2 ms-lg-4">
            <i class="ki-duotone ki-entrance-right fs-2 p-0 m-0">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
            <span class="d-none d-md-inline ms-2">Masuk</span>
        </a>
        <a href="{{ route('register') }}"
            class="btn btn-flex flex-center btn-primary align-self-center px-0 px-md-3 h-30px w-30px w-md-auto h-lg-40px ms-2 ms-lg-4">
            <i class="ki-duotone ki-user-edit fs-2 p-0 m-0">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
            </i>
            <span class="d-none d-md-inline ms-2">Daftar</span>
        </a>
    @endauth
    <!--end::User menu-->
    <!--begin::Invite-->
    <!--end::Invite-->
    <!--begin::Heaeder menu toggle-->
    <!--end::Heaeder menu toggle-->
</div>
<!--end::Toolbar wrapper-->
