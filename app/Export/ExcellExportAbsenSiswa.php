<?php

namespace App\Export;

use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcellExportAbsenSiswa
{
    protected $data;
    protected $fileName;

    public function __construct(array $data, string $fileName)
    {
        $this->data = $data;
        $this->fileName = $fileName;
    }

    public function export(): StreamedResponse
    {
        Log::info('Starting Excel export with ' . count($this->data) . ' records');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set default font
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(12);

        // Set header
        $headers = [
            'No', 'NISN', 'Nama Siswa', 'Jurusan', 'Kelas',
            'Hari', 'Tanggal', 'Waktu', 'Keterangan'
        ];

        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++;
        }

        // Apply header style
        $headerStyle = [
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9']
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN]
            ]
        ];

        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

        // Fill data
        $row = 2;
        $no = 1;

        foreach ($this->data as $absen) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $absen['nisn'] ?? '-');
            $sheet->setCellValue('C' . $row, $absen['nama_siswa'] ?? '-');
            $sheet->setCellValue('D' . $row, $absen['jurusan'] ?? '-');
            $sheet->setCellValue('E' . $row, $absen['kelas'] ?? '-');
            $sheet->setCellValue('F' . $row, $absen['hari'] ?? '-');

            // Format tanggal
            $tanggal = '-';
            if (isset($absen['created_at'])) {
                if ($absen['created_at'] instanceof \Carbon\Carbon || $absen['created_at'] instanceof \DateTime) {
                    $tanggal = $absen['created_at']->format('d M Y');
                } elseif (is_string($absen['created_at'])) {
                    $tanggal = \Carbon\Carbon::parse($absen['created_at'])->format('d M Y');
                }
            }
            $sheet->setCellValue('G' . $row, $tanggal);

            // Format waktu
            $waktu = '-';
            if (isset($absen['waktu_absen'])) {
                $waktu = $absen['waktu_absen'];
            } elseif (isset($absen['created_at'])) {
                if ($absen['created_at'] instanceof \Carbon\Carbon || $absen['created_at'] instanceof \DateTime) {
                    $waktu = $absen['created_at']->format('H:i:s');
                } elseif (is_string($absen['created_at'])) {
                    $waktu = \Carbon\Carbon::parse($absen['created_at'])->format('H:i:s');
                }
            }
            $sheet->setCellValue('H' . $row, $waktu);

            // Keterangan
            $keterangan = '-';
            if (isset($absen['is_late'])) {
                $keterangan = $absen['is_late'];
            }
            if (isset($absen['jenis'])) {
                $keterangan .= ' (' . $absen['jenis'] . ')';
            }
            $sheet->setCellValue('I' . $row, $keterangan);

            // Apply border to data row
            $sheet->getStyle('A' . $row . ':I' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                ]
            ]);

            $no++;
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Center align for some columns
        $sheet->getStyle('A:A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G:H')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I:I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Create writer and return as download
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="arus_kas_' . $this->fileName . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
