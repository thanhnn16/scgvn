<?php

namespace App\Imports;

use App\Models\Agency;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AgenciesImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Agency
    {
//        return new Agency([
//            'agency_id' => $row['ma_dai_ly'],
//            'keywords' => $row['nhom_tu_khoa'],
//            'agency_name' => $row['ten_dai_ly'],
//            'province_id' => $row['ma_tinh'],
//        ]);
        return Agency::updateOrCreate(
            ['agency_id' => $row['ma_dai_ly']],
            [
                'keywords' => $row['nhom_tu_khoa'],
                'agency_name' => $row['ten_dai_ly'],
                'province_id' => $row['ma_tinh'],
            ]
        );
    }
}