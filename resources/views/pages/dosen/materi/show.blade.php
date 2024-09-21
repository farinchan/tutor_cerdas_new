@extends('app')
@section('subheader')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">View User Details</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="index.html" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">User Management</li>
                    <li class="breadcrumb-item text-gray-600">Users</li>
                    <li class="breadcrumb-item text-gray-500">View User</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <div class="card mb-5 mb-xxl-8">
            <div class="card-body pt-9 pb-0">
                <div class="overlay mb-5">
                    <img class="w-100 card-rounded"
                        src="https://preview.keenthemes.com/metronic8/demo16/assets/media/stock/1600x800/img-1.jpg"
                        alt="">
                </div>
                <div class="p-5">
                    <div class="d-flex flex-wrap flex-sm-nowrap align-items-center mb-4">
                        <div class="d-flex flex-column flex-grow-1">
                            <div class="d-flex flex-wrap me-2">
                                <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">
                                    {{ $materi->judul }}
                                </a>
                            </div>
                            <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                <a href="#"
                                    class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-bank fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    {{ $materi->kelas?->nama_kelas }}
                                </a>
                                <a href="#"
                                    class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
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
                </div>
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="#">Diskusi Kelas</a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5"
                            href="{{ route("mahasiswa.kelas.materiDiskusiPribadi", [$kode_kelas, $materi_id]) }}">Diskusi Pribadi + AI</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row g-5 g-xxl-8">
            <div class="d-flex flex-column flex-lg-row">

                <div class="flex-lg-row-fluid ">
                    <div class="card" id="kt_chat_messenger">
                        <div class="card-header" id="kt_chat_messenger_header">

                            <div class="card-title">
                                <div class="me-5">
                                    Diskusi Kelas
                                </div>
                                <div class="symbol-group symbol-hover">
                                    @foreach ($list_mahasiswa->take(5) as $mhs)
                                        <div class="symbol symbol-35px symbol-circle">
                                            <img alt="Pic" src="{{ $mhs->mahasiswa?->user?->getPhoto() }}" />
                                        </div>
                                    @endforeach
                                    <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_view_users">
                                        <span class="symbol-label fs-8 fw-bold" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover"
                                            title="View more users">+{{ $list_mahasiswa->count() }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="kt_chat_messenger_body">
                            <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages"
                                data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                data-kt-scroll-max-height="auto"
                                data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                                data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body"
                                data-kt-scroll-offset="5px">
                                @forelse ($list_diskusi_grup as $diskusi)
                                    @if ($diskusi->user_id == auth()->user()->id)
                                        <div class="d-flex justify-content-end mb-10">
                                            <div class="d-flex flex-column align-items-end">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="me-3">
                                                        <span class="text-muted fs-7 mb-1">
                                                            {{ $diskusi->created_at->diffForHumans() }}
                                                        </span>
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                                    </div>
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic" src="
                                                        @if ($diskusi->user->role() == 'mahasiswa')
                                                            {{ $diskusi->user?->getPhoto() }}
                                                        @else
                                                            {{ $diskusi->user?->getPhoto() }}
                                                        @endif
                                                        " />
                                                    </div>
                                                </div>
                                                <div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end"
                                                    data-kt-element="message-text">
                                                    {{ $diskusi->pesan }}
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-start mb-10">
                                            <div class="d-flex flex-column align-items-start">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="symbol symbol-35px symbol-circle">
                                                        <img alt="Pic" src="{{ $diskusi->user?->getPhoto() }}" />
                                                    </div>
                                                    <div class="ms-3">
                                                        <a href="#"
                                                            class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">{{ $diskusi->user->name }}</a>
                                                        <span class="text-muted fs-7 mb-1">
                                                            {{ $diskusi->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start"
                                                    data-kt-element="message-text">
                                                    {{ $diskusi->pesan }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                        <div class="d-flex justify-content-center mb-10">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="me-3">
                                                        <span class="text-muted fs-7 mb-1">
                                                            Belum ada diskusi
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                @endforelse
                            </div>
                        </div>
                        <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                            <textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input"
                                placeholder="Type a message"></textarea>
                            <div class="d-flex flex-stack">
                                <div class="d-flex align-items-center me-2">
                                    <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button"
                                        data-bs-toggle="tooltip" title="Coming soon">
                                        <i class="ki-duotone ki-paper-clip fs-3"></i>
                                    </button>
                                    <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button"
                                        data-bs-toggle="tooltip" title="Coming soon">
                                        <i class="ki-duotone ki-exit-up fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                </div>
                                <button class="btn btn-primary" type="button" data-kt-element="send">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('6b6b5777f57dd9845f5d', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('diskusi-grup');
        channel.bind('chat' + '{{ $materi->id }}', function(data) {
            let result = data.message

            if (result.user_id == '{{ auth()->user()->id }}') {
                $('[data-kt-element="messages"]').append(
                    `<div class="d-flex justify-content-end mb-10">
                        <div class="d-flex flex-column align-items-end">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3">
                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                </div>
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="${result.user.photo ? result.user.photo : 'https://ui-avatars.com/api/?background=000C32&color=fff&name=' + result.user.name}" />
                                </div>
                            </div>
                            <div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end"
                                data-kt-element="message-text">
                                ${result.pesan}
                                </div>
                        </div>
                    </div>`
                );
            } else {
                $('[data-kt-element="messages"]').append(
                    `<div class="d-flex justify-content-start mb-10">
                        <div class="d-flex flex-column align-items-start">
                            <div class="d-flex align-items-center mb-2">
                                <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="${result.user.photo ? result.user.photo : 'https://ui-avatars.com/api/?background=000C32&color=fff&name=' + result.user.name}" />
                                </div>
                                <div class="ms-3">
                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">${result.user.name}</a>
                                </div>
                            </div>
                            <div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start"
                                data-kt-element="message-text">
                                ${result.pesan}
                                </div>
                        </div>
                    </div>`
                );
            }
            $('[data-kt-element="messages"]').scrollTop($('[data-kt-element="messages"]')[0].scrollHeight);

            
        });

        $('[data-kt-element="send"]').on('click', function() {
            if ($('[data-kt-element="input"]').val() == '') {
                return;
            }
            var message = $('[data-kt-element="input"]').val();
            $.ajax({
                url: '{{ route('kirimDiskusiGrup', $materi->id) }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    pesan: message
                },
                success: function(data) {
                    console.log(data);
                    $('[data-kt-element="input"]').val('');
                    $('[data-kt-element="messages"]').scrollTop($('[data-kt-element="messages"]')[0].scrollHeight);
                  
                },
                error: function(err) {
                    Alert('error', 'Gagal mengirim pesan');
                }
            });
        });
    </script>
@endsection
