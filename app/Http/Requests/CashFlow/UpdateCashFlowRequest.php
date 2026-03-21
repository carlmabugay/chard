<?php

namespace App\Http\Requests\CashFlow;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCashFlowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'portfolio_id' => 'required|integer|exists:users,id',
            'type' => 'required|string',
            'amount' => 'required|integer',
            'id' => 'required|exists:cash_flows',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
