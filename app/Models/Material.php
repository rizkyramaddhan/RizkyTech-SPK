<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'unit_of_measurement',
        'safety_stock',
        'lead_time_days',
        'notes',
    ];

    public function bomItems() : HasMany
    {
        return $this->hasMany(BomItem::class);
    }
}
