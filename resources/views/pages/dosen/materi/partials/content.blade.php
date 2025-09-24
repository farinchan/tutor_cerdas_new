<div class="card mb-5 mb-xxl-8">
    <div class="card-body pt-9 pb-0">
        <div class="p-5">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="d-flex flex-column flex-grow-1 me-4">
                    <div class="d-flex align-items-center mb-2">
                        <h2 class="text-gray-800 fs-2 fw-bolder mb-0 me-3">
                            {{ $materi->judul }}
                        </h2>
                    </div>
                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-3">
                        <div class="d-flex align-items-center text-gray-500 me-5 mb-2">
                            <i class="ki-duotone ki-bank fs-4 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ $materi->kelas?->nama_kelas }}
                        </div>
                        <div class="d-flex align-items-center text-gray-500 me-5 mb-2">
                            <i class="ki-duotone ki-user fs-4 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            {{ $materi->dosen?->user?->name }}
                        </div>
                        <div class="d-flex align-items-center text-gray-500 mb-2">
                            <i class="ki-duotone ki-calendar fs-4 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                            {{ $materi->created_at->format('d M Y') }}
                        </div>
                    </div>
                    <p class="text-muted fs-6 mb-0">
                        {{ $materi->deskripsi }}
                    </p>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <a href="{{ route('dosen.materi.edit', [$kode_kelas, $materi->id]) }}"
                       class="btn btn-light-primary btn-sm d-flex align-items-center">
                        <i class="ki-duotone ki-pencil fs-5 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Edit
                    </a>
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
                    href="{{ route('dosen.kelas.materi.show', [$kode_kelas, $materi_id]) }}">{{ __('class.class_discussion') }}</a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @if (request()->routeIs('dosen.kelas.materi.diskusiPribadi')) active @endif"
                    href="{{ route('dosen.kelas.materi.diskusiPribadi', [$kode_kelas, $materi_id]) }}">{{ __('class.private_discussion') }} </a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @if (request()->routeIs('dosen.kelas.materi.ujianSoal')) active @endif"
                    href="{{ route('dosen.kelas.materi.ujianSoal', [$kode_kelas, $materi_id]) }}">{{ __('class.exam_question') }}</a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 @if (request()->routeIs('dosen.kelas.materi.ujianNilai')) active @endif"
                    href="{{ route("dosen.kelas.materi.ujianNilai", [$kode_kelas, $materi_id]) }}">{{ __('class.exam_score') }}</a>
            </li>
        </ul>
    </div>
</div>
