<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'province'
    ];

    public function distributors(): HasMany
    {
        return $this->hasMany(Distributor::class);
    }

    public function agencies(): HasMany
    {
        return $this->hasMany(Agency::class, 'province_id');
    }
}
