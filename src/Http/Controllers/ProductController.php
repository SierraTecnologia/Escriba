<?php

namespace Escritor\Http\Controllers;

use Escritor\Http\Controllers\Controller;
use Escritor\Repositories\ProductRepository;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
    }

    /**
     * Display all product entries.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $products = $this->repository->getPublishedProducts()->paginate(25);

        if (empty($products)) {
            abort(404);
        }

        return view('escritor::products.all')->with('products', $products);
    }

    /**
     * Display the specified product.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $product = $this->repository->findProductByURL($url);

        if (empty($product)) {
            abort(404);
        }

        return view('escritor::products.show')->with('product', $product);
    }

    /**
     * Display the customer favorite products.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function favorites()
    {
        $products = $this->repository->favorites();

        return view('escritor::products.favorites')->with('products', $products);
    }
}
