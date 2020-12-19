<?php

namespace Escritor\Models;

use Escritor\Models\EscritorModel;
use Escritor\Services\ProductService;


class Variant extends EscritorModel
{
    
    public $table = 'product_variants';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'product_id',
        'key',
        'value',
    ];

    public $rules = [];

    public function getOptionsAttribute()
    {
        return app(ProductService::class)->variantOptions($this);
    }

    public function rawValue($value)
    {
        $valueWithoutParenthesis = preg_replace("/\([^)]+\)/", "", $value);
        $valueWithoutSquareParenthesis = preg_replace("/\[[^)]+\]/", "", $valueWithoutParenthesis);

        return ucfirst($valueWithoutSquareParenthesis);
    }
}
