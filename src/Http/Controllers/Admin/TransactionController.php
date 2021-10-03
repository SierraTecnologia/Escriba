<?php

namespace Escritor\Http\Controllers\Admin;

use Escritor\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Escritor\Services\TransactionService;

class TransactionController extends Controller
{
    public function __construct(TransactionService $transactionService)
    {
        $this->service = $transactionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = $this->service->paginated();

        return view('escritor::admin.transactions.index')
            ->with('pagination', $transactions->render())
            ->with('transactions', $transactions);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $transactions = $this->service->search($request->term);

        return view('escritor::admin.transactions.index')
            ->with('transactions', $transactions[0]->get())
            ->with('pagination', $transactions[2])
            ->with('term', $transactions[1]);
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
        $transaction = $this->service->find($id);
        $order = $this->service->getTransactionOrder($id);

        return view('escritor::admin.transactions.edit')
            ->with('order', $order)
            ->with('transaction', $transaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int                                   $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): self
    {
        $result = $this->service->update($id, $request->except(['_token', '_method']));

        if ($result) {
            return back()->with('success', 'Successfully updated');
        }

        return back()->with('error', 'Failed to update');
    }

    /**
     * Issue a refund.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refund(Request $request): self
    {
        $result = $this->service->refund($request->uuid);

        if ($result) {
            return back()->with('success', 'Successfully refunded');
        }

        return back()->with('error', 'Failed to refund');
    }
}
