<?php

namespace App\Imports;

use App\Models\Prize;
use App\Models\Province;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProvincesImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Province
    {
//        $province = new Province([
//            'id' => $row['ma_tinh'],
//            'province' => $row['ten_tinh'],
//        ]);
//
//        $province->save();
//
//        return $province;
        return Province::updateOrCreate(
            ['id' => $row['ma_tinh']],
            [
                'province' => $row['ten_tinh'],
            ]
        );
    }
}