<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AgencyProvinceExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Provinces' => new ProvinceExport(),
            'Agencies' => new AgencyExport(),
        ];
    }
}