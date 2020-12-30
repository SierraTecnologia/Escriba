@extends( (isset($bladeLayout) && !empty($bladeLayout)) ?: \Illuminate\Support\Facades\Config::get('pedreiro.blade_layout', 'layouts.app'))

@section('pageTitle') Products @stop

@section('content')

    <div class="col-md-12 mt-2">
        @include('escritor::admin.products.breadcrumbs', ['location' => ['create']])
        {!! Form::open(['route' => 'admin.escritor.products.store', 'files' => true]) !!}

            {!! FormMaker::setColumns(2)->fromTable('products', \Illuminate\Support\Facades\Config::get('siravel.forms.details.identity')) !!}
            {!! FormMaker::setColumns(2)->fromTable('products', \Illuminate\Support\Facades\Config::get('siravel.forms.details.price')) !!}

            {!! FormMaker::setColumns(2)->fromTable('products', \Illuminate\Support\Facades\Config::get('siravel.forms.details.content')) !!}

            {!! FormMaker::setColumns(2)->fromTable('products', \Illuminate\Support\Facades\Config::get('siravel.forms.details.seo')) !!}
            {!! FormMaker::setColumns(2)->fromTable('products', \Illuminate\Support\Facades\Config::get('siravel.forms.details.options')) !!}

            <div class="form-group text-right">
                <a href="{!! URL::previous() !!}" class="btn btn-secondary float-left">{{ __('pedreiro::generic.cancel') }}</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>

@endsection
