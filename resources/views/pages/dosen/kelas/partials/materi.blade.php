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
                <i class="ki-duotone ki-plus fs-3">
                </i>Tambah Materi
            </a>
        </div>
    </div>
    <div class="card-body p-9 pt-4">
        @foreach ($kelas->materi as $materi)
            <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6 mb-5">
                <div class="d-flex flex-column py-2">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/media/books.png') }}" alt=""
                            width="80px" class="me-4">
                        <div>
                            <a href="#"
                                class="fs-4 fw-bold text-hover-primary text-gray-800">
                                {{ $materi->judul }}
                            </a>
                            <div class="fs-6 fw-semibold text-gray-500">
                                {{ $materi->deskripsi }}
                            </div>
                            <small class="mt-2">
                                <span class="text-muted fs-6">Tanggal Publish:</span>
                                <span
                                    class="text-primary fs-6 fw-bold">{{ $materi->created_at->diffForHumans() }}</span>
                            </small>
                        </div>
                    </div>
                    <div class="separator separator-dashed my-7"></div>
                    <div class="text-end">
                        <button class="btn btn-sm btn-light btn-active-light-primary">Pelajari
                            Sekarang</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>