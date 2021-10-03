<?php

namespace Escritor\Repositories;

use Escritor\Models\Variant;
use Escritor\Models\Product;

class ProductVariantRepository
{
    public function __construct(Variant $model)
    {
        $this->model = $model;
    }

    /**
     * Get all published products.
     *
     * @return Escritor\Models\Variant
     */
    public function getProductVariants($id)
    {
        return $this->model->where('product_id', $id);
    }

    /**
     * Adds variants to the product.
     *
     * @param Escritor\Models\Product $products
     * @param array                 $payload
     * @param Product|ProductRepository|\Illuminate\Support\Collection $product
     *
     * @return Escritor\Models\Variant
     */
    public function addVariant($product, $payload)
    {
        $payload['product_id'] = $product->id;

        return $this->model->create($payload);
    }

    /**
     * Save the variant.
     *
     * @param array $payload
     *
     * @return Escritor\Models\Variant
     */
    public function saveVariant($payload)
    {
        $variant = $this->model->find($payload['id']);

        $variant->key = $payload['key'];
        $variant->value = $payload['value'];

        return $variant->save();
    }

    /**
     * Delete a variant.
     *
     * @param array $payload
     *
     * @return bool
     */
    public function deleteVariant($payload)
    {
        $variant = $this->model->find($payload['id']);

        return $variant->delete($payload);
    }
}
