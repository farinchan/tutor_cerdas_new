<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\SettingWebsite;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Verifikasi Sertifikat',
        ];
        return view('pages.certificate.index', $data);
    }

    public function show($id)
    {
        $data = [
            'title' => 'Detail Sertifikat',
            'certificate' => Certificate::with([
                'user.mahasiswa',
                'kelas.matakuliah',
                'kelas.dosen.user'
            ])->find($id),
        ];
        return view('pages.certificate.detail', $data);
    }

    public function generatePdf($id)
    {
        $certificate = Certificate::with([
            'user.mahasiswa',
            'kelas.matakuliah',
            'kelas.dosen.user'
        ])->find($id);

        if (!$certificate) {
            return response()->json(['error' => 'Sertifikat tidak ditemukan'], 404);
        }

        if ($certificate->is_active !== '1') {
            return response()->json(['error' => 'Sertifikat tidak aktif'], 403);
        }

        $setting = SettingWebsite::first();

        // Generate QR Code untuk verifikasi
        $qrUrl = route('certificate.show', $certificate->id);
        $qrBinary = QrCode::format('png')
            ->size(1550)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($qrUrl);

        $qrCodeSrc = 'data:image/png;base64,' . base64_encode($qrBinary);

        // Data untuk PDF
        $data = [
            'certificate' => $certificate,
            'student_name' => $certificate->user->name ?? 'Tidak Diketahui',
            'course_name' => $certificate->kelas->nama_kelas ?? 'Tidak Diketahui',
            'subject_name' => $certificate->kelas->matakuliah->nama_matkul ?? 'Tidak Diketahui',
            'instructor_name' => $certificate->kelas->dosen->user->name ?? 'Tidak Diketahui',
            'issue_date' => \Carbon\Carbon::parse($certificate->created_at)->format('d F Y'),
            'certificate_id' => strtoupper(substr($certificate->id, 0, 8)),
            'logo' => $setting && $setting->logo ?
                'data:image/png;base64,' . base64_encode(file_get_contents(storage_path('app/public/' . $setting->logo))) :
                null,
            'qr_code' => $qrCodeSrc,
        ];

        // Generate PDF
        $pdf = PDF::loadView('pages.certificate.pdf-template', $data);
        $pdf->setPaper('A4', 'landscape');

        // Generate filename
        $filename = 'sertifikat-' . strtoupper(substr($certificate->id, 0, 8)) . '.pdf';

        return $pdf->download($filename);
    }
}
