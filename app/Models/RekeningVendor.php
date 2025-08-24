<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RekeningVendor extends Model
{
    use HasFactory;

    protected $table = 'rekening_vendors';
    protected $fillable = [
        'vendor_id',
        'bank_name',
        'rekening_number',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function transfer(): HasMany
    {
        return $this->hasMany(PurchaseTransfer::class, 'rekening_vendor_id');
    }
}
