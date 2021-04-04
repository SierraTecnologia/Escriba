<?php

namespace Escritor\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Escritor;
use Escritor\Http\Controllers\SitecController;
use Escritor\Http\Requests\ProductRequest;
// use MediaManager\Repositories\ImageRepository;
use Escritor\Repositories\ProductVariantRepository;
use Escritor\Services\ProductService;

class ProductController extends SitecController
{
    public function __construct(
        ProductService $productService,
        ProductVariantRepository $productVariantRepository
        // ImageRepository $imageRepository
    ) {
        $this->service = $productService;
        $this->productVariantRepository = $productVariantRepository;
        // $this->imageRepository = $imageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->service->paginated();

        return view('escritor::admin.products.index')
            ->with('pagination', $products->render())
            ->with('products', $products);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $products = $this->service->search($request->term);

        return view('escritor::admin.products.index')
            ->with('term', $request->term)
            ->with('pagination', $products->render())
            ->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('escritor::admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\ProductRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $result = $this->service->create($request->except('_token'));

        if ($result) {
            return redirect(config('escritor.admin-route-prefix', 'admin').'/products/'.$result->id.'/edit')->with('success', 'Successfully created');
        }

        return redirect(config('escritor.admin-route-prefix', 'admin').'/products')->with('error', 'Failed to create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $tabs = [];
        $product = $this->service->find($id);

        $productVariants = $this->productVariantRepository->getProductVariants($product->id)->get();
        $images = $product->images;

        if (empty($request->all())) {
            $tabs['details'] = true;
        }

        $data = [
            'product' => $product,
            'productVariants' => $productVariants,
            'images' => $images,
            'tabs' => $tabs,
        ];

        return view('escritor::admin.products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\ProductRequest $request
     * @param int                             $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $result = $this->service->update($id, $request->except(['_token', '_method']));

        if ($result) {
            return back()->with('success', 'Successfully updated');
        }

        return back()->with('error', 'Failed to update');
    }

    /**
     * Add images to a product
     *
     * @param \Illuminate\Http\ProductRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function setImages(Request $request)
    {
        dd('EscritoeProducts',
            $request->all()
        );


        foreach ($request->location as $location) {
            $result = $this->imageRepository->store(
                [
                'entity_id' => $request->product_id,
                'location' => $location,
                'is_published' => true,
                'entity_type' => 'product',
                ]
            );
        }

        if ($result) {
            return back()->with('success', 'Successfully uploaded');
        }

        return back()->with('error', 'Failed to upload');
    }

    /**
     * Delete the image
     *
     * @param integer $id
     *
     * @return Illuminate\Http\Response
     */
    public function deleteImage($id)
    {
        $image = $this->imageRepository->findImagesById($id);

        if (is_file(storage_path($image->location))) {
            @Storage::delete($image->location);
        }

        if (empty($image)) {
            Escritor::notification('Image not found', 'warning');

            return back();
        }

        $image->delete();

        Escritor::notification('Image deleted successfully.', 'success');

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\ProductRequest $request
     * @param int                             $id
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAlternativeData(Request $request, $id)
    {
        $result = $this->service->updateAlternativeData($id, $request->except(['_token', '_method']));

        if ($result) {
            return back()->with('success', 'Successfully updated');
        }

        return back()->with('error', 'Failed to update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $result = $this->service->destroy($id);

        if ($result) {
            return redirect(config('escritor.admin-route-prefix', 'admin').'/products')->with('success', 'Successfully deleted');
        }

        return redirect(config('escritor.admin-route-prefix', 'admin').'/products')->with('error', 'Failed to delete');
    }
}
