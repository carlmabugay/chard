<?php

namespace App\Domain\Portfolio;

use App\Domain\Portfolio\Contracts\PortfolioRepositoryInterface;
use App\Domain\Portfolio\DTOs\ListPortfoliosDTO;
use App\Domain\Portfolio\DTOs\StorePortfolioDTO;
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
}
