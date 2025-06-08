<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nilai</title>
</head>
@php
    $materi = \App\Models\Materi::where('kode_kelas', $kelas->kode_kelas)->pluck('id')->toArray();
@endphp

<body>
    <!-- Header Section -->
    <div style="text-align: center; margin-bottom: 20px;">
        <h2>Daftar Nilai Mahasiswa</h2>

    </div>
    <div style="margin-bottom: 20px;">
        <p style="margin: 0 0 4px 0;"><strong>Kelas:</strong> {{ $kelas->nama_kelas ?? '-' }}</p>
        <p style="margin: 0 0 4px 0;"><strong>Dosen:</strong> {{ $kelas->dosen?->user?->name ?? '-' }}</p>
        <p style="margin: 0;"><strong>Mata Kuliah:</strong> {{ $kelas->matakuliah->nama_mk ?? '-' }}</p>
    </div>
    <div style="overflow-x:auto;">
        <table border="1" style="width:100%; border-collapse:collapse;">
            <thead>
            <tr>
                <th rowspan="2">NIM</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Pretest</th>
                <th rowspan="2">UTS</th>
                <th rowspan="2">UAS</th>
                @if (count($materi) > 0)
                <th colspan="{{ count($materi) }}">Materi</th>
                @endif
            </tr>
            @if (count($materi) > 0)
                <tr class="text-start text-muted text-uppercase gs-0">
                @for ($i = 1; $i <= count($materi); $i++)
                    <th>{{ $i }}</th>
                @endfor
                </tr>
            @endif
            </thead>
            <tbody style="">
            @foreach ($list_nilai_mahasiswa as $nilai_mahasiswa)
                <tr>
                <td style="text-align: left; padding: 4px;">{{ $nilai_mahasiswa->nim }}</td>
                <td style="text-align: left; padding: 4px;">{{ $nilai_mahasiswa->name }}</td>
                <td style="text-align: center; ">{{ $nilai_mahasiswa->nilai_pretest ?? '-' }}</td>
                <td style="text-align: center; ">{{ $nilai_mahasiswa->nilai_uts ?? '-' }}</td>
                <td style="text-align: center; ">{{ $nilai_mahasiswa->nilai_uas ?? '-' }}</td>
                @foreach ($materi as $id_materi)
                    <td style="text-align: center; ;">
                    @php
                        $nilai = \App\Models\ExamSession::whereHas('exam', function ($query) use ($id_materi) {
                        $query->where('materi_id', $id_materi);
                        })
                        ->where('user_id', $nilai_mahasiswa->id)
                        ->orderBy('score', 'desc')
                        ->pluck('score')
                        ->first();
                    @endphp
                    {{ $nilai ?? '-' }}
                    </td>
                @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
