<?php

namespace Matteomeloni\Foundation\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Matteomeloni\LaravelRestQl\LaravelRestQl;

abstract class Model extends LaravelRestQl
{
    use SoftDeletes;
}
