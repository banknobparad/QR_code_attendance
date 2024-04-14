<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;



class AttendancExportAll implements FromCollection
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // สร้างข้อมูลปลอมๆ
        $data = [
            ['name' => 'John Doe', 'email' => 'john@example.com', 'attendance' => 'Present'],
            ['name' => 'Jane Doe', 'email' => 'jane@example.com', 'attendance' => 'Absent'],
            // เพิ่มข้อมูลอื่น ๆ ตามต้องการ
        ];

        // ใส่ข้อมูลลงใน Collection
        $collection = new Collection($data);

        // เพิ่ม header และ mapping
        $collection = $collection->map(function ($item) {
            return [
                'Name' => $item['name'],
                'Email' => $item['email'],
                'Attendance' => $item['attendance']
                // เพิ่ม mapping ข้อมูลอื่น ๆ ตามต้องการ
            ];
        });

        return $collection;
    }
}
