<?php

namespace Escritor\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Escritor\Http\Requests\Request;
use Escritor\Models\Feature;

abstract class EscritorRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //@todo Fazer Gate::allows('has-feature', Feature::find('escritor'));
    }
}
