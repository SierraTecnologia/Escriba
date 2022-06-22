<?php

namespace Escritor\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Escritor;
use Escritor\Http\Controllers\SitecController;
use Escritor\Models\Products;
use Escritor\Repositories\ProductRepository;
use Escritor\Repositories\ProductVariantRepository;
use Response;

class ProductVariantController extends SitecController
{
    /**
     * Product Repository.
     *
     * @var Escritor\Repositories\ProductRepository
     */
    public $productRepository;

    /**
     * Product Variant Repository.
     *
     * @var Escritor\Repositories\ProductVariantRepository
     */
    public $productVariantRepository;

    public function __construct(
        ProductVariantRepository $productVariantRepository,
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
    }

    /**
     * Get a product's variants.
     *
     * @param int                     $id
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function variants($id, Request $request)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Escritor::notification('Product not found', 'warning');

            return redirect(route('admin.escritor.products.index'));
        }

        if ($this->productVariantRepository->addVariant($product, $request->all())) {
            Escritor::notification('Variant successfully added.', 'success');
        } else {
            Escritor::notification('Failed to add variant. Missing Key or Value.', 'warning');
        }

        return redirect(route('admin.escritor.products.edit', $id).'?tab=variants');
    }

    /**
     * Save a variant.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function saveVariant(Request $request)
    {
        $this->productVariantRepository->saveVariant($request->all());

        return Response::json(['success']);
    }

    /**
     * Delete a variant.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteVariant(Request $request)
    {
        $this->productVariantRepository->deleteVariant($request->all());

        return Response::json(['success']);
    }
}
