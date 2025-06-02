<div class="card pt-4 mb-6 mb-xl-9">
    <div class="card-header border-0">
        <div class="card-title">
            <h2>Pengaturan Kelas</h2>
        </div>
    </div>
    <div class="card-body pt-0 pb-5">
        <form action="{{ route('dosen.kelas.update', $kelas->kode_kelas) }}" method="POST">
            @csrf
            @method("PUT")

            <div class="modal-body">
                <div class="row mb-8">
                    <label class="form-label fw-bold required">{{ __('class.class_subject') }}:</label>
                    <select class="form-select form-select-solid" id="matkul" name="kode_mk" data-control="select2"
                        data-placeholder=" {{ __('class.class_subject_select') }}"
                        required>
                        <option></option>
                        @foreach ($list_matakuliah as $matakuliah)
                            <option value="{{ $matakuliah->kode_mk }}" {{$kelas->kode_mk == $matakuliah->kode_mk ? "selected" : ""}}>
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
                <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
