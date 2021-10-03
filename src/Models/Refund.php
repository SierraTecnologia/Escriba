<?php

namespace Escritor\Models;

use Escritor\Models\EscritorModel;
use Escritor\Models\OrderItem;


class Refund extends EscritorModel
{
    
    public $table = 'refunds';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'transaction_id',
        'provider_id',
        'provider',
        'uuid',
        'amount',
        'charge',
        'currency',
    ];

    public $rules = [];

    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function orderItem(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OrderItem::class);
    }

    public function getAmountAttribute($value): string
    {
        return number_format($value * 0.01, 2, '.', '');
    }
}
