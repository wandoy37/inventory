<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Resources\ItemResource;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        return view('item.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            // Tambahkan created_at jika ingin digunakan
            $items = Item::select(['id', 'code', 'name', 'description', 'created_at']);

            return DataTables::of($items)
                ->addIndexColumn() // Untuk kolom NO auto increment
                ->addColumn('action', function ($item) {
                    return '<button class="btn btn-primary btn-sm" onclick="editItem(' . $item->id . ')">Edit</button> 
                        <button class="btn btn-danger btn-sm" onclick="deleteItem(' . $item->id . ')">Delete</button>';
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? $item->created_at->format('d-m-Y H:i:s') : '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
