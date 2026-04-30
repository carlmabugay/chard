<?php

namespace App\Domain\CashFlow\Repositories;

use App\Domain\CashFlow\Contracts\CashFlowRepositoryInterface;
use App\Domain\CashFlow\DTOs\ListCashFlowsDTO;
use App\Domain\CashFlow\DTOs\RestoreCashFlowDTO;
use App\Domain\CashFlow\DTOs\StoreCashFlowDTO;
use App\Domain\CashFlow\DTOs\TrashCashFlowDTO;
use App\Domain\CashFlow\DTOs\UpdateCashFlowDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

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

    /**
     * @throws Throwable
     */
    public function store(StoreCashFlowDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('cash_flows')->insert([
                'portfolio_id' => $dto->portfolio_id,
                'type' => $dto->type,
                'amount' => $dto->amount,
            ]);
        }, 2);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateCashFlowDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('cash_flows')
                ->where('id', $dto->id)
                ->update([
                    'portfolio_id' => $dto->portfolio_id,
                    'type' => $dto->type,
                    'amount' => $dto->amount,
                ]);
        }, 2);
    }

    /**
     * @throws Throwable
     */
    public function trash(TrashCashFlowDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('cash_flows')
                ->where('id', $dto->id)
                ->whereNull('deleted_at')
                ->update([
                    'deleted_at' => now(),
                ]);
        }, 2);
    }

    /**
     * @throws Throwable
     */
    public function restore(RestoreCashFlowDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('cash_flows')
                ->where('id', $dto->id)
                ->whereNotNull('deleted_at')
                ->update([
                    'deleted_at' => null,
                ]);
        }, 2);
    }
}
