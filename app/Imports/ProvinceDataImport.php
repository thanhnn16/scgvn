<?php

namespace App\Imports;

use App\Models\EventAgency;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProvinceDataImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'tinh' => new ProvincesImport(),
            'dai_ly' => new AgenciesImport(),
            'npp' => new DistributorsImport(),
        ];
    }
}