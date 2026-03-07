<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExportRequest;
use App\Jobs\ExportFinancialData;

class ExportController extends Controller
{
    public function store(ExportRequest $request)
    {
        ExportFinancialData::dispatch(
            $request->user(),
            $request->validated('brand_id')
        );

        return back()->with('success', 'Export started! You\'ll receive an email with the download link shortly.');
    }

    public function download(Request $request, string $path)
    {
        if (!$request->hasValidSignature()) {
            abort(403);
        }

        $fullPath = storage_path('app/private/exports/' . basename($path));

        if (!file_exists($fullPath)) {
            abort(404);
        }

        return response()->download($fullPath);
    }
}
