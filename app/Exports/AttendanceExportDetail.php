<?php

namespace App\Exports;

use App\Models\Qrcode;
use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class AttendanceExportDetail implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        $data_stu = Qrcode::where('id', $this->id)
            ->with(['qrcode_all.student_substu', 'qrcode_subject.branch', 'qrcode_subject.year', 'user'])
            ->whereHas('qrcode_all', function ($query) {
                $query->where('qrcode_id', $this->id);
            })
            ->get();

        // dd($data_stu->toArray());
        return $data_stu;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $date = $this->collection()->first()->created_at->thaidate('l j F Y');
                $time = $this->collection()->first()->created_at->thaidate('H:i');

                $subject_name = $this->collection()->first()->qrcode_subject->subject_name;
                $subject_id = $this->collection()->first()->qrcode_subject->subject_id;

                $branch = $this->collection()->first()->qrcode_subject->branch->name;
                $year = $this->collection()->first()->qrcode_subject->year->name;

                $teacher_name = $this->collection()->first()['user'][0]['name'];

                // A1:H1
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->setCellValue('A1', 'รายงานผลการเช็คชื่อ ' . 'วัน' . $date . ' ' . '(เวลา' . '.' . ' ' . '' . $time . ' ' . 'น)');

                // A2:H2
                $event->sheet->mergeCells('A2:D2');
                $event->sheet->setCellValue('A2', 'วิชา ' . $subject_name . '  ' . '' . 'รหัสวิชา' . ' ' . '' . $subject_id);

                // A3:H3
                $event->sheet->mergeCells('A3:D3');
                $event->sheet->setCellValue('A3', '' . $branch  . '' . ' ' . ' ' . $year . ' ');

                // A4:H4
                $event->sheet->mergeCells('A4:D4');
                $event->sheet->setCellValue('A4', 'อาจารย์ผู้สอน' . ' ' . $teacher_name);

                $event->sheet->getStyle('A1:D100')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getStyle('A1:D100')->applyFromArray([
                    'font' => [
                        'name' => 'TH Sarabun new',
                        'size' => 14
                    ]
                ]);

                foreach (range('A', 'D') as $columnID) {
                    $event->sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            },
        ];
    }


    public function headings(): array
    {
        return [
            [],
            [],
            [],
            [],
            ['รหัสนักศึกษา', 'ชื่อ-นามสกุล', 'สถานะ', 'วันที่/เวลาเช็คชื่อ'],
        ];
    }

    public function map($row): array
    {
        $qrcodeData = $row['qrcode_all'];
        $mappedData = [];

        foreach ($qrcodeData as $data) {
            $updatedAt = $data['updated_at'];
            $updatedAtDisplay = ($updatedAt === null) ? '-' :
                "วัน " . thaidate('l j F Y', $updatedAt) . " " . thaidate('H:i', $updatedAt) . " น.";

            $mappedData[] = [
                $data['student_id'],
                $data['student_substu']['name'],
                $data['status'],
                $updatedAtDisplay
            ];
        }

        // Add 4 empty rows at the beginning
        array_unshift($mappedData, [], [], [], [], []);

        return $mappedData;
    }
}
