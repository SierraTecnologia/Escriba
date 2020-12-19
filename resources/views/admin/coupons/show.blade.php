@extends( (isset($bladeLayout) && !empty($bladeLayout)) ?: \Illuminate\Support\Facades\Config::get('pedreiro.blade_layout', 'layouts.app'))

@section('pageTitle') Coupons: Details @stop

@section('content')

    @include('escritor::admin.modals')

    <div class="col-md-12 raw-margin-top-24">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                {!! FormMaker::fromObject($coupon, \Illuminate\Support\Facades\Config::get('siravel.forms.coupons')) !!}

                <form id="deleteCouponForm" method="post" action="{!! url('admin'.'/coupons/'.$coupon->id) !!}">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}
                    <button class="btn delete-coupon-btn btn-danger float-right" type="submit"><i class="fa fa-trash"></i> Delete</button>
                </form>
            </div>
        </div>
    </div>

@stop

@section('javascript')
    @parent
    <script type="text/javascript" src="{{ Escritor::moduleAsset('js/coupons.js', 'application/javascript') }}"></script>
@endsection
