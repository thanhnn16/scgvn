<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\EventAgency;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class EventAgenciesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle
{
    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function collection(): Collection
    {
        return $this->event->eventAgencies->map(function (EventAgency $eventAgency) {
            return [
                'keywords' => $eventAgency->agency->keywords,
                'agency_id' => $eventAgency->agency_id,
                'agency_name' => $eventAgency->agency->agency_name,
                'prize_name' => optional($eventAgency->prize)->prize_name,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nhóm từ khoá', 'Mã đại lý', 'Tên đại lý', 'Giải thưởng đã trúng'];
    }

    public function title(): string
    {
        return 'Đại lý';
    }
}