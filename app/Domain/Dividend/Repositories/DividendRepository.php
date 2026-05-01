<?php

namespace App\Domain\Dividend\Repositories;

use App\Domain\Dividend\Contracts\DividendRepositoryInterface;
use App\Domain\Dividend\DTOs\ListDividendsDTO;
use App\Domain\Dividend\DTOs\RestoreDividendDTO;
use App\Domain\Dividend\DTOs\StoreDividendDTO;
use App\Domain\Dividend\DTOs\TrashDividendDTO;
use App\Domain\Dividend\DTOs\UpdateDividendDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

class DividendRepository implements DividendRepositoryInterface
{
    public function findAll(ListDividendsDTO $dto): LengthAwarePaginator
    {
        $query = DB::table('dividends')
            ->whereNull('deleted_at');

        $search = $dto->search;

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('symbol', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%");
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
    public function store(StoreDividendDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('dividends')->insert([
                'portfolio_id' => $dto->portfolio_id,
                'symbol' => $dto->symbol,
                'amount' => $dto->amount,
                'recorded_at' => $dto->recorded_at,
            ]);
        }, 2);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateDividendDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('dividends')
                ->where('id', $dto->id)
                ->update([
                    'portfolio_id' => $dto->portfolio_id,
                    'symbol' => $dto->symbol,
                    'amount' => $dto->amount,
                ]);
        }, 2);
    }

    /**
     * @throws Throwable
     */
    public function trash(TrashDividendDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('dividends')
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
    public function restore(RestoreDividendDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('dividends')
                ->where('id', $dto->id)
                ->whereNotNull('deleted_at')
                ->update([
                    'deleted_at' => null,
                ]);
        }, 2);
    }
}
