<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BomItem extends Model
{
    protected $fillable = [
        'bom_id',
        'material_id',
        'quantity',
        'unit_of_measurement',
        'note'
    ];

    public function bom() : BelongsTo 
    {
        return $this->belongsTo(Bom::class);    
    }

    public function material() : BelongsTo 
    {
        return $this->belongsTo(Material::class);
    }
}
