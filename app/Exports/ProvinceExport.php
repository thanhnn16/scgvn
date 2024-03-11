<?php

namespace App\Exports;

use App\Models\Province;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProvinceExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection(): \Illuminate\Database\Eloquent\Collection|Collection
    {
        return Province::select('id', 'province')->get();
    }

    public function headings(): array
    {
        return [
            'Mã tỉnh',
            'Tên tỉnh',
        ];
    }

    public function title(): string
    {
        return 'Tỉnh/Thành phố';
    }
}