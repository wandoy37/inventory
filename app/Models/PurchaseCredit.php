<?php

namespace App\Models;

use App\Models\Purchases;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseCredit extends Model
{
    use HasFactory;

    protected $table = 'purchase_credits';
    protected $fillable = [
        'purchase_id',
        'repayment_date',
        'payment_type',
        'status',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchases::class, 'purchase_id');
    }
}
