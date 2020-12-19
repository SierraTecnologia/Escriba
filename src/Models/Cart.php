<?php

namespace Escritor\Models;

use Escritor\Models\EscritorModel;


class Cart extends EscritorModel
{
    
    public $table = 'cart';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'user_id',
        'entity_id',
        'entity_type',
        'address',
        'product_variants',
        'quantity',
    ];

    public $rules = [];
}
