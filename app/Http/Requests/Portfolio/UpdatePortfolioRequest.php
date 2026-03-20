<?php

namespace App\Http\Requests\Portfolio;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePortfolioRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'id' => 'required|exists:portfolios,id',
            'name' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
