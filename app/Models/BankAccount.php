<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $table = 'bank_accounts';
    protected $fillable = [
        'account_number',
        'account_name',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d H;i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];
}
