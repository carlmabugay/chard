<?php

namespace App\Http\Requests\TradeLog;

use App\Domain\Portfolio\Repositories\PortfolioRepository;
use App\Models\Portfolio;
use App\Models\TradeLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

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
        $portfolioData = app(PortfolioRepository::class)->findById($this->portfolio_id);

        $portfolio = Portfolio::fromStdClass($portfolioData);

        return Gate::allows('store', [TradeLog::class, $portfolio]);
    }
}
