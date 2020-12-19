<?php

namespace Escritor\Http\Controllers\Admin;

use Escritor\Http\Controllers\SitecController;
use Escritor\Http\Requests\CouponRequest;
use Escritor\Http\Requests\PlanRequest;
use Escritor\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends SitecController
{
    public function __construct(CouponService $couponService)
    {
        $this->service = $couponService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->service->collectNewCoupons();
        $coupons = $this->service->paginated();

        return view('escritor::admin.coupons.index')->with('coupons', $coupons);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $coupons = $this->service->search($request->term);

        return view('escritor::admin.coupons.index')
            ->with('term', $request->term)
            ->with('coupons', $coupons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('escritor::admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\CouponRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        $result = $this->service->create($request->except('_token'));

        if ($result) {
            return redirect(config('escritor.admin-route-prefix', 'admin').'/coupons/'.$result->id)
                ->with('success', 'Successfully created');
        }

        return redirect('admin.escritor.coupons')->with('error', 'Failed to create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $coupon = $this->service->find($id);

        return view('escritor::admin.coupons.show')
            ->with('coupon', $coupon);
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
            return redirect(config('escritor.admin-route-prefix', 'admin').'/coupons')
                ->with('success', 'Successfully deleted');
        }

        return redirect(config('escritor.admin-route-prefix', 'admin').'/coupons')
            ->with('error', 'Failed to delete');
    }
}
