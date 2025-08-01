<?php

namespace App\Http\Controllers;

use App\Http\Resources\BankAccountCollection;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $bankAccounts = BankAccount::all();
        return response()->json($bankAccounts);
    }
}
