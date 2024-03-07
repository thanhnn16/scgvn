<?php

namespace App\Imports;

use App\Models\Prize;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PrizesImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Prize
    {
        return Prize::updateOrCreate(
            ['prize_name' => $row['ten_giai_thuong']],
            [
                'prize_qty' => $row['so_luong'],
                'prize_desc' => $row['mo_ta'],
                'event_id' => $row['ma_su_kien']
            ]
        );
    }
}