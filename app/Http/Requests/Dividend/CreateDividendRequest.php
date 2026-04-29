<?php

namespace App\Http\Requests\Dividend;

use App\Domain\Portfolio\Repositories\PortfolioRepository;
use App\Models\Dividend;
use App\Models\Portfolio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreateDividendRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'portfolio_id' => ['required', 'exists:portfolios,id'],
            'symbol' => ['required'],
            'amount' => ['required', 'numeric', 'min:1'],
            'recorded_at' => ['required', 'date', 'date_format:Y-m-d H:i:s'],
        ];
    }

    public function authorize(): bool
    {
        $portfolioData = app(PortfolioRepository::class)->findById($this->portfolio_id);

        $portfolio = Portfolio::fromStdClass($portfolioData);

        return Gate::allows('store', [Dividend::class, $portfolio]);
    }
}
