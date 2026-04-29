<?php

namespace App\Domain\CashFlow\Repositories;

use App\Domain\CashFlow\Contracts\CashFlowRepositoryInterface;
use App\Domain\CashFlow\DTOs\ListCashFlowsDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CashFlowRepository implements CashFlowRepositoryInterface
{
    public function findAll(ListCashFlowsDTO $dto): LengthAwarePaginator
    {
        $query = DB::table('cash_flows')
            ->whereNull('cash_flows.deleted_at');

        $search = $dto->search;

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('cash_flows.type', 'like', "%{$search}%")
                    ->orWhere('cash_flows.amount', 'like', "%{$search}%");
            });
        }

        return $query
            ->orderBy($dto->sort_by, $dto->sort_direction)
            ->paginate(
                $dto->per_page,
                ['*'],
                'page',
                $dto->page
            )->withQueryString();
    }
}
