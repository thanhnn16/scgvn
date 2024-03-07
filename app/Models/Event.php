<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'content',
        'start_date',
        'end_date',
        'status',
    ];

    public function agencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class, 'event_agencies', 'event_id', 'agency_id');
    }

    public function prizes(): HasMany
    {
        return $this->hasMany(Prize::class);
    }
}