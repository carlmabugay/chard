<?php

namespace App\Http\Requests\CashFlow;

use App\Domain\Portfolio\Repositories\PortfolioRepository;
use App\Enums\CashFlowType;
use App\Models\CashFlow;
use App\Models\Portfolio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;

class CreateCashFlowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'portfolio_id' => ['required', 'exists:portfolios,id'],
            'type' => ['required', new Enum(CashFlowType::class)],
            'amount' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function authorize(): bool
    {

        $portfolioData = app(PortfolioRepository::class)->findById($this->portfolio_id);

        $portfolio = Portfolio::fromStdClass($portfolioData);

        return Gate::allows('store', [CashFlow::class, $portfolio]);
    }
}
