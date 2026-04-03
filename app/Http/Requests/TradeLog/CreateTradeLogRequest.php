<?php

namespace App\Http\Requests\TradeLog;

use Illuminate\Foundation\Http\FormRequest;

class CreateTradeLogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'portfolio_id' => ['required', 'integer', 'exists:portfolios,id'],
            'symbol' => ['required', 'string'],
            'type' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'shares' => ['required', 'integer', 'min:0'],
            'fees' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
