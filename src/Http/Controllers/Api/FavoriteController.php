<?php

namespace Escritor\Http\Controllers\Api;

use Illuminate\Http\Request;
use Escritor\Http\Controllers\Controller;
use Escritor\Services\FavoriteService;
use Muleta\Modules\Controllers\Api\ApiControllerTrait;

class FavoriteController extends Controller
{
    use ApiControllerTrait;
    
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->service = $favoriteService;
    }

    /**
     * List all customer favorites
     *
     * @return \Response
     */
    public function all(): \Response
    {
        $items = $this->service->all();

        if (!is_null($items) && $items->count() > 0) {
            return $this->apiResponse('success', $items->pluck('product_id'));
        }

        return $this->apiResponse('success', []);
    }

    /**
     * Add a product to customer favorites
     *
     * @param Request $request
     *
     * @return \Response
     */
    public function add(Request $request): \Response
    {
        $result = $this->service->add($request->productId);

        if ($result) {
            return $this->apiResponse('success', 1);
        }

        return $this->apiResponse('error', 'Could not be added to Favorites');
    }

    /**
     * Remove a product from customer favories
     *
     * @param Request $request
     *
     * @return \Response
     */
    public function remove(Request $request): \Response
    {
        $this->service->remove($request->productId);

        return $this->apiResponse('success', 0);
    }
}
