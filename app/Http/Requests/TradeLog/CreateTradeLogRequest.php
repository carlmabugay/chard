<?php

namespace App\Http\Requests\TradeLog;

use Illuminate\Foundation\Http\FormRequest;

class CreateTradeLogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'portfolio_id' => ['required', 'exists:portfolios,id'],
            'symbol' => ['required'],
            'type' => ['required', 'in:buy,sell'],
            'price' => ['required', 'numeric', 'min:1'],
            'shares' => ['required', 'numeric', 'min:1'],
            'fees' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
