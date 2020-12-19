<?php

namespace Escritor\Repositories;

use Illuminate\Support\Facades\Schema;
use Escritor\Models\Escritor;
use Escritor\Repositories\FavoriteRepository;

class EscritorRepository
{
    public function __construct(Escritor $product)
    {
        $this->model = $product;
    }
    // Using Aggregate Methods
    // $users = DB::table('users')->count();
    
    // $price = DB::table('orders')->max('price');
    
    // $price = DB::table('orders')->min('price');
    
    // $price = DB::table('orders')->avg('price');
    
    // $total = DB::table('users')->sum('votes');
    /**
     * Returns all Escritors.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    public function allForCustomer(Collections $products, $location = false)
    {
    }

    public function allGroupedByCategory()
    {
        $users = DB::table('users')
            ->orderBy('name', 'desc')
            ->groupBy('count')
            ->having('count', '>', 100)
            ->get();
    }

    /**
     * Get cusomter favorites
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function favorites()
    {
        $favorites = app(FavoriteRepository::class)->all()->pluck('product_id');

        return $this->model->whereIn('id', $favorites)->get();
    }

    /**
     * Returns all paginated Escritor.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function paginated()
    {
        if (isset(request()->dir) && isset(request()->field)) {
            $model = $this->model->orderBy(request()->field, request()->dir);
        } else {
            $model = $this->model->orderBy('created_at', 'desc');
        }

        return $model->paginate(\Illuminate\Support\Facades\Config::get('siravel.pagination', 25));
    }

    /**
     * Search Escritor.
     *
     * @param string $input
     *
     * @return Escritor
     */
    public function search($payload, $paginate)
    {
        $query = $this->model->orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('products');
        $query->where('id', 'LIKE', '%'.$payload.'%');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$payload.'%');
        }

        return $query->paginate($paginate);
    }

    /**
     * Stores Escritor into database.
     *
     * @param array $input
     *
     * @return Escritor
     */
    public function create($input)
    {
        return $this->model->create($input);
    }

    /**
     * Find Escritor by given id.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Escritor
     */
    public function find($id)
    {
        if (!$model = $this->model->find($id)) {
            return abort(404);
        }
        return $model;
    }

    /**
     * Destroy Escritor.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Escritor
     */
    public function destroy($id)
    {
        return $this->model->find($id)->delete();
    }

    /**
     * Updates Escritor in the database.
     *
     * @param int   $id
     * @param array $inputs
     *
     * @return Escritor
     */
    public function update($id, $inputs)
    {
        $product = $this->model->find($id);
        $product->fill($inputs);
        $product->save();

        return $product;
    }

    /*
    |--------------------------------------------------------------------------
    | Store End
    |--------------------------------------------------------------------------
    */

    /**
     * Get all published products.
     *
     * @return
     */
    public function getPublishedEscritors()
    {
        return $this->model->where('is_published', 1);
    }

    /**
     * Find Escritors by URL.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Escritors
     */
    public function findEscritorByURL($url)
    {
        return $this->model->where('url', $url)->where('is_available', 1)->where('is_published', 1)->first();
    }
}
