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
     * @return Relationship
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the corresponding Refund
     *
     * @return Relationship
     */
    public function refund()
    {
        return $this->belongsTo(Refund::class);
    }

    /**
     * Get the corresponding Product
     *
     * @return Relationship
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the corresponding transaction, if there is one
     *
     * @return Relationship
     */
    public function transaction()
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
     * @return Attribute
     */
    public function getProductVariantsAttribute()
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

    public function getTotalAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getSubtotalAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getShippingAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }

    public function getTaxAttribute($value)
    {
        return number_format($value * 0.01, 2, '.', '');
    }
}
