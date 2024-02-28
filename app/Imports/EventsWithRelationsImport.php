<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EventsWithRelationsImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'su_kien' => new EventsImport(),
            'dai_ly' => new AgenciesImport(),
            'phan_thuong' => new PrizesImport(),
        ];
    }
}