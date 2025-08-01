<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BankAccount::create([
            'account_number' => '027168168',
            'account_name' => 'BCA',
        ]);

        BankAccount::create([
            'account_number' => '027192192',
            'account_name' => 'BNI',
        ]);
    }
}
