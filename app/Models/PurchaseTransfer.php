<?php

namespace App\Models;

use App\Models\Purchases;
use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseTransfer extends Model
{
    use HasFactory;

    protected $table = 'purchase_transfers';
    protected $fillable = [
        'purchase_id',
        'bank_id',
        'bank_origin',
        'reference_number',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchases::class, 'purchase_id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class, 'bank_id');
    }
}
