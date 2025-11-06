<?php

namespace App\Models\Traits;

use Spatie\LaravelData\Data;

trait HasData
{
    protected ?string $resource = null;

    /**
     * @return Data
     */
    public function toData()
    {
        if ($this->resource != null) {
            return $this->resource::from($this);
        }

        $basename = str(get_class($this))->afterLast('\\');
        $clazz = sprintf('App\Data\%sResource', $basename);

        return $clazz::from($this);
    }
}
