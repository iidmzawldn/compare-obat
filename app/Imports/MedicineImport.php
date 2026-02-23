<?php

namespace App\Imports;

use App\Models\Medicine;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MedicineImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return Medicine::updateOrCreate(
            ['code' => $row['code']],
            [
                'name' => $row['name'],
                'category' => $row['category'],
                'unit' => $row['unit'],
                'status' => $row['status'] ?? 1,
            ]
        );
    }
}
