<?php

namespace Escritor\Http\Controllers;

use Escritor\Http\Controllers\Controller;
use Escritor\Services\PlanService;

class PlanController extends Controller
{
    protected $service;

    public function __construct(PlanService $service)
    {
        if (!config('escritor.subscriptions')) {
            return back()->send();
        }
        $this->service = $service;
    }

    /**
     * Display all plan entries.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $plans = $this->service->allEnabled();

        if (empty($plans)) {
            abort(404);
        }

        return view('escritor::plans.all')->with('plans', $plans);
    }

    /**
     * Display the specified plan.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $plan = $this->service->findByUuid($id);

        if (empty($plan)) {
            abort(404);
        }

        return view('escritor::plans.show')->with('plan', $plan);
    }
}
