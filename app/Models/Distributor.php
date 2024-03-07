<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Distributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'distributor_name',
        'province_id'
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
