<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemUnitType extends Model
{
    use HasFactory;

    protected $table = 'item_unit_types';
    protected $fillable = [
        'item_id',
        'name',
        'quantity',
        'price_buy',
        'price_sell',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
