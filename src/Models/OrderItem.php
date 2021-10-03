<?php

namespace Escritor\Models;

use Escritor\Models\Order;
use Escritor\Models\Product;
use Escritor\Models\Variant;
use Escritor\Models\EscritorModel;
use Escritor\Models\Transaction;


class OrderItem extends EscritorModel
{
    
    public $table = 'order_items';

    public $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'order_id',
        'product_id',
        'transaction_id',
        'quantity',
        'variants',
        'was_refunded',
        'refund_id',
        'subtotal',
        'shipping',
        'tax',
        'total',
        'status',
    ];

    public $rules = [];

    /**
     * Get the corresponding Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the corresponding Refund
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function refund(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Refund::class);
    }

    /**
     * Get the corresponding Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the corresponding transaction, if there is one
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Determine if this order item is the last non-refunded item in the order
     *
     * @return boolean
     */
    public function isLastNonRefundedItem()
    {
        return $this->was_refunded === 0 && $this->order->items->where('was_refunded', 0)->count() === 1;
    }

    /**
     * Get the variants of the product
     *
     * @return array
     */
    public function getProductVariantsAttribute(): array
    {
        $itemVariants = [];
        $variants = json_decode($this->variants);

        if ($variants) {
            $variantModel = app(Variant::class);

            foreach ($variants as $variant) {
                $variantData = $variantModel->find($variant->variant);
                $itemVariants[$variantData->key] = $variantModel->rawValue($variant->value);
            }
        }

        return $itemVariants;
    }

    public function getAmountAttribute()
    {
        return $this->total / 100;
    }

    public function getTotalAttribute($value): string
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getSubtotalAttribute($value): string
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getShippingAttribute($value): string
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getTaxAttribute($value): string
    {
        return number_format($value * 0.01, 2, '.', '');
    }
}
