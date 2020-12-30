{!! Form::model($product, ['route' => ['admin.escritor.products.update', $product->id], 'method' => 'patch', 'files' => true]) !!}

    {!! FormMaker::setColumns(2)->fromObject($product, \Illuminate\Support\Facades\Config::get('siravel.forms.details.identity')) !!}
    {!! FormMaker::setColumns(2)->fromObject($product, \Illuminate\Support\Facades\Config::get('siravel.forms.details.price')) !!}

    <div class="row">
        <div class="col-md-6">
            {!! FormMaker::setColumns(1)->fromObject($product, \Illuminate\Support\Facades\Config::get('siravel.forms.details.content')) !!}
        </div>
        <div class="col-md-6 raw-margin-bottom-24">
            @if ($product->hero_image)
                <img class="img-thumbnail img-fluid" style="display: inline-block;" src="{{ $product->hero_image_url }}" />
            @endif
        </div>
    </div>

    {!! FormMaker::setColumns(2)->fromObject($product, \Illuminate\Support\Facades\Config::get('siravel.forms.details.seo')) !!}
    {!! FormMaker::setColumns(2)->fromObject($product, \Illuminate\Support\Facades\Config::get('siravel.forms.details.options')) !!}

    <div class="form-group text-right">
        <a href="{!! URL::previous() !!}" class="btn btn-secondary float-left">{{ __('pedreiro::generic.cancel') }}</a>
        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    </div>

{!! Form::close() !!}