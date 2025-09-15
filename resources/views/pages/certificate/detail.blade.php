@extends('app')

@section('styles')
<style>
    .certificate-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .verification-badge {
        background: #28a745;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
    }

    .certificate-info {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        border: 1px solid #f0f0f0;
    }

    .pdf-viewer {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border: 1px solid #e9ecef;
        background: white;
    }

    .info-item {
        border-bottom: 1px solid #f5f5f5;
        padding: 1rem 0;
        transition: all 0.3s ease;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item:hover {
        background-color: #f8f9fa;
        margin: 0 -1rem;
        padding-left: 1rem;
        padding-right: 1rem;
        border-radius: 8px;
    }

    .info-label {
        font-weight: 600;
        color: #666;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        color: #333;
        font-size: 1.1rem;
        font-weight: 500;
    }

    .btn-action {
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .not-found-container {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .pdf-preview {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 15px;
        padding: 3rem;
        text-align: center;
        color: #6c757d;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    @media (max-width: 768px) {
        .certificate-card {
            padding: 1.5rem;
        }

        .certificate-info {
            padding: 1.5rem;
        }

        .col-md-4, .col-md-8 {
            margin-bottom: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    @if($certificate && $certificate->is_active == '1')
        <!-- Header Card -->
        <div class="certificate-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-3 fw-bold">
                        <i class="fas fa-certificate me-3"></i>
                        Verifikasi Sertifikat
                    </h1>
                    <p class="mb-3 opacity-75 fs-5">Sertifikat ini telah diverifikasi dan sah dikeluarkan oleh sistem</p>
                    <div class="verification-badge">
                        <i class="fas fa-check-circle"></i>
                        Sertifikat Valid & Terverifikasi
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="text-white">
                        <small class="opacity-75">ID Sertifikat:</small>
                        <h3 class="mb-0 fw-bold">#{{ strtoupper(substr($certificate->id, 0, 8)) }}</h3>
                        <small class="opacity-75">{{ \Carbon\Carbon::parse($certificate->created_at)->format('d M Y') }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Certificate Information -->
            <div class="col-lg-4 col-md-5">
                <div class="certificate-info">
                    <h4 class="mb-4 text-primary">
                        <i class="fas fa-info-circle me-2"></i>
                        Informasi Sertifikat
                    </h4>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-user me-1"></i>
                            Nama Penerima
                        </div>
                        <div class="info-value">{{ $certificate->user->name ?? 'Tidak Diketahui' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-id-badge me-1"></i>
                            NIM
                        </div>
                        <div class="info-value">{{ $certificate->user->mahasiswa->nim ?? 'Tidak Diketahui' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-graduation-cap me-1"></i>
                            Nama Kelas
                        </div>
                        <div class="info-value">{{ $certificate->kelas->nama_kelas ?? 'Tidak Diketahui' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-book me-1"></i>
                            Mata Kuliah
                        </div>
                        <div class="info-value">{{ $certificate->kelas->matakuliah->nama_matkul ?? 'Tidak Diketahui' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-chalkboard-teacher me-1"></i>
                            Dosen Pengampu
                        </div>
                        <div class="info-value">{{ $certificate->kelas->dosen->user->name ?? 'Tidak Diketahui' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-id-card me-1"></i>
                            NIDN Dosen
                        </div>
                        <div class="info-value">{{ $certificate->kelas->dosen->nidn ?? 'Tidak Diketahui' }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-calendar me-1"></i>
                            Tanggal Terbit
                        </div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($certificate->created_at)->format('d F Y') }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-shield-alt me-1"></i>
                            Status
                        </div>
                        <div class="info-value">
                            <span class="badge bg-success fs-6 px-3 py-2">
                                <i class="fas fa-check me-1"></i>
                                Aktif & Valid
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-key me-1"></i>
                            Kode Kelas
                        </div>
                        <div class="info-value">
                            <code class="bg-light p-2 rounded">{{ $certificate->kode_kelas }}</code>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-3">
                    <a href="{{ route('certificate.generate-pdf', $certificate->id) }}"
                       class="btn btn-primary btn-action" target="_blank">
                        <i class="fas fa-file-pdf me-2"></i>
                        Download Sertifikat PDF
                    </a>

                    <button class="btn btn-outline-secondary btn-action" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>
                        Cetak Halaman
                    </button>

                    <button class="btn btn-outline-info btn-action" onclick="copyToClipboard()">
                        <i class="fas fa-link me-2"></i>
                        Salin Link Verifikasi
                    </button>

                    <a href="{{ route('certificate.index') }}" class="btn btn-outline-dark btn-action">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Verifikasi
                    </a>
                </div>
            </div>

            <!-- PDF Preview -->
            <div class="col-lg-8 col-md-7">
                <div class="certificate-info">
                    <h4 class="mb-4 text-primary">
                        <i class="fas fa-file-pdf me-2"></i>
                        Preview Sertifikat
                    </h4>

                    <div class="pdf-viewer">
                        <div class="pdf-preview">
                            <i class="fas fa-file-pdf text-primary mb-3" style="font-size: 4rem;"></i>
                            <h5 class="text-muted mb-3">Preview Sertifikat PDF</h5>
                            <p class="text-muted mb-4">
                                Sertifikat tersedia dalam format PDF dan dapat diunduh.
                                <br>
                                Klik tombol "Download Sertifikat PDF" untuk melihat dan mengunduh sertifikat lengkap.
                            </p>

                            <div class="row text-start">
                                <div class="col-md-6">
                                    <h6 class="text-dark mb-2">
                                        <i class="fas fa-certificate text-warning me-2"></i>
                                        Fitur Sertifikat:
                                    </h6>
                                    <ul class="list-unstyled small text-muted">
                                        <li><i class="fas fa-check text-success me-2"></i>Format PDF berkualitas tinggi</li>
                                        <li><i class="fas fa-check text-success me-2"></i>QR Code untuk verifikasi</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Informasi lengkap mahasiswa</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Tanda tangan digital dosen</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-dark mb-2">
                                        <i class="fas fa-list-alt text-info me-2"></i>
                                        Rincian Nilai:
                                    </h6>
                                    <ul class="list-unstyled small text-muted">
                                        <li><i class="fas fa-check text-success me-2"></i>Nilai per materi pembelajaran</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Total nilai akhir</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Grade huruf</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Catatan pencapaian</li>
                                    </ul>
                                </div>
                            </div>

                            <a href="{{ route('certificate.generate-pdf', $certificate->id) }}"
                               class="btn btn-primary btn-action mt-3" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>
                                Buka Sertifikat PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($certificate && $certificate->is_active != '1')
        <!-- Certificate Inactive -->
        <div class="not-found-container">
            <i class="fas fa-exclamation-circle text-warning mb-4" style="font-size: 5rem;"></i>
            <h2 class="text-muted mb-3">Sertifikat Tidak Aktif</h2>
            <p class="text-muted mb-4 fs-5">
                Sertifikat dengan ID <strong>#{{ strtoupper(substr($certificate->id, 0, 8)) }}</strong>
                ditemukan tetapi saat ini tidak aktif atau telah dicabut.
            </p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        Hubungi administrator atau dosen pengampu untuk informasi lebih lanjut.
                    </div>
                </div>
            </div>
            <a href="{{ route('certificate.index') }}" class="btn btn-primary btn-action">
                <i class="fas fa-search me-2"></i>
                Coba Verifikasi Lagi
            </a>
        </div>
    @else
        <!-- Certificate Not Found -->
        <div class="not-found-container">
            <i class="fas fa-exclamation-triangle text-danger mb-4" style="font-size: 5rem;"></i>
            <h2 class="text-muted mb-3">Sertifikat Tidak Ditemukan</h2>
            <p class="text-muted mb-4 fs-5">
                Sertifikat dengan ID yang Anda cari tidak dapat ditemukan dalam sistem kami.
                Pastikan ID sertifikat yang Anda masukkan benar.
            </p>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Tips:</strong> Periksa kembali ID sertifikat atau gunakan QR Code yang tertera pada sertifikat fisik.
                    </div>
                </div>
            </div>
            <a href="{{ route('certificate.index') }}" class="btn btn-primary btn-action">
                <i class="fas fa-search me-2"></i>
                Coba Verifikasi Lagi
            </a>
        </div>
    @endif
</div>

<script>
function copyToClipboard() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Link verifikasi berhasil disalin ke clipboard',
            timer: 2000,
            showConfirmButton: false
        });
    }).catch(function(err) {
        console.error('Error copying to clipboard: ', err);
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Gagal menyalin link ke clipboard'
        });
    });
}

// Auto-print functionality for print button
document.addEventListener('DOMContentLoaded', function() {
    // Add print styles
    const printStyles = `
        <style media="print">
            .btn, .no-print { display: none !important; }
            .certificate-card { background: #667eea !important; -webkit-print-color-adjust: exact; }
            .verification-badge { background: #28a745 !important; -webkit-print-color-adjust: exact; }
            body { -webkit-print-color-adjust: exact; }
        </style>
    `;
    document.head.insertAdjacentHTML('beforeend', printStyles);
});
</script>
@endsection
