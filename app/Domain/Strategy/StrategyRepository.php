<?php

namespace App\Domain\Strategy;

use App\Domain\Strategy\Contracts\StrategyRepositoryInterface;
use App\Domain\Strategy\DTOs\StrategyCollectionDTO;
use App\Domain\Strategy\DTOs\StrategyCreationDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class StrategyRepository implements StrategyRepositoryInterface
{
    public function collect(StrategyCollectionDTO $dto): LengthAwarePaginator
    {
        $query = DB::table('strategies');

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
                ['id', 'name', 'created_at'],
                'page',
                $dto->page
            )->withQueryString();
    }

    public function store(StrategyCreationDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('strategies')->insert(
                [
                    'user_id' => $dto->user_id,
                    'name' => $dto->name,
                    'created_at' => now(),
                ]
            );
        }, 2);
    }
}
