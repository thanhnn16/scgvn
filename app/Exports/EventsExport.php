<?php
namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Collection;

class EventsExport implements WithMultipleSheets
{
    protected $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function sheets(): array
    {
        return [
            'Event' => new EventExport($this->event),
            'Event Agencies' => new EventAgenciesExport($this->event),
            'Prizes' => new PrizesExport($this->event),
        ];
    }
}