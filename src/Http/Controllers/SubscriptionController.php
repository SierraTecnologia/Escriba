<?php

namespace Escritor\Http\Controllers;

use Escritor\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Escritor\Services\LogisticService;
use Escritor\Services\PlanService;
use SierraTecnologia\Crypto\Services\Crypto;

class SubscriptionController extends Controller
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
     * Subscribe to a plan
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function subscribe($id)
    {
        if (is_null(auth()->user()->meta->sitecpayment_id)) {
            return redirect('store/account/card');
        }

        $plan = $this->service->find(Crypto::decrypt($id));
        auth()->user()->meta->newSubscription($plan->subscription_name, $plan->sitecpayment_name)->create();

        app(LogisticService::class)->afterSubscription(auth()->user(), $plan);

        return view('escritor::subscriptions.success')->with('plan', $plan);
    }

    /**
     * View all customer subscriptions
     *
     * @return Illuminate\Http\Response
     */
    public function allSubscriptions()
    {
        $subscriptions = auth()->user()->meta->subscriptions()->orderBy('created_at', 'DESC')->paginate(config('siravel.pagination'));

        return view('escritor::subscriptions.all')->with('subscriptions', $subscriptions);
    }

    /**
     * Get a subscription by name
     *
     * @param string $name
     *
     * @return Illuminate\Http\Response
     */
    public function getSubscription($name)
    {
        $subscription = auth()->user()->meta->subscription(Crypto::decrypt($name));

        return view('escritor::subscriptions.subscription')->with('subscription', $subscription);
    }

    /**
     * Cancel a subscription
     *
     * @param Request $request
     * @param string  $name
     *
     * @return Illuminate\Http\Response
     */
    public function cancelSubscription(Request $request, $name)
    {
        auth()->user()->meta->subscriptions()
            ->where('name', Crypto::decrypt($name))
            ->where('sitecpayment_id', Crypto::decrypt($request->sitecpayment_id))->first()->cancel();

        app(LogisticService::class)->cancelSubscription(auth()->user(), Crypto::decrypt($name));

        return redirect('store/account/subscriptions')->with('message', 'Your subscription was cancelled');
    }
}
