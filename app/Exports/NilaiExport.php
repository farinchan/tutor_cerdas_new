<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Materi;
use App\Models\ExamSession;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class NilaiExport implements FromCollection, WithHeadings, WithStyles, WithEvents, WithCustomStartCell, WithTitle
{
    protected $kode_kelas;
    protected $kelas;
    protected $materi;

    public function __construct($kode_kelas)
    {
        $this->kode_kelas = $kode_kelas;
        $this->kelas = Kelas::where('kode_kelas', $kode_kelas)->with(['matakuliah', 'dosen'])->first();
        $this->materi = Materi::where('kode_kelas', $kode_kelas)->pluck('id')->toArray();
    }

    public function collection()
    {
        $list_nilai_mahasiswa = Mahasiswa::leftJoin('users', 'mahasiswa.user_id', 'users.id')
            ->leftJoin('kelas_mahasiswa', 'mahasiswa.nim', 'kelas_mahasiswa.nim')
            ->leftJoin('nilai', 'mahasiswa.nim', 'nilai.nim')
            ->where('kelas_mahasiswa.kode_kelas', $this->kode_kelas)
            ->orderBy('mahasiswa.nim')
            ->get(['users.id', 'mahasiswa.nim', 'users.name', 'nilai.nilai_pretest', 'nilai.nilai_uts', 'nilai.nilai_uas']);

        $data = new Collection();

        foreach ($list_nilai_mahasiswa as $nilai_mahasiswa) {
            $row = [
                $nilai_mahasiswa->nim,
                $nilai_mahasiswa->name,
                $nilai_mahasiswa->nilai_pretest ?? '-',
                $nilai_mahasiswa->nilai_uts ?? '-',
                $nilai_mahasiswa->nilai_uas ?? '-',
            ];

            // Add materi scores
            foreach ($this->materi as $id_materi) {
                $nilai = ExamSession::whereHas('exam', function ($query) use ($id_materi) {
                    $query->where('materi_id', $id_materi);
                })
                ->where('user_id', $nilai_mahasiswa->id)
                ->orderBy('score', 'desc')
                ->pluck('score')
                ->first();

                $row[] = $nilai ?? '-';
            }

            $data->push($row);
        }

        return $data;
    }

    public function headings(): array
    {
        $headings = ['NIM', 'Nama', 'Pretest', 'UTS', 'UAS'];

        // Add materi headings
        for ($i = 1; $i <= count($this->materi); $i++) {
            $headings[] = "Materi $i";
        }

        return $headings;
    }

    public function startCell(): string
    {
        return 'A5'; // Start data from row 5 to leave space for header info
    }

    public function styles(Worksheet $sheet)
    {
        $lastColumn = chr(69 + count($this->materi)); // E + number of materi columns
        $lastRow = 5 + $this->collection()->count();

        return [
            // Header style
            '5' => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFE0E0E0']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ],
            // Data rows
            "A5:$lastColumn$lastRow" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            // Center alignment for score columns
            "C6:$lastColumn$lastRow" => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(15); // NIM
                $sheet->getColumnDimension('B')->setWidth(25); // Nama
                $sheet->getColumnDimension('C')->setWidth(12); // Pretest
                $sheet->getColumnDimension('D')->setWidth(12); // UTS
                $sheet->getColumnDimension('E')->setWidth(12); // UAS

                // Set materi column widths
                for ($i = 0; $i < count($this->materi); $i++) {
                    $column = chr(70 + $i); // Start from F
                    $sheet->getColumnDimension($column)->setWidth(12);
                }

                // Add header information
                $sheet->setCellValue('A1', 'DAFTAR NILAI MAHASISWA');
                $sheet->setCellValue('A2', 'Kelas: ' . ($this->kelas->nama_kelas ?? '-'));
                $sheet->setCellValue('A3', 'Dosen: ' . ($this->kelas->dosen?->user?->name ?? '-'));
                $sheet->setCellValue('A4', 'Mata Kuliah: ' . ($this->kelas->matakuliah->nama_mk ?? '-'));

                // Style header information
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2:A4')->getFont()->setBold(true);

                // Merge cells for title
                $lastColumn = chr(69 + count($this->materi));
                $sheet->mergeCells("A1:$lastColumn" . "1");
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Set row heights
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(5)->setRowHeight(20);
            },
        ];
    }

    public function title(): string
    {
        return 'Nilai Mahasiswa';
    }
}
