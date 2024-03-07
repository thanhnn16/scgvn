<?php

namespace App\Imports;

use App\Models\EventAgency;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EventAgenciesImport implements ToModel, WithHeadingRow
{

    public function model(array $row): EventAgency
    {
        return EventAgency::updateOrCreate(
            ['event_id' => $row['ma_su_kien'], 'agency_id' => $row['ma_dai_ly']],
            []
        );
    }
}