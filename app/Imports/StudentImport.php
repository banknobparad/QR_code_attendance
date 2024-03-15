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

        foreach ($rows as $row) 
        {
            Stu_list::create([
                'teacher_id' => $teacher_id,
                'student_id' => $row[0],
                'name' => $row[1],
            ]);
        }
    }
}
