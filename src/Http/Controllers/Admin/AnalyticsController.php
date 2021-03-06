<?php

namespace Escritor\Http\Controllers\Admin;

use App\Services\UserService;
use Illuminate\Http\Request;
use Escritor\Http\Controllers\SitecController;
use Escritor\Services\AnalyticsService;
use Escritor\Services\TransactionService;

class AnalyticsController extends SitecController
{
    public function __construct(
        TransactionService $transactionService,
        AnalyticsService $analyticsService,
        UserService $userService
    ) {
        $this->transactions = $transactionService;
        $this->analyticsService = $analyticsService;
        $this->users = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $months = 1;

        if ($request->months) {
            $months = $request->months;
        }

        $transactions = $this->transactions->overMonths($months);
        $balanceValues = $this->analyticsService->balanceValues($transactions);
        $subscriptions = $this->analyticsService->getSubscriptions();
        $data = $this->analyticsService->mergeTransactionsAndSubscriptions($months);

        return view('escritor::admin.analytics')
            ->with('transactions', $transactions)
            ->with('balanceValues', [round($balanceValues['refunds'], 2), round($balanceValues['income'], 2)])
            ->with('transactionDays', $data['days'])
            ->with('transactionsByDay', collect($data['transactions'])->values())
            ->with('subscriptionsByDay', collect($data['subscriptions'])->values())
            ->with('subscriptions', $subscriptions);
    }
}
