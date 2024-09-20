<div class="card pt-4 mb-6 mb-xl-9">
    <div class="card-header border-0">
        <div class="card-title">
            <h2>Pengaturan Kelas</h2>
        </div>
    </div>
    <div class="card-body pt-0 pb-5">
        <form action="{{ route('dosen.kelas.store') }}" method="POST">
            @csrf

            <div class="modal-body">
                <div class="row mb-8">
                    <div class="col-lg-8">
                        <label class="form-label fw-bold required">Mata Kuliah:</label>
                        <input type="text" class="form-control " placeholder="Mata Kuliah"
                            name="matakuliah" value="{{ old('') }}" />
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label fw-bold required">SKS:</label>
                        <input type="number" class="form-control " placeholder="SKS"
                            name="sks" value="{{ old('sks') }}" />
                    </div>
                </div>
                <hr>

                <div class="mb-8 mt-8">
                    <label class="form-label fw-bold required">Kode Kelas:</label>
                    <input type="text" class="form-control " placeholder="Kode Kelas"
                        value="{{ $kelas->kode_kelas }}" readonly />
                </div>
                <div class="mb-8 mt-5">
                    <label class="form-label fw-bold required">Nama Kelas:</label>
                    <input type="text" class="form-control " name="nama_kelas"
                        placeholder="Nama Kelas" value="{{ $kelas->nama_kelas }}" />
                </div>
                <div class="mb-8">
                    <label class="form-label fw-bold required">Tingkat:</label>
                    <select class="form-select" data-placeholder="Pilih Tingkat" name="tingkat"
                        required>
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
                    <label class="form-label fw-bold required">Jurusan:</label>
                    <input type="text" class="form-control " placeholder="Jurusan"
                        name="jurusan" value="{{ $kelas->jurusan }}" required />
                </div>
            </div>

            <div class="modal-footer">
                <button type="reset" class="btn btn-light"
                    data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Buat Sekarang</button>
            </div>
        </form>
    </div>
</div>