<div class="card mb-5 mb-xxl-8">
    <div class="card-body pt-9 pb-0">
        <div class="p-5">
            <div class="d-flex flex-wrap flex-sm-nowrap align-items-center mb-4">
                <div class="d-flex flex-column flex-grow-1">
                    <div class="d-flex flex-wrap me-2">
                        <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">
                            {{ $materi->judul }}
                        </a>
                    </div>
                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                            <i class="ki-duotone ki-bank fs-4 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ $materi->kelas?->nama_kelas }}
                        </a>
                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                            <i class="ki-duotone ki-user fs-4 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ $materi->dosen?->user?->name }}
                        </a>
                    </div>
                    <span class="text-muted fs-6">
                        {{ $materi->deskripsi }}
                    </span>
                </div>
            </div>
            <hr class=" mb-5">
            {!! $materi->isi_materi !!}
            @foreach ($materi->materiFiles as $file)
                <Embed type="application/pdf" src="{{ asset('storage/' . $file->file) }}" width="600"
                    height="400"></Embed>
            @endforeach

        </div>
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @if (request()->routeIs('dosen.kelas.materi.show')) active @endif"
                    href="{{ route('dosen.kelas.materi.show', [$kode_kelas, $materi_id]) }}">Diskusi Materi</a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @if (request()->routeIs('dosen.kelas.materi.diskusiPribadi')) active @endif"
                    href="{{ route('dosen.kelas.materi.diskusiPribadi', [$kode_kelas, $materi_id]) }}">Diskusi Pribadi +
                    AI</a>
            </li>
        </ul>
    </div>
</div>
