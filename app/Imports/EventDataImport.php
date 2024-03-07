<?php

namespace App\Imports;

use App\Models\EventAgency;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EventDataImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'su_kien' => new EventsImport(),
            'phan_thuong' => new PrizesImport(),
            'dai_ly_tham_gia' => new EventAgenciesImport(),
        ];
    }
}