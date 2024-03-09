<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventAgency extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'agency_id',
        'prize_id',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'agency_id');
    }

    public function prize(): BelongsTo
    {
        return $this->belongsTo(Prize::class, 'prize_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
}
