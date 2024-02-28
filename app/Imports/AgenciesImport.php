<?php

namespace App\Imports;

use App\Models\Agency;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AgenciesImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Agency
    {
        return new Agency([
            'keywords' => $row['nhom_tu_khoa'],
            'agency_id' => $row['ma_dai_ly'],
            'agency_name' => $row['ten_dai_ly'],
            'province' => $row['tinh'],
            'district' => $row['huyen'],
            'event_id' => $row['id_su_kien'],
        ]);
    }
}