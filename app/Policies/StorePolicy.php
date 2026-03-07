<?php

namespace App\Policies;

use App\Models\Store;
use App\Models\User;

class StorePolicy
{
    public function view(User $user, Store $store): bool
    {
        return $user->stores()->where('stores.id', $store->id)->exists();
    }
}
