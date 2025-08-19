<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Sertifikat Kelulusan</title>
    <style>
        /* ==== PDF/A4 tanpa margin ==== */
        @page {
            size: A4 landscape;
            margin: 0;
        }

        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            font-family: 'Poppins', 'Inter', 'DejaVu Sans', Arial, sans-serif;
            color: #1f2a66;
        }

        /* ==== Halaman ==== */
        .page {
            position: relative;
            width: 297mm;
            /* Lebar A4 landscape */
            height: 210mm;
            /* Tinggi A4 landscape */
            overflow: hidden;
        }

        .page+.page {
            /* Halaman berikutnya mulai di halaman baru */
            page-break-before: always;
        }

        /* ==== Background per halaman ==== */
        .bg {
            position: absolute;
            inset: 0;
            z-index: -1;
        }

        .bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ==== Elemen depan (HALAMAN 1) ==== */
        .top {
            position: absolute;
            top: 70px;
            left: 0;
            right: 0;
            text-align: center;
        }

        .logo {
            width: auto;
            height: 70px;
            margin: 0 auto 8px;
        }

        .title {
            margin-top: 6px;
            font-weight: 800;
            font-size: 54px;
            letter-spacing: 8px;
            color: #ff9800;
        }

        .subtitle {
            margin-top: -10px;
            font-weight: 700;
            font-size: 28px;
            letter-spacing: 8px;
            color: #1f2a66;
        }

        .cert-no {
            margin-top: -5px;
            font-size: 12px;
            color: #2d3a90;
        }

        .to {
            margin-top: 28px;
            font-size: 16px;
            color: #2d3a90;
        }

        .name {
            margin-top: 10px;
            font-weight: 800;
            font-size: 64px;
            color: #1f2a66;
        }

        .desc {
            margin: 3px auto 0;
            width: 48%;
            font-size: 18px;
            text-align: center;
            color: #2d3a90;
            line-height: 1.5;
        }

        .footer {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 130px;
            text-align: center;
        }

        .role {
            font-weight: 800;
            font-size: 20px;
            color: #1f2a66;
        }

        .sign-name {
            font-size: 18px;
            margin-top: 50px;
            font-weight: 700;
            margin-bottom: -8px;
        }

        .sign-line {
            width: 220px;
            height: 2px;
            background: #ff9800;
            margin: 8px auto 6px;
        }

        .sign-phone {
            font-size: 14px;
            color: #2d3a90;
            margin-top: -80px;
        }

        .verify {
            position: absolute;
            right: 70px;
            bottom: 110px;
            width: 210px;
            text-align: right;
            color: #1f2a66;
        }

        .verify img {
            width: 90px;
            height: 90px;
            object-fit: contain;
        }

        .verify-title {
            font-weight: 700;
            font-size: 12px;
            margin-top: 8px;
        }

        .verify-url {
            font-size: 10px;
            line-height: 1.4;
            margin-top: 0px;
        }

        .bold {
            font-weight: 700;
        }

        .orange {
            color: #ff9800;
        }

        /* ==== Elemen belakang (HALAMAN 2) ==== */
        .back-wrap {
            position: absolute;
            inset: 30mm 20mm 25mm 20mm;
            /* padding konten di belakang */
            display: block;
        }

        .back-title {
            text-align: center;
            font-weight: 800;
            font-size: 24px;
            letter-spacing: 2px;
            margin-bottom: 8mm;
            color: #1f2a66;
        }

        .meta {
            font-size: 12px;
            color: #2d3a90;
            margin-bottom: 6mm;
            display: flex;
            justify-content: space-between;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            page-break-inside: avoid;
        }

        th,
        td {
            border: 1px solid #ced4f3;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background: #f7f9ff;
            font-weight: 700;
        }

        tfoot td {
            font-weight: 800;
            background: #fff7e8;
            /* sedikit oranye lembut */
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        /* Hindari tabel terpotong */
        .table-block {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    {{-- ================= HALAMAN 1 (SERTIFIKAT) ================= --}}
    <div class="page">
        <div class="bg">
            <img src="{{ public_path('assets/bg_certificate.png') }}" alt="bg">
        </div>

        <div class="top">
            @if (!empty($logo))
                <img class="logo" src="{{ $logo }}" alt="logo">
            @endif

            <div class="title">SERTIFIKAT</div>
            <div class="subtitle">KELULUSAN</div>
            <div class="cert-no">Certificate No. {{ $certificate_no ?? '0000' }}</div>

            <div class="to">di berikan kepada :</div>
            <div class="name">{{ $user->name ?? '-' }}</div>

            <div class="desc">
                Telah berhasil lulus pada Mata Kuliah {{ $kelas->matakuliah->name ?? '-' }}
                pada kelas {{ $kelas->nama_kelas ?? '-' }} Jurusan {{ $kelas->jurusan ?? '-' }}.
            </div>
        </div>

        <div class="footer">
            <div class="role">Dosen Pengampu</div>

            @if (!empty($signature_path))
                <img src="{{ $signature_path }}" alt="signature" style="height:110px;">
            @else
                <div style="height:20px;"></div>
            @endif

            <div class="sign-name">{{ $kelas->dosen->user->name ?? '-' }}</div>
            <div class="sign-line"></div>
            <div class="sign-phone">{{ $kelas->dosen->nidn ?? '-' }}</div>
        </div>

        <div class="verify">
            @if (!empty($qr_code))
                <img src="{{ $qr_code }}" alt="QR">
            @endif
            <div class="verify-title">Verifikasi Sertifikat</div>
            <div class="verify-url">
                {{ str_replace(['http://', 'https://'], '', url('/certificate')) ?? '-' }}
                {{ ' ' . ($certificate->id ?? '') }}
            </div>
        </div>
    </div>

    {{-- ================= HALAMAN 2 (RINCIAN NILAI) ================= --}}
    <div class="page">
        <div class="bg">
            {{-- Jika ingin background berbeda untuk belakang, ganti file di bawah --}}
            <img src="{{ public_path('assets/bg_certificate_back.png') }}" alt="bg-back">
        </div>

        <div class="back-wrap">
            <div class="back-title">RINCIAN NILAI</div>

            <div class="meta">
                <div><b>Nama</b>: {{ $user->name ?? '-' }}</div>
                <div><b>NIM</b>: {{ $user->mahasiswa?->nim ?? '-' }}</div>
                <div><b>Mata Kuliah</b>: {{ $kelas->matakuliah->nama_mk ?? '-' }}</div>
            </div>

            <div class="table-block">
                <table>
                    <thead>
                        <tr>
                            <th class="center" style="width:8%">No</th>
                            <th>Materi</th>
                            <th class="right" style="width:18%">Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalAkhir = 0;
                            $jumlahMateri = 0;
                        @endphp
                        @forelse($materi_list as $i => $m)
                        @php
                            $totalAkhir += (!empty($m->exam) && !empty($m->exam->examSessions)) ? collect($m->exam->examSessions)->max('score') ?? 0 : 0;
                            $jumlahMateri++;
                        @endphp
                            <tr>
                                <td class="center">{{ $i + 1 }}</td>
                                <td>{{ $m->judul ?? '-' }}</td>
                                <td class="right">
                                    {{ number_format(!empty($m->exam) && !empty($m->exam->examSessions) ? collect($m->exam->examSessions)->max('score') ?? 0 : 0, 0) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="center" colspan="3">Belum ada data nilai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="right" colspan="2">Total Nilai Akhir</td>
                            <td class="right">{{ number_format($totalAkhir, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="right" colspan="2">Grade Huruf</td>
                            <td class="right">
                                @php

                                    // Contoh konversi
                                    $grade = '-';
                                    $totalNilai = $totalAkhir / $jumlahMateri;
                                    if ($totalNilai >= 85) {
                                        $grade = 'A';
                                    } elseif ($totalNilai >= 75) {
                                        $grade = 'B';
                                    } elseif ($totalNilai >= 65) {
                                        $grade = 'C';
                                    } elseif ($totalNilai >= 55) {
                                        $grade = 'D';
                                    } else {
                                        $grade = 'E';
                                    }
                                @endphp
                                {{ $grade }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div style="margin-top:10mm; font-size:11px; color:#2d3a90;">
                Catatan: Perincian nilai ini merupakan bagian tak terpisahkan dari sertifikat kelulusan.
                Silakan lakukan verifikasi keaslian melalui alamat pada QR di lembar depan.
            </div>
        </div>
    </div>

</body>

</html>
