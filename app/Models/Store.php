<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['brand_id', 'number', 'address', 'city', 'state', 'zip_code'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
