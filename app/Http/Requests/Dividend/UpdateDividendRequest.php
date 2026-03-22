<?php

namespace App\Http\Requests\Dividend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDividendRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'portfolio_id' => ['required', 'integer', 'exists:portfolios,id'],
            'symbol' => ['required', 'string'],
            'amount' => ['required', 'integer', 'min:1'],
            'id' => ['required', 'integer', 'exists:dividends,id'],
            'recorded_at' => ['required', 'date', 'date_format:Y-m-d H:i:s'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
