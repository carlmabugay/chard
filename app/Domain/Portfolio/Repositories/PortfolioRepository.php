<?php

namespace App\Domain\Portfolio\Repositories;

use App\Domain\Portfolio\Contracts\PortfolioRepositoryInterface;
use App\Domain\Portfolio\DTOs\ListPortfoliosDTO;
use App\Domain\Portfolio\DTOs\RestorePortfolioDTO;
use App\Domain\Portfolio\DTOs\StorePortfolioDTO;
use App\Domain\Portfolio\DTOs\TrashPortfolioDTO;
use App\Domain\Portfolio\DTOs\UpdatePortfolioDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PortfolioRepository implements PortfolioRepositoryInterface
{
    public function findAll(ListPortfoliosDTO $dto): LengthAwarePaginator
    {
        $query = DB::table('portfolios')->whereNull('deleted_at');

        $search = $dto->search;

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        return $query
            ->orderBy($dto->sort_by, $dto->sort_direction)
            ->paginate(
                $dto->per_page,
                ['id', 'name', 'created_at', 'updated_at'],
                'page',
                $dto->page
            )->withQueryString();
    }

    public function store(StorePortfolioDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('portfolios')->insert([
                'user_id' => $dto->user_id,
                'name' => $dto->name,
            ]);
        }, 2);
    }

    public function update(UpdatePortfolioDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('portfolios')
                ->where('id', $dto->id)
                ->update([
                    'name' => $dto->name,
                ]);
        }, 2);
    }

    public function trash(TrashPortfolioDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('portfolios')
                ->where('id', $dto->id)
                ->whereNull('deleted_at')
                ->update([
                    'deleted_at' => now(),
                ]);
        }, 2);
    }

    public function restore(RestorePortfolioDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('portfolios')
                ->where('id', $dto->id)
                ->update([
                    'deleted_at' => null,
                ]);
        }, 2);
    }
}
