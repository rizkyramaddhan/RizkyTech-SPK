<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['sku', 'name', 'description', 'type', 'lead_time_days', 'cycle_time_minutes'];
    public function boms(): HasMany
    {
        return $this->hasMany(Bom::class);
    }

    public function activeBom()
    {
        return $this->hasOne(Bom::class)->where('active', true);
    }
}
