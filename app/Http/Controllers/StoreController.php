<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    use AuthorizesRequests;

    public function show(Request $request, Store $store)
    {
        $this->authorize('view', $store);

        $store->load('brand');
        $journals = $store->journals()->orderByDesc('date')->paginate(30);

        return view('stores.show', compact('store', 'journals'));
    }
}
