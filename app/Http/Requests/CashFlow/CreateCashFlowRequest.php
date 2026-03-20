<?php

namespace App\Http\Requests\CashFlow;

use Illuminate\Foundation\Http\FormRequest;

class CreateCashFlowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'portfolio_id' => 'required|integer|exists:portfolios,id',
            'type' => 'required',
            'amount' => 'required|integer',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
