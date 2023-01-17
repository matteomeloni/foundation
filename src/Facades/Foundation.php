<?php

namespace Matteomeloni\Foundation\Facades;

use Illuminate\Support\Facades\Facade;

class Foundation extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'foundation';
    }
}
