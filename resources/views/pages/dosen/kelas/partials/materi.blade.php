<div class="card card-flush mb-6 mb-xl-9">
    <div class="card-header mt-6">
        <div class="card-title flex-column">
            <h2 class="mb-1">
                Materi Pembelajaran
            </h2>
            <div class="fs-6 fw-semibold text-muted">
                Total Materi: {{ $kelas->materi->count() }}
            </div>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('dosen.materi.create', $kelas->kode_kelas) }}"
                class="btn btn-light-primary btn-sm">
                <i class="ki-duotone ki-plus fs-3"></i>
                Tambah Materi
            </a>
        </div>
    </div>
    <div class="card-body p-9 pt-4">
        @foreach ($kelas->materi as $materi)
            <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6 mb-5">
                <div class="d-flex flex-column py-2">
                    <div class="d-flex align-items-center">
                        <div class="mx-3" >
                            <a href="{{ route("dosen.kelas.materi.show", [$kelas->kode_kelas, $materi->id]) }} "
                                class="fs-4 fw-bold text-hover-primary text-gray-800 ">
                                {{ $materi->judul }}
                                @if($materi->status == "published")
                                    <span class="badge badge-light-success ms-2 mb-3">Published</span>
                                @else
                                    <span class="badge badge-light-warning ms-2 mb-5">Draft</span>
                                @endif
                            </a>
                            <div class="fs-6 fw-semibold text-gray-500">
                                {{ $materi->deskripsi }}
                            </div>
                            <small class="mt-3">
                                {{-- <span class="text-muted fs-6">Tanggal Publish:</span> --}}
                                <span
                                    class="text-primary fs-6 fw-bold">{{ $materi->created_at->diffForHumans() }}</span>
                            </small>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-7"></div>
                    <div class="text-end">
                        <a href="{{ route("dosen.kelas.materi.show", [$kelas->kode_kelas, $materi->id]) }}"
                         class="btn btn-sm btn-light btn-active-light-primary">Pelajari
                            Sekarang</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>