<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Subject;
use App\Models\Subject_stu;
use App\Models\Qrcode;
use Maatwebsite\Excel\Events\AfterSheet;

class AttendancExportAll implements FromCollection, WithHeadings
{
    use Exportable;

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        $subject = Subject::findOrFail($this->id);
        $subject_id = $subject->subject_id;

        // Get students related to the subject
        $subject_stu = Subject::where('subject_id', $subject_id)->with(['subject_stu'])->first(); // ใช้ first() แทน get() เพื่อให้ได้เพียงรายการเดียว

        // Get QR codes related to the subject
        $qrcodes = Qrcode::where('subject_id', $subject_id)
            ->with(['qrcode_all' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->get();

        // Count individual status for each student
        $individualStatusCounts = $this->countIndividualStatus($subject_stu, $qrcodes);

        // Transform the data into the desired format for Excel
        $exportData = $this->transformDataForExcel($individualStatusCounts);

        return $exportData;
    }

    private function countIndividualStatus($subject_stu, $qrcodes)
    {
        $individualStatusCounts = [];

        if ($subject_stu) {
            foreach ($qrcodes as $qrcode) {
                foreach ($qrcode->qrcode_all as $qrcodeData) {
                    $status = $qrcodeData['status'];
                    $studentId = $qrcodeData['student_id'];

                    if (!isset($individualStatusCounts[$studentId])) {
                        $name = null;
                        $student = $subject_stu->subject_stu->where('student_id', $studentId)->first();
                        if ($student) {
                            $name = $student->name;
                        }

                        $individualStatusCounts[$studentId] = [
                            'name' => $name,
                            'มา' => 0,
                            'มาสาย' => 0,
                            'ขาด' => 0,
                            'ลากิจ' => 0,
                            'ลาป่วย' => 0
                        ];
                    }

                    if (!isset($individualStatusCounts[$studentId][$status])) {
                        $individualStatusCounts[$studentId][$status] = 0;
                    }

                    $individualStatusCounts[$studentId][$status]++;
                }
            }
        }

        return $individualStatusCounts;
    }

    private function transformDataForExcel($individualStatusCounts)
    {
        $exportData = collect([]);

        foreach ($individualStatusCounts as $studentId => $statusData) {
            $rowData = [
                'Student ID' => $studentId,
                'Name' => $statusData['name'],
                'มา' => $statusData['มา'] ?? 0,
                'มาสาย' => $statusData['มาสาย'] ?? 0,
                'ขาด' => $statusData['ขาด'] ?? 0,
                'ลากิจ' => $statusData['ลากิจ'] ?? 0,
                'ลาป่วย' => $statusData['ลาป่วย'] ?? 0,
            ];

            $exportData->push($rowData);
        }

        return $exportData;
    }

    public function headings(): array
    {
        return [
            [
                'Student ID',
                'Name',
                'มา',
                'มาสาย',
                'ขาด',
                'ลากิจ',
                'ลาป่วย',
            ]
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $data = $this->collection();  // Get the data from the collection method

                // Auto size columns
                foreach ($data->transpose()->toArray() as $key => $value) {
                    $event->sheet->getColumnDimensionByColumn($key + 1)->setAutoSize(true);
                }

                // Set font style
                $event->sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'name' => 'TH Sarabun new',
                        'size' => 14
                    ]
                ]);

                $rowCount = 2; // Start writing data from the second row (after headings)
                foreach ($data as $row) {
                    foreach ($row as $key => $value) {
                        $event->sheet->setCellValueByColumnAndRow($key + 1, $rowCount, $value);
                    }
                    $rowCount++;
                }
            },
        ];
    }
}
