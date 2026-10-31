<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReviewLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('laporan'));
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['sometimes', 'in:baru,ditinjau,diteruskan,selesai'],
            'catatan' => ['sometimes', 'nullable', 'string'],
            'ditandai' => ['sometimes', 'boolean'],
            'forwarded_to' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
