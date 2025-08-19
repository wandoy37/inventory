<?php

namespace App\Models;

use App\Models\User;
use App\Models\Vendor;
use App\Models\PurchaseItem;
use App\Models\PurchaseTransfer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchases extends Model
{
    use HasFactory;

    protected $table = 'purchases';
    protected $fillable = [
        'purchase_number',
        'user_id',
        'vendor_id',
        'opname_date',
        'payment_type',
        'payment_total',
        'status'
    ];

    // Generate and set purchase_number otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchase) {
            // Ambil 2 huruf awal nama
            $prefix = 'PO-';

            // Ambil ID terakhir dan random 2 digit
            $lastId = self::max('id') ?? 0;
            $nextId = $lastId + 1;

            $purchase_number = $prefix . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            // Pastikan kode unik
            while (self::where('purchase_number', $purchase_number)->exists()) {
                $purchase_number = $prefix . str_pad($nextId, 2, '0', STR_PAD_LEFT);
            }

            $purchase->purchase_number = $purchase_number;
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id');
    }

    public function transfer(): HasOne
    {
        return $this->hasOne(PurchaseTransfer::class, 'purchase_id');
    }
}
