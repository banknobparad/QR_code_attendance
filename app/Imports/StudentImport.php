<?php

namespace App\Imports;


use App\Models\Stu_list;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class StudentImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $user = User::where('id', auth()->user()->id)->firstOrFail();
        $teacher_id = $user->id;

        $headerRow = $rows->first(); // ดึงแถวแรกของข้อมูล (หัวข้อคอลัมน์)
        $studentIdIndex = $headerRow->search('student_id'); // ค้นหา index ของคอลัมน์ 'student_id'
        $nameIndex = $headerRow->search('name'); // ค้นหา index ของคอลัมน์ 'name'

        if ($studentIdIndex !== false && $nameIndex !== false) {
            // ถ้าเจอทั้งคอลัมน์ 'student_id' และ 'name'
            foreach ($rows->skip(1) as $row) { // ข้ามแถวแรกที่เป็นหัวข้อคอลัมน์
                Stu_list::create([
                    'teacher_id' => $teacher_id,
                    'student_id' => $row[$studentIdIndex], // ใช้ index ของคอลัมน์ 'student_id' ที่หาได้
                    'name' => $row[$nameIndex], // ใช้ index ของคอลัมน์ 'name' ที่หาได้
                ]);
            }
        } else {
            // หากไม่พบคอลัมน์ที่มีชื่อ 'student_id' หรือ 'name'
            // จัดการตามที่คุณต้องการ เช่น โยน error หรือแจ้งเตือนให้ผู้ใช้
        }
    }
}
