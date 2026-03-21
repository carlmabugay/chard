<?php

namespace App\Http\Requests\CashFlow;

use App\Enums\CashFlowType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateCashFlowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'portfolio_id' => 'required|integer|exists:users,id',
            'type' => ['required', new Enum(CashFlowType::class)],
            'amount' => 'required|integer',
            'id' => 'required|exists:cash_flows',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
