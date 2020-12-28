<?php

namespace Escritor\Http\Requests;

use Escritor\Models\Transaction;

class TransactionsRequest extends EscritorRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return app(Transaction::class)->rules;
    }
}
