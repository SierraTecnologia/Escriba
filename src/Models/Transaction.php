<?php

namespace Escritor\Models;

use Escritor\Models\EscritorModel;
use Escritor\Models\Order;
use Escritor\Models\Refund;


class Transaction extends EscritorModel
{
    
    public $table = 'transactions';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'uuid',
        'provider',
        'state',
        'subtotal',
        'coupon',
        'tax',
        'total',
        'shipping',
        'refund_date',
        'refund_requested',
        'provider_id',
        'provider_date',
        'provider_dispute',
        'user_id',
        'notes',
        'cart',
        'response',
    ];

    public $rules = [];

    public function order(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Order::class);
    }

    public function refunds(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Refund::class);
    }

    public function getStateAttribute($value): string
    {
        return ucfirst($value);
    }

    public function getAmountAttribute()
    {
        return $this->total;
    }

    public function getTotalAttribute($value): string
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getTaxAttribute($value): string
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getShippingAttribute($value): string
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getSubtotalAttribute($value): string
    {
        return number_format($value * 0.01, 2, '.', '');
    }
}
