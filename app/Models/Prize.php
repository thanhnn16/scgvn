<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prize extends Model
{
    use HasFactory;

    protected $fillable = [
        'prize_name',
        'prize_qty',
        'prize_desc',
        'event_id'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function eventAgencies(): HasMany
    {
        return $this->hasMany(EventAgency::class, 'prize_id');
    }

    public function agencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class, 'event_agencies', 'prize_id', 'agency_id');
    }

}