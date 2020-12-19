<?php

namespace Escritor\Models;

use Escritor\Models\EscritorModel;
use Escritor\Models\Product;


class Favorite extends EscritorModel
{
    
    public $table = 'favorites';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'product_id',
        'user_id',
    ];

    /**
     * Get the corresponding Product
     *
     * @return Relationship
     */
    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
