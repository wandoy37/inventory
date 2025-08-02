<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::orderBy('id', 'DESC')->paginate(10);
        return view('item.index', compact('items'));
    }
}
