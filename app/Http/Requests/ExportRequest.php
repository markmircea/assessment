<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
        ];
    }

    public function after(): array
    {
        return [
            function ($validator) {
                if ($brandId = $this->validated('brand_id')) {
                    if (!$this->user()->stores()->where('brand_id', $brandId)->exists()) {
                        $validator->errors()->add('brand_id', 'You do not have access to this brand.');
                    }
                }
            }
        ];
    }
}
