<?php

namespace Escritor\Http\Controllers;

use Illuminate\Http\Request;
use Escritor\Http\Controllers\Controller;
use Escritor\Services\CartService;
use Muleta\Services\RiCaResponseService;
use Redirect;
use StoreHelper;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService, RiCaResponseService $siravelResponseService)
    {
        $this->cart = $cartService;
        $this->responseService = $siravelResponseService;
    }

    /**
     * Show the cart contents
     *
     * @return Illuminate\Http\Response
     */
    public function getContents()
    {
        $products = $this->cart->contents();

        return view('escritor::cart.all')->with('products', $products);
    }

    /**
     * Empty the contents of the cart
     *
     * @return Illuminate\Http\Response
     */
    public function emptyCart()
    {
        $this->cart->emptyCart();

        return Redirect::back();
    }
}
