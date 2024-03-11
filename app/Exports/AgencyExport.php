<?php

namespace App\Exports;

use App\Models\Agency;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AgencyExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection(): \Illuminate\Database\Eloquent\Collection|Collection
    {
        return Agency::select('keywords', 'agency_id', 'agency_name', 'province_id')->get();
    }

    public function headings(): array
    {
        return [
            'Từ khóa',
            'Mã đại lý',
            'Tên đại lý',
            'Mã tỉnh',
            // Add other Agency fields here...
        ];
    }

    public function title(): string
    {
        return 'Đại lý';
    }
}