<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use App\Models\Pincodes;


class PincodeImports implements ToModel, WithHeadingRow,WithBatchInserts
{
    public function model(array $row)
    {
       
        return new Pincodes([
            'circle_name' => $row['circle_name'],
            'region_name' => $row['region_name'],
            'division_name' => $row['division_name'],
            'office_name' => $row['office_name'],
            'pincode' => $row['pincode'],
            'officetype' => $row['officetype'],
            'delivery' => $row['delivery'],
            'district' => $row['district'],
            'statename' => $row['statename'],
            
            
        ]);
    }
    public function batchSize(): int
    {
        return 2000;
    }

    public function chunkSize(): int
    {
        return 2000;
    }
}
