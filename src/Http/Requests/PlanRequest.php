<?php

namespace Escritor\Http\Requests;

use Escritor\Models\Plan;

class PlanRequest extends EscritorRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return app(Plan::class)->rules;
    }
}
