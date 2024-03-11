<?php
namespace App\Exports;

use App\Models\Event;
use App\Models\EventAgency;
use App\Models\Prize;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class EventExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle
{
    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        return collect([
            [
                'id' => $this->event->id,
                'title' => $this->event->title,
                'content' => $this->event->content,
                'start_date' => $this->event->start_date,
                'end_date' => $this->event->end_date,
            ]
        ]);
    }

    public function headings(): array
    {
        return ['Mã sự kiện', 'Tên sự kiện', 'Mô tả sự kiện', 'Ngày Bắt Đầu', 'Ngày Kết Thúc'];
    }

    public function title(): string
    {
        return 'Sự kiện';
    }
}

