<?php

namespace Escritor\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Escritor\Models\Plan;
use Escritor\Services\CartService;
use Escritor\Services\CustomerProfileService;
use Escritor\Services\LogisticService;

class StoreHelperService
{
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function url($url)
    {
        return $this->storeUrl($url);
    }
    public function storeUrl($url)
    {
        return url(config('escritor.store_url_prefix').'/'.$url);
    }

    public function customer()
    {
        return app(CustomerProfileService::class);
    }

    public function customerSubscriptionUrl($subscription)
    {
        return $this->storeUrl('/account/subscription/'.crypto_encrypt($subscription->name));
    }

    public function subscriptionPlan($subscription)
    {
        return app(Plan::class)->getPlansBySierraTecnologiaId($subscription->sitecpayment_plan);
    }

    public function subscriptionUpcoming($subscription)
    {
        $key = $subscription->sitecpayment_id.'__'.auth()->id();

        if (!Cache::has($key)) {
            $invoice = auth()->user()->meta->upcomingInvoice($subscription->name);
            Cache::put(
                $key, [
                'total' => round(($invoice->total / 100), 2),
                'attempt_count' => $invoice->attempt_count,
                'period_start' => $invoice->period_start,
                'period_end' => $invoice->period_end,
                'date' => Carbon::createFromTimestamp($invoice->date),
                ], 25
            );
        }

        return Cache::get($key);
    }

    public function subscriptionUrl($subscription)
    {
        return $this->storeUrl('/plan/'.crypto_encrypt($subscription->id));
    }

    public function cancelSubscriptionBtn($subscription, $class = 'btn btn-danger', $buttonContent = 'Cancel Subscription')
    {
        return '<form method="post" action="'.$this->storeUrl('/account/subscription/'.crypto_encrypt($subscription->name)).'/cancel">'
        .csrf_field()
        .'<input type="hidden" name="sitecpayment_id" value="'.crypto_encrypt($subscription->sitecpayment_id).'">'
        .'<button class="'.$class.'">'.$buttonContent.'</button></form>';
    }

    public function moneyFormat($amount)
    {
        return number_format(round($amount, 2), 2);
    }

    public function checkoutTax()
    {
        return $this->moneyFormat($this->cartService->getCartTax());
    }

    public function checkoutTotal()
    {
        return $this->moneyFormat($this->cartService->getCartTotal());
    }

    public function checkoutSubtotal()
    {
        return $this->moneyFormat($this->cartService->getCartSubtotal());
    }

    public function couponValue()
    {
        return $this->moneyFormat($this->cartService->getCurrentCouponValue());
    }

    public function checkoutShipping()
    {
        return $this->moneyFormat(app(LogisticService::class)->shipping(auth()->user()));
    }
}
