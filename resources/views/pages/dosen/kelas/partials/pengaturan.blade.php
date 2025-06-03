<div class="card pt-4 mb-6 mb-xl-9">
    <div class="card-header border-0">
        <div class="card-title">
            <h2>{{ __('class.settings') }}</h2>
        </div>
    </div>
    <div class="card-body pt-0 pb-5 ">
        <form action="{{ route('dosen.kelas.update', $kelas->kode_kelas) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-body">
                <div class="row mb-8">
                    <label class="form-label fw-bold required">{{ __('class.class_subject') }}:</label>
                    <select class="form-select form-select-solid" id="matkul" name="kode_mk" data-control="select2"
                        data-placeholder=" {{ __('class.class_subject_select') }}" required>
                        <option></option>
                        @foreach ($list_matakuliah as $matakuliah)
                            <option value="{{ $matakuliah->kode_mk }}"
                                {{ $kelas->kode_mk == $matakuliah->kode_mk ? 'selected' : '' }}>
                                {{ $matakuliah->nama_mk }} ({{ $matakuliah->kode_mk }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-8 mt-8">
                    <label class="form-label fw-bold required">{{ __('class.class_code') }}:</label>
                    <input type="text" class="form-control " placeholder="Kode Kelas"
                        value="{{ $kelas->kode_kelas }}" readonly />
                </div>
                <div class="mb-8 mt-5">
                    <label class="form-label fw-bold required">{{ __('class.class_name') }}:</label>
                    <input type="text" class="form-control " name="nama_kelas" placeholder="Nama Kelas"
                        value="{{ $kelas->nama_kelas }}" />
                </div>
                <div class="mb-8">
                    <label class="form-label fw-bold required">{{ __('class.class_level') }}:</label>
                    <select class="form-select" data-placeholder="Pilih Tingkat" name="tingkat" required>
                        <option>Pilih Tingkat</option>
                        <option value="D3" {{ $kelas->tingkat == 'D3' ? 'selected' : '' }}>D3
                        </option>
                        <option value="D4" {{ $kelas->tingkat == 'D4' ? 'selected' : '' }}>D4
                        </option>
                        <option value="S1" {{ $kelas->tingkat == 'S1' ? 'selected' : '' }}>S1
                        </option>
                        <option value="S2" {{ $kelas->tingkat == 'S2' ? 'selected' : '' }}>S2
                        </option>
                        <option value="S3" {{ $kelas->tingkat == 'S3' ? 'selected' : '' }}>S3
                        </option>
                    </select>
                </div>
                <div class="mb-8">
                    <label class="form-label fw-bold required">{{ __('class.class_major') }}:</label>
                    <input type="text" class="form-control " placeholder="Jurusan" name="jurusan"
                        value="{{ $kelas->jurusan }}" required />
                </div>
            </div>

            <div class="modal-footer">
                <button type="reset" class="btn btn-light" data-bs-dismiss="modal">{{ __('class.cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('class.update') }}</button>
            </div>
        </form>
    </div>
</div>


<div class="card mt-5">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
        data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{ __('class.delete_class') }}</h3>
        </div>
    </div>
    <div id="kt_account_settings_deactivate" class="collapse show">

        <div class="card-body border-top p-9">
            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                <i class="ki-duotone ki-information fs-2tx text-warning me-4">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>
                <div class="d-flex flex-stack flex-grow-1">
                    <div class="fw-semibold">
                        <h4 class="text-gray-900 fw-bold">{{ __('class.delete_class_confirmation') }}</h4>
                        <div class="fs-6 text-gray-700">
                            {{ __('class.delete_class_placeholder') }}
                        </div>

                    </div>
                </div>
            </div>
            <div class="form-check form-check-solid fv-row">
                <input name="deactivate" class="form-check-input" type="checkbox" value="" id="deactivate" />
                <label class="form-check-label fw-semibold ps-2 fs-6" for="deactivate">
                    {{ __('class.delete_class_confirm') }}
                </label>
            </div>
        </div>
        <div id="delete_issue" style="display: none">
            <form action="{{ route('dosen.kelas.delete', $kelas->kode_kelas) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-danger fw-semibold"
                        style="background: linear-gradient(45deg, #ff0000, #ff7f7f); color: white; animation: shimmer 2s infinite; border: none;">
                        {{ __('class.delete_class') }}
                    </button>
                    <style>
                        @keyframes shimmer {
                            0% {
                                background-position: -200px 0;
                            }

                            100% {
                                background-position: 200px 0;
                            }
                        }

                        #kt_account_deactivate_account_submit {
                            background-size: 400% 100%;
                        }
                    </style>
                </div>
            </form>
        </div>
    </div>
</div>
