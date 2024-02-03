<?php

namespace App\Imports;

use App\Models\User;
use App\Models\StudentInfo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class StudentImport implements ToModel, WithStartRow, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $student = new User;
        $student->username = $row[1];
        $student->name = $row[2];
        $student->gender = $row[3] == 'M' ? 'male' : 'female';
        $student->email = $row[4];
        $student->contact_number = $row[5];
        $student->parent_contact_number = $row[6];
                // school rowm[7]
        $student->status = $row[8];
        $student->password = bcrypt(1234);
        $student->type = 'student';
        $student->branch_id = 1;
        $student->save();

        $studentdata = new StudentInfo;
        $studentdata->user_id = $student->id;
        $studentdata->data = array(
                    'parent_contact_number' => $row[6],
                    'school_name'           => $row[7],
                    'grade'                 => $row[9]
                );
        $studentdata->save();

        return $student;
    }

    
    public function startRow(): int
    {
        return 3;
    }

     public function batchSize(): int
    {
        return 1000;
    }
}
