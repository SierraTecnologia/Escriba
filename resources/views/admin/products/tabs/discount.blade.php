{!! Form::model($product, ['url' => 'admin'.'/products/discounts/'.$product->id, 'method' => 'post']) !!}

    {!! FormMaker::setColumns(2)->fromObject($product, \Illuminate\Support\Facades\Config::get('siravel.forms.discounts')) !!}

    <div class="form-group text-right">
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}
