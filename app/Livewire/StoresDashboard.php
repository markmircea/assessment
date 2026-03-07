<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;

class StoresDashboard extends Component
{
    public $currentBrandId = null;

    protected $queryString = ['currentBrandId' => ['as' => 'brand']];

    public function switchBrand($brandId)
    {
        $this->currentBrandId = $brandId;
    }

    public function clearBrand()
    {
        $this->currentBrandId = null;
    }

    public function render()
    {
        $user = auth()->user();

        $stores = $user->stores()
            ->when($this->currentBrandId, function ($query) {
                $query->where('brand_id', $this->currentBrandId);
            })
            ->with('brand')
            ->withSum('journals', 'revenue')
            ->withSum('journals', 'profit')
            ->get();

        $brands = $user->accessibleBrands()->get();

        $currentBrand = $this->currentBrandId
            ? Brand::find($this->currentBrandId)
            : null;

        return view('livewire.stores-dashboard', [
            'stores' => $stores,
            'brands' => $brands,
            'currentBrand' => $currentBrand,
        ]);
    }
}