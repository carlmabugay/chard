<?php

namespace App\Domain\Strategy\Repositories;

use App\Domain\Strategy\Contracts\StrategyRepositoryInterface;
use App\Domain\Strategy\DTOs\CreateStrategyDTO;
use App\Domain\Strategy\DTOs\DeleteStrategyDTO;
use App\Domain\Strategy\DTOs\ListStrategiesDTO;
use App\Domain\Strategy\DTOs\RestoreStrategyDTO;
use App\Domain\Strategy\DTOs\TrashStrategyDTO;
use App\Domain\Strategy\DTOs\UpdateStrategyDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

class StrategyRepository implements StrategyRepositoryInterface
{
    public function findAll(ListStrategiesDTO $dto): LengthAwarePaginator
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

    /**
     * @throws Throwable
     */
    public function store(CreateStrategyDTO $dto): void
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

    /**
     * @throws Throwable
     */
    public function revise(UpdateStrategyDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('strategies')
                ->where('id', $dto->id)
                ->update([
                    'name' => $dto->name,
                ]);
        }, 2);
    }

    /**
     * @throws Throwable
     */
    public function trash(TrashStrategyDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('strategies')
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
    public function restore(RestoreStrategyDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('strategies')
                ->where('id', $dto->id)
                ->update([
                    'deleted_at' => null,
                ]);
        }, 2);
    }

    /**
     * @throws Throwable
     */
    public function delete(DeleteStrategyDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('strategies')
                ->delete(id: $dto->id);
        }, 2);
    }
}
