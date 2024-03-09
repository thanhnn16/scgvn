<?php

namespace App\Exports;
use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Excel;

class EventsExport implements FromCollection
{
    public function collection(): Collection
    {
        return Event::all();
    }

    public function headings(): array
    {
        return [
            'Mã sự kiện',
            'Tiêu đề',
            'Nội dung',
            'Ngày bắt đầu',
            'Ngày kết thúc',
            'Trạng thái',
        ];
    }

    public function map($event): array
    {
        return [
            $event->id,
            $event->title,
            $event->content,
            $event->start_date,
            $event->end_date,
            $event->status,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => 'dd/mm/yyyy',
            'E' => 'dd/mm/yyyy',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:F1')->getFont()->setBold(true);
            },
        ];
    }

    public function title(): string
    {
        return 'Events';
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function fileName(): string
    {
        return 'events.xlsx';
    }

    public function exportType(): string
    {
        return Excel::XLSX;
    }


}