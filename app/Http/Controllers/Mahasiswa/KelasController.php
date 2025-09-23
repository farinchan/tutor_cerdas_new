<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\KelasMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Materi;
use App\Models\SettingWebsite;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = KelasMahasiswa::where('nim', Auth::user()->mahasiswa->nim)->where('status', 'aktif')->with('kelas')->get();
        $data = [
            'title' => 'Kelas',
            'kode_kelas_new' => Str::random(10),
            'kelas' => Kelas::whereIn('kode_kelas', $kelas->pluck('kode_kelas'))->with([
                'pretest.session' => function ($query) {
                    $query->where('user_id', Auth::id());
                },
                'matakuliah',
                'dosen'
            ])->get(),
        ];
        // dd($data);
        // return response()->json($data);
        return view('pages.mahasiswa.kelas.index', $data);
    }

    public function join()
    {
        $kelas = Kelas::where('kode_kelas', request()->kode_kelas)->first();
        if (!$kelas) {
            Alert::error('Error', 'kelas tidak ditemukan');
            return redirect()->back()->with('error', 'Kode kelas tidak ditemukan');
        }

        $kelas_mahasiswa = KelasMahasiswa::where('nim', Auth::user()->mahasiswa->nim)->where("kode_kelas", request()->kode_kelas)->first();

        if ($kelas_mahasiswa) {
            if ($kelas_mahasiswa->status == "nonaktif") {
                Alert::error('Error', 'Anda sudah mengirim permintaan bergabung, silahkan tunggu konfirmasi dari dosen');
                return redirect()->back();
            } elseif ($kelas_mahasiswa->status == "aktif") {
                Alert::error('Error', 'Anda sudah bergabung di kelas ini');
                return redirect()->back();
            } else {
                Alert::error('Error', 'Status kelas tidak valid');
                return redirect()->back();
            }
        } else {
            try {
                KelasMahasiswa::create([
                'nim' => Auth::user()->mahasiswa->nim,
                'kode_kelas' => $kelas->kode_kelas,
                'status' => 'nonaktif'
            ]);
            } catch (\Throwable $th) {
                Alert::error('Error', 'Terjadi kesalahan : ' . $th->getMessage());
                return redirect()->back();
            }


            Alert::success('Berhasil', 'Permintaan bergabung berhasil dikirim, silahkan tunggu konfirmasi dari dosen, cek email secara berkala');
            return redirect()->back();
        }

        Alert::error('Error', 'Terjadi kesalahan');
        return redirect()->back();
    }

    public function show($kode_kelas)
    {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->with(['matakuliah', 'dosen'])->first();
        $materi_list = Materi::where('kode_kelas', $kode_kelas)->with([
            'exam.examSessions' => function ($query) {
                $query->where('user_id', Auth::id());
            },
        ])->get()
            ->map(function ($materi, $index) use ($kode_kelas) {
                // Cek apakah ada ujian terkait dengan materi ini
                $materi->is_locked = false; // Default terbuka

                if ($index > 0) {
                    $materi_sebelumnya = Materi::where('kode_kelas', $kode_kelas)
                        ->with(['exam.examSessions' => function ($query) {
                            $query->where('user_id', Auth::id());
                        }])
                        ->orderBy('id', 'asc')
                        ->get()[$index - 1];

                    $examSession = $materi_sebelumnya->exam?->examSessions?->contains('status', 'lulus') ?? false;

                    if (!$examSession) {
                        $materi->is_locked = true; // Kunci materi jika ujian sebelumnya belum lulus
                    }
                }

                return $materi;
            });
        $data = [
            'title' => 'Detail Kelas',
            'menu' => 'kelas',
            'sub_menu' => 'kelas',
            'kelas' => $kelas,
            'materi_list' => $materi_list,
            'belum_lulus' => $materi_list->where('is_locked', true)->count(),
            'list_mahasiswa' => KelasMahasiswa::where('kode_kelas', $kode_kelas)->with('mahasiswa')->where('status', 'aktif')->get(),
            'nilai_saya' => Mahasiswa::leftJoin('users', 'mahasiswa.user_id', 'users.id')
                ->leftJoin('kelas_mahasiswa', 'mahasiswa.nim', 'kelas_mahasiswa.nim')
                ->leftJoin('nilai', 'mahasiswa.nim', 'nilai.nim')
                ->where('kelas_mahasiswa.kode_kelas', $kode_kelas)
                ->where('mahasiswa.nim', Auth::user()->mahasiswa->nim)
                ->first(['mahasiswa.nim', 'users.name', 'nilai.nilai_pretest', 'nilai.nilai_tugas', 'nilai.nilai_quiz', 'nilai.nilai_uts', 'nilai.nilai_uas', 'nilai.nilai_akhir'])

        ];
        // return response()->json($data);
        return view('pages.mahasiswa.kelas.show', $data);
    }

    public function Certificate($kode_kelas)
    {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->with(['matakuliah', 'dosen'])->first();
        if (!$kelas) {
            Alert::error('Error', 'Kelas tidak ditemukan');
            return redirect()->back();
        }

        $materi_list = Materi::where('kode_kelas', $kode_kelas)->with([
            'exam.examSessions' => function ($query) {
                $query->where('user_id', Auth::id());
            },
        ])->get()
            ->map(function ($materi, $index) use ($kode_kelas) {
                // Cek apakah ada ujian terkait dengan materi ini
                $materi->is_locked = false; // Default terbuka

                if ($index > 0) {
                    $materi_sebelumnya = Materi::where('kode_kelas', $kode_kelas)
                        ->with(['exam.examSessions' => function ($query) {
                            $query->where('user_id', Auth::id());
                        }])
                        ->orderBy('id', 'asc')
                        ->get()[$index - 1];

                    $examSession = $materi_sebelumnya->exam?->examSessions?->contains('status', 'lulus') ?? false;

                    if (!$examSession) {
                        $materi->is_locked = true; // Kunci materi jika ujian sebelumnya belum lulus
                    }
                }

                return $materi;
            });

            // return response()->json($materi_list);

        if ($materi_list->where('is_locked', true)->count() > 0) {
            Alert::error('Error', 'Anda belum menyelesaikan semua materi');
            return redirect()->back();
        }

        // Cek apakah sertifikat sudah ada, jika belum maka buat
        $certificate = Certificate::where('user_id', Auth::id())->where('kode_kelas', $kode_kelas)->first();
        if (!$certificate) {
            $certificate = Certificate::create([
                'user_id' => Auth::id(),
                'kode_kelas' => $kode_kelas,
            ]);
        }
        $setting = SettingWebsite::first();

        $qrUrl = route('certificate.show', $certificate->id);
        $qrBinary = QrCode::format('png')
            ->size(1550)
            ->margin(1)
            ->errorCorrection('H')
            ->generate($qrUrl);

        $qrCodeSrc = 'data:image/png;base64,' . base64_encode($qrBinary);

        $data = [
            'logo' => 'data:image/png;base64,' . base64_encode(file_get_contents(storage_path('app/public/' . $setting->logo))),
            'certificate_no' => $certificate->id,
            'title' => 'Sertifikat Kelas',
            'kelas' => $kelas,
            'materi_list' => $materi_list,
            'user' => Auth::user(),
            'certificate' => $certificate,
            'date' => now()->format('l, d F Y'),
            'qr_code' => $qrCodeSrc,
        ];

        $pdf = Pdf::loadView('pages.mahasiswa.kelas.certificate-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('sertifikat_kelas.pdf');

        // return view('pages.mahasiswa.kelas.certificate-pdf', $data);
    }

    public function getLinkedInShareUrl($kode_kelas)
    {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->with(['matakuliah', 'dosen'])->first();
        if (!$kelas) {
            return response()->json(['error' => 'Kelas tidak ditemukan'], 404);
        }

        // Cek apakah mahasiswa sudah lulus semua materi
        $materi_list = Materi::where('kode_kelas', $kode_kelas)->with([
            'exam.examSessions' => function ($query) {
                $query->where('user_id', Auth::id());
            },
        ])->get()
            ->map(function ($materi, $index) use ($kode_kelas) {
                $materi->is_locked = false;

                if ($index > 0) {
                    $materi_sebelumnya = Materi::where('kode_kelas', $kode_kelas)
                        ->with(['exam.examSessions' => function ($query) {
                            $query->where('user_id', Auth::id());
                        }])
                        ->orderBy('id', 'asc')
                        ->get()[$index - 1];

                    $examSession = $materi_sebelumnya->exam?->examSessions?->contains('status', 'lulus') ?? false;

                    if (!$examSession) {
                        $materi->is_locked = true;
                    }
                }

                return $materi;
            });

        if ($materi_list->where('is_locked', true)->count() > 0) {
            return response()->json(['error' => 'Anda belum menyelesaikan semua materi'], 400);
        }

        // Cek atau buat sertifikat
        $certificate = Certificate::where('user_id', Auth::id())->where('kode_kelas', $kode_kelas)->first();
        if (!$certificate) {
            $certificate = Certificate::create([
                'user_id' => Auth::id(),
                'kode_kelas' => $kode_kelas,
            ]);
        }

        // URL untuk verifikasi sertifikat
        $certificateUrl = route('certificate.show', $certificate->id);

        // Data untuk LinkedIn Share
        $courseName = $kelas->nama_kelas . ' - ' . $kelas->matakuliah->nama_mk;
        $issuerName = config('app.name', 'Tutor Cerdas');
        $userName = Auth::user()->name;

        // LinkedIn Share URL parameters
        $linkedInParams = [
            'summary' => "🎓 Saya bangga mengumumkan bahwa saya telah berhasil menyelesaikan kursus '$courseName' di $issuerName!\n\n" .
                        "📚 Kursus ini telah memberikan saya pemahaman mendalam tentang materi yang diajarkan dan meningkatkan kemampuan saya dalam bidang ini.\n\n" .
                        "✅ Verifikasi sertifikat: $certificateUrl\n\n" .
                        "#education #learning #certificate #achievement #onlinelearning #" . str_replace(' ', '', strtolower($kelas->matakuliah->nama_mk)),
            'title' => "Certificate of Completion: $courseName",
            'url' => $certificateUrl,
            'source' => $issuerName
        ];

        $linkedInUrl = 'https://www.linkedin.com/sharing/share-offsite/?' . http_build_query($linkedInParams);

        return response()->json([
            'linkedin_url' => $linkedInUrl,
            'certificate_url' => $certificateUrl,
            'course_name' => $courseName,
            'issuer_name' => $issuerName,
            'user_name' => $userName,
            'certificate_id' => $certificate->id
        ]);
    }
}
