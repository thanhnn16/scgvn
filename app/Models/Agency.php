<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agency extends Model
{
    use HasFactory;


    protected $fillable = [
        'keywords',
        'agency_id',
        'agency_name',
        'province_id',
        'event_id',
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_agencies', 'agency_id', 'event_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function prizes(): BelongsToMany
    {
        return $this->belongsToMany(Prize::class, 'event_agencies', 'prize_id');
    }

    public function eventAgencies(): HasMany
    {
        return $this->hasMany(EventAgency::class, 'agency_id', 'agency_id');
    }

    public function getRouteKeyName(): string
    {
        return 'agency_id';
    }
}