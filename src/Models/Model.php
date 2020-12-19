<?php

namespace Escritor\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Model extends EloquentModel
{

    public function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes);
    }

    public static function boot()
    {
        parent::boot();
    }
}