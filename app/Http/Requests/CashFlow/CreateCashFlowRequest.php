<?php

namespace App\Http\Requests\CashFlow;

use App\Enums\CashFlowType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateCashFlowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'portfolio_id' => 'required|integer|exists:portfolios,id',
            'type' => ['required', new Enum(CashFlowType::class)],
            'amount' => 'required|integer',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
