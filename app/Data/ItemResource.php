<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MapInputName(SnakeCaseMapper::class)]
class ItemResource extends Data
{
    public function __construct(
        public string $id,
        public Carbon $createdAt,
        public Carbon $updatedAt,
        public string $name,
        public bool $isConsumable,
        public bool $isLendable,
        public int $amount,
        /** @var string[] */
        public array $tags,
        public ?WarehouseResource $warehouse,
        public ?ItemResource $parent,
    ) {}
}
