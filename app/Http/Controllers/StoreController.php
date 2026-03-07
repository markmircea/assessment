<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function show(Request $request, Store $store)
    {
        if (!$request->user()->stores()->where('stores.id', $store->id)->exists()) {
            abort(403);
        }

        $store->load('brand');
        $journals = $store->journals()->orderByDesc('date')->paginate(30);

        return view('stores.show', compact('store', 'journals'));
    }
}
