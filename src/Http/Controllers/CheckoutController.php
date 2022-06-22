<?php

namespace Escritor\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Escritor\Http\Controllers\Controller;
use Escritor\Services\CartService;
use Escritor\Services\PaymentService;
use Escritor\Services\CustomerProfileService;

class CheckoutController extends Controller
{
    public function __construct(
        CartService $cartService,
        PaymentService $paymentService,
        CustomerProfileService $customer
    ) {
        $this->cart = $cartService;
        $this->payment = $paymentService;
        $this->customer = $customer;
    }

    /**
     * Show the customer confirmation page
     *
     * @return \Illuminate\Http\Response
     */
    public function confirm()
    {
        $products = $this->cart->contents();

        return view('escritor::checkout.confirm')->with('products', $products);
    }

    /**
     * Confirm payment view
     *
     * @return \Illuminate\Http\Response
     */
    public function payment()
    {
        $products = $this->cart->contents();

        return view('escritor::checkout.payment')->with('products', $products);
    }

    /**
     * Add a coupon to the cart
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCoupon(Request $request): self
    {
        $this->cart->addCoupon($request->coupon);

        return back()->with('message', 'Successfully applied coupon');
    }

    /**
     * Remove a coupon from the cart
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeCoupon(): self
    {
        $this->cart->removeCoupon();

        return back()->with('message', 'Successfully removed coupon');
    }

    /**
     * Process a payment
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function process(Request $request)
    {
        try {
            $response = $this->payment->purchase($request->input('sitecpaymentToken'), $this->cart);
        } catch (Exception $e) {
            $response = $e->getMessage();
        }

        return $response;
    }

    /**
     * Process a payment with the last card on file
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function processWithLastCard(Request $request)
    {
        try {
            $response = $this->payment->purchase($request->input('sitecpaymentToken'), $this->cart);
        } catch (Exception $e) {
            $response = $e->getMessage();
        }

        return $response;
    }

    /**
     * Purchase is completed view
     *
     * @return \Illuminate\Http\Response
     */
    public function complete()
    {
        $products = $this->cart->contents();

        return view('escritor::checkout.complete')->with('products', $products);
    }

    /**
     * Purchase failed view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function failed()
    {
        return view('escritor::checkout.failed');
    }

    /**
     * Recalculate shipping request
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reCalculateShipping(Request $request): self
    {
        $this->customer->updateProfileAddress(
            array_merge(
                $request->address, [
                'shipping' => true
                ]
            )
        );

        return back()->with('message', 'Successfully updated');
    }
}
