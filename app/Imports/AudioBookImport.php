<?php

namespace App\Imports;

use App\Models\AudioBook;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class AudioBookImport implements ToModel, WithStartRow, WithMultipleSheets, WithBatchInserts, WithChunkReading 
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AudioBook([
            'book_number'           => $row[0],
            'title'                 => $row[3],
            'type'                  => $row[1],
            'type_name'             => $row[2],
            'ar_level'              => $row[4],
            'thumbnail_source_type' => 'link',
            'thumbnail_source'      => $row[5],
            'source_folder'         => $row[6] ?? str_replace(' ', '_', strtolower($row[3])),
            'source_type'           => $row[7],
            'branch_id'             => request()->user()->branch_id,
        ]);
    }

    public function startRow(): int
    {
        return 3;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
