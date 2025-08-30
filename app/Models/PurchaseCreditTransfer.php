<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseCreditTransfer extends Model
{
    use HasFactory;

    protected $table = 'purchase_credit_transfers';
    protected $fillable = [
        'purchase_credit_id',
        'bank_id',
        'rekening_vendor_id',
        'reference_number',
    ];

    public function purchaseCredit(): BelongsTo
    {
        return $this->belongsTo(PurchaseCredit::class. 'purchase_credit_id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class, 'bank_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(RekeningVendor::class, 'rekening_vendor_id');
    }
}
