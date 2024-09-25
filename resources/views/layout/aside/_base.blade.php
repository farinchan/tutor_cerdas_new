<!--begin::Aside-->
<div
	id="kt_aside"
	class="aside card"
	data-kt-drawer="true"
	data-kt-drawer-name="aside"
	data-kt-drawer-activate="{default: true, lg: false}"
	data-kt-drawer-overlay="true"
	data-kt-drawer-width="{default:'200px', '300px': '250px'}"
	data-kt-drawer-direction="start"
	data-kt-drawer-toggle="#kt_aside_toggle"
            data-kt-sticky="true"
        data-kt-sticky-name="aside-sticky"
        data-kt-sticky-offset="{default: false, lg: '200px'}"
        data-kt-sticky-width="{lg: '265px'}"
        data-kt-sticky-left="auto"
        data-kt-sticky-top="95px"
        data-kt-sticky-animation="false"
        data-kt-sticky-zindex="95"
    	>
    <!--begin::Aside menu-->
	<div class="aside-menu flex-column-fluid">
@include("layout/aside/_menu")
    </div>
    <!--end::Aside menu-->
    <!--begin::Footer-->
    <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
        <a href="https://preview.keenthemes.com/html/metronic/docs" class="btn btn-custom btn-primary w-100" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="200+ in-house components and 3rd-party plugins">
            <span class="btn-label">
                Docs & Components
            </span>
            <i class="ki-duotone ki-document btn-icon fs-2"><span class="path1"></span><span class="path2"></span></i>        </a>
    </div>
    <!--end::Footer-->
</div>
<!--end::Aside-->