<?php

namespace Matteomeloni\Foundation\Traits\Models;

use App\Traits\Models\HasApplicationLog;
use Illuminate\Database\Eloquent\Builder;
use Matteomeloni\LaravelRestQl\Traits\HasFilterableScope;
use Matteomeloni\LaravelRestQl\Traits\HasSearchable;
use Matteomeloni\LaravelRestQl\Traits\HasSelectableColumnsScope;
use Matteomeloni\LaravelRestQl\Traits\HasSortableScope;
use Matteomeloni\LaravelRestQl\Traits\HasTextSearchScope;

trait HasBaseModel
{
    use HasSelectableColumnsScope,
        HasFilterableScope,
        HasSearchable,
        HasSortableScope,
        HasTextSearchScope;

    /**
     * @param Builder $builder
     * @param array $params
     * @return Builder
     */
    public function scopeRestQL(Builder $builder, array $params = []): Builder
    {
        return $builder
            ->chooseColumns($params['columns'] ?? null)
            ->filter($params['filters'] ?? null)
            ->sort($params['sorts'] ?? null)
            ->textSearch($params['search'] ?? null);
    }
}
