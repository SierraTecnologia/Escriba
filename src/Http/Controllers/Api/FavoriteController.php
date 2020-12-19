<?php

namespace Escritor\Http\Controllers\Api;

use Illuminate\Http\Request;
use Escritor\Http\Controllers\Controller;
use Escritor\Services\FavoriteService;
use Muleta\Services\RiCaResponseService;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService, RiCaResponseService $siravelResponseService)
    {
        $this->service = $favoriteService;
        $this->responseService = $siravelResponseService;
    }

    /**
     * List all customer favorites
     *
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $items = $this->service->all();

        if (!is_null($items) && $items->count() > 0) {
            return $this->responseService->apiResponse('success', $items->pluck('product_id'));
        }

        return $this->responseService->apiResponse('success', []);
    }

    /**
     * Add a product to customer favorites
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $result = $this->service->add($request->productId);

        if ($result) {
            return $this->responseService->apiResponse('success', 1);
        }

        return $this->responseService->apiResponse('error', 'Could not be added to Favorites');
    }

    /**
     * Remove a product from customer favories
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
        $this->service->remove($request->productId);

        return $this->responseService->apiResponse('success', 0);
    }
}
