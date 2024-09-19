<!--begin::Mixed Widget 6-->
<div class="card h-md-100">
    <!--begin::Beader-->
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bold fs-3 mb-1">Sales Statistics</span>
			<span class="text-muted fw-semibold fs-7">Recent sales statistics</span>
		</h3>
        <div class="card-toolbar">
            <!--begin::Menu-->
            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <i class="ki-duotone ki-category fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>            </button>
@include("partials/menus/_menu-1")
            <!--end::Menu-->
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body p-0 d-flex flex-column">
        <!--begin::Stats-->
        <div class="card-px pt-5 pb-10 flex-grow-1">
            <!--begin::Row-->
            <div class="row g-0 mt-5 mb-10">
                <!--begin::Col-->
                <div class="col">
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-3">
                            <div class="symbol-label bg-light-info">
                                <i class="ki-duotone ki-bucket fs-1 text-info"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>                            </div>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Title-->
                        <div>
                            <div class="fs-4 text-gray-900 fw-bold">$2,034</div>
                            <div class="fs-7 text-muted fw-bold">Author Sales</div>
                        </div>
                        <!--end::Title-->
                    </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col">
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-3">
                            <div class="symbol-label bg-light-danger">
                                <i class="ki-duotone ki-abstract-26 fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>                            </div>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Title-->
                        <div>
                            <div class="fs-4 text-gray-900 fw-bold">$706</div>
                            <div class="fs-7 text-muted fw-bold">Commision</div>
                        </div>
                        <!--end::Title-->
                    </div>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row g-0">
                <!--begin::Col-->
                <div class="col">
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-3">
                            <div class="symbol-label bg-light-success">
                                <i class="ki-duotone ki-basket fs-1 text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>                            </div>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Title-->
                        <div>
                            <div class="fs-4 text-gray-900 fw-bold">$49</div>
                            <div class="fs-7 text-muted fw-bold">Average Bid</div>
                        </div>
                        <!--end::Title-->
                    </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col">
                    <div class="d-flex align-items-center me-2">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-3">
                            <div class="symbol-label bg-light-primary">
                                <i class="ki-duotone ki-barcode fs-1 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></i>                            </div>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Title-->
                        <div>
                            <div class="fs-4 text-gray-900 fw-bold">$5.8M</div>
                            <div class="fs-7 text-muted fw-bold">All Time Sales</div>
                        </div>
                        <!--end::Title-->
                    </div>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Stats-->
        <!--begin::Chart-->
        <div class="mixed-widget-6-chart card-rounded-bottom" data-kt-chart-color="danger" style="height: 150px"></div>
        <!--end::Chart-->
    </div>
    <!--end::Body-->
</div>
<!--end::Mixed Widget 6-->