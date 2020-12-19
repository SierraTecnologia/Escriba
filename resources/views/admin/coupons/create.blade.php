@extends( (isset($bladeLayout) && !empty($bladeLayout)) ?: \Illuminate\Support\Facades\Config::get('pedreiro.blade_layout', 'layouts.app'))

@section('pageTitle') Coupons: Create @stop

@section('content')

    <div class="col-md-12 raw-margin-top-24">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                {!! Form::open(['route' => 'admin.escritor.coupons.store']) !!}

                {!! FormMaker::fromTable("coupons", \Illuminate\Support\Facades\Config::get('siravel.forms.coupons')) !!}

                {!! Form::submit('Save', ['class' => 'btn btn-primary float-right']) !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@stop
