<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    public function agencies(): HasMany
    {
        return $this->hasMany(Agency::class);
    }

    public function prizes(): HasMany
    {
        return $this->hasMany(Prize::class);
    }
}