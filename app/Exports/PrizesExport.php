<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\Prize;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PrizesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle
{
    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function collection(): Collection
    {
        return $this->event->prizes->map(function (Prize $prize) {
            $agency_names = optional($prize->eventAgencies)->pluck('agency.agency_name')->implode("\r\n");
            return [
                'prize_name' => $prize->prize_name,
                'prize_desc' => $prize->prize_desc,
                'prize_qty' => $prize->prize_qty,
                'agency_name' => $agency_names ?? 'Chưa có đại lý nào trúng giải',
            ];
        });
    }

    public function headings(): array
    {
        return ['Tên giải thưởng', 'Mô tả', 'Số lượng', 'Đại lý đã trúng giải'];
    }

    public function title(): string
    {
        return 'Giải thưởng';
    }
}