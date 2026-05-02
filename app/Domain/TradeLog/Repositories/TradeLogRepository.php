<?php

namespace App\Domain\TradeLog\Repositories;

use App\Domain\TradeLog\Contracts\TradeLogRepositoryInterface;
use App\Domain\TradeLog\DTOs\ListTradeLogsDTO;
use App\Domain\TradeLog\DTOs\StoreTradeLogDTO;
use App\Domain\TradeLog\DTOs\TrashTradeLogDTO;
use App\Domain\TradeLog\DTOs\UpdateTradeLogDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

class TradeLogRepository implements TradeLogRepositoryInterface
{
    public function findAll(ListTradeLogsDTO $dto): LengthAwarePaginator
    {
        $query = DB::table('trade_logs')
            ->whereNull('deleted_at');

        $search = $dto->search;

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('symbol', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhere('shares', 'like', "%{$search}%")
                    ->orWhere('fees', 'like', "%{$search}%");
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
    public function store(StoreTradeLogDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('trade_logs')
                ->insert([
                    'portfolio_id' => $dto->portfolio_id,
                    'symbol' => $dto->symbol,
                    'type' => $dto->type,
                    'price' => $dto->price,
                    'shares' => $dto->shares,
                    'fees' => $dto->fees,
                ]);
        }, 2);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateTradeLogDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('trade_logs')
                ->where('id', $dto->id)
                ->update([
                    'portfolio_id' => $dto->portfolio_id,
                    'symbol' => $dto->symbol,
                    'type' => $dto->type,
                    'price' => $dto->price,
                    'shares' => $dto->shares,
                    'fees' => $dto->fees,
                ]);
        }, 2);
    }

    /**
     * @throws Throwable
     */
    public function trash(TrashTradeLogDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('trade_logs')
                ->where('id', $dto->id)
                ->whereNull('deleted_at')
                ->update([
                    'deleted_at' => now(),
                ]);
        }, 2);
    }
}
