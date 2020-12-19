<?php

namespace Escritor\Http\Requests;

use Escritor\Models\Product;

class ProductRequest extends EscritorRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return app(Product::class)->rules;
    }
}
