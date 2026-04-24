<?php

namespace App\Domain\Strategy\Services;

use App\Application\Strategy\DTOs\StrategyDTO;
use App\Domain\Common\Query\QueryCriteria;
use App\Domain\Strategy\Contracts\Persistence\Read\StrategyReadRepositoryInterface;
use App\Domain\Strategy\Contracts\Persistence\Write\StrategyWriteRepositoryInterface;
use App\Domain\Strategy\Contracts\Services\StrategyServiceInterface;
use App\Domain\Strategy\DTOs\StrategyCollectionDTO;
use App\Domain\Strategy\DTOs\StrategyCreationDTO;
use App\Domain\Strategy\Entities\Strategy;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class StrategyService implements StrategyServiceInterface
{
    public function __construct(
        private readonly StrategyWriteRepositoryInterface $write_repository,
        private readonly StrategyReadRepositoryInterface $read_repository,
    ) {}

    public function findAll(QueryCriteria $criteria): array
    {
        return $this->read_repository->findAll($criteria);
    }

    public function findById(int $id): Strategy
    {
        return $this->read_repository->findById($id);
    }

    public function store(StrategyDTO $dto): Strategy
    {
        return $this->write_repository->store($dto);
    }

    public function trash(StrategyDTO $dto): ?bool
    {
        return $this->write_repository->trash($dto);
    }

    public function restore(StrategyDTO $dto): ?bool
    {
        return $this->write_repository->restore($dto);
    }

    public function delete(StrategyDTO $dto): ?bool
    {
        return $this->write_repository->delete($dto);
    }

    public function collect(StrategyCollectionDTO $dto): LengthAwarePaginator|AbstractPaginator
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

    public function save(StrategyCreationDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            DB::table('strategies')->insert(
                [
                    'user_id' => $dto->user_id,
                    'name' => $dto->name,
                    'created_at' => now(),
                ]
            );
        });
    }
}
