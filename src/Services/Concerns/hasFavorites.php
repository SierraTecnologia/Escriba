<?php

namespace Escritor\Services\Concerns;

use Escritor\Models\Favorite;
use Escritor\Models\Product;

trait hasFavorites
{
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * The products that the user has favourited
     *
     * @return Collection
     */
    public function favouriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id');
    }
}
