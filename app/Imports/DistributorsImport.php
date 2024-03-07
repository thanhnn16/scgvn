<?php

namespace App\Imports;

use App\Models\Distributor;
use App\Models\Prize;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DistributorsImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Distributor
    {
//        return new Distributor([
//            'distributor_name' => $row['npp'],
//            'province_id' => $row['ma_tinh'],
//        ]);
        return Distributor::updateOrCreate(
            ['distributor_name' => $row['npp']],
            [
                'province_id' => $row['ma_tinh'],
            ]
        );
    }
}