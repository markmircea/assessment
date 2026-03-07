<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Mail\ExportReady;
use App\Models\User;

class ExportFinancialData implements ShouldQueue
{
    use Queueable;

    public function __construct(public User $user, public ?int $brandId = null)
    {
        //
    }

    public function handle(): void
    {
        $stores = $this->user->stores()
            ->when($this->brandId, fn($q) => $q->where('brand_id', $this->brandId))
            ->with(['brand', 'journals' => fn($q) => $q->orderBy('date')])
            ->get();

        $filename = 'export_' . $this->user->id . '_' . now()->timestamp . '.csv';
        $dir = storage_path('app/private/exports');

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $file = fopen($dir . '/' . $filename, 'w');
        fputcsv($file, ['Store Number', 'Brand', 'Date', 'Revenue', 'Food Cost', 'Labor Cost', 'Profit']);

        foreach ($stores as $store) {
            foreach ($store->journals as $journal) {
                fputcsv($file, [
                    $store->number,
                    $store->brand->name,
                    $journal->date->format('Y-m-d'),
                    $journal->revenue,
                    $journal->food_cost,
                    $journal->labor_cost,
                    $journal->profit,
                ]);
            }
        }

        fclose($file);

        $downloadUrl = URL::temporarySignedRoute(
            'export.download',
            now()->addHours(24),
            ['path' => $filename]
        );

        Mail::to($this->user)->send(new ExportReady($downloadUrl));
    }
}
