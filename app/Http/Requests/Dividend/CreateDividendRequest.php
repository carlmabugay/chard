<?php

namespace App\Http\Requests\Dividend;

use Illuminate\Foundation\Http\FormRequest;

class CreateDividendRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'portfolio_id' => ['required', 'exists:portfolios,id'],
            'symbol' => ['required'],
            'amount' => ['required', 'numeric', 'min:1'],
            'recorded_at' => ['required', 'date', 'date_format:Y-m-d H:i:s'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
