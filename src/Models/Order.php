<?php

namespace Escritor\Models;

use App\Models\User;
use Escritor\Models\EscritorModel;
use Escritor\Models\OrderItem;
use Escritor\Models\Transaction;


class Order extends EscritorModel
{
    
    public $table = 'orders';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'uuid',
        'user_id',
        'transaction_id',
        'details',
        'shipping_address',
        'is_shipped',
        'tracking_number',
        'notes',
        'status',
    ];

    public $rules = [];

    public $with = [
        'transaction'
    ];

    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function hasRefundedOrderItems(): bool
    {
        if ($this->items->isNotEmpty()) {
            if ($this->items->where('was_refunded', true)->count() > 0) {
                return true;
            }
        }

        return false;
    }

    public function hasActiveOrderItems(): bool
    {
        if ($this->items->isNotEmpty()) {
            if ($this->items->where('was_refunded', false)->count() > 0) {
                return true;
            }
        }

        return false;
    }

    public function remainingValue()
    {
        $refundedValue = 0;

        foreach ($this->items->where('was_refunded', true) as $item) {
            $refundedValue += $item->total;
        }

        return ($this->transaction('total') - $refundedValue);
    }

    public function shippingAddress($key = null)
    {
        $address = json_decode($this->shipping_address);

        if (isset($address->$key)) {
            return $address->$key;
        }

        return $address;
    }

    /**
     * Get the corresponding OrderItems
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Determine the user that made this order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
