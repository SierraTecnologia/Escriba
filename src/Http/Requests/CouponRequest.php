<?php

namespace Escritor\Http\Requests;

use Escritor\Models\Coupon;

class CouponRequest extends EscritorRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Coupon::$rules;
    }
}
