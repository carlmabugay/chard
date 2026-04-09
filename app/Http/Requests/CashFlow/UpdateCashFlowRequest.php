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
            'type' => ['required', new Enum(CashFlowType::class)],
            'amount' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
