<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStrategyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|exists:strategies,id',
            'name' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
