<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MapInputName(SnakeCaseMapper::class)]
class UserResource extends Resource
{
    public function __construct(
        public int $id,
        public Carbon $createdAt,
        public Carbon $updatedAt,
        public string $name,
        public ?string $email,
        public ?Carbon $emailVerifiedAt,
        public ?string $provider,
        public bool $isExternal,
    ) {}
}
