<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Purchases;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $table = 'purchase_items';
    protected $fillable = [
        'purchase_id',
        'item_id',
        'item_unit_type_id',
        'quantity',
        'price_buy',
        'price_sell',
        'price_total',
        'status',
        'note',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchases::class, 'purchase_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function unitType(): BelongsTo
    {
        return $this->belongsTo(ItemUnitType::class, 'item_unit_type_id');
    }
}
