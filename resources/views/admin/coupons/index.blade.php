@extends( (isset($bladeLayout) && !empty($bladeLayout)) ?: \Illuminate\Support\Facades\Config::get('pedreiro.blade_layout', 'layouts.app'))

@section('pageTitle') Coupons @stop

@section('content')

    @include('escritor::layouts.module-header', [ 'module' => 'coupons' ])

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                @if ($coupons->isEmpty())
                    @include('escritor::layouts.module-search', [ 'module' => 'coupons' ])
                @else
                    <table class="table table-sitecpaymentd">
                        <thead>
                            <th>Name</th>
                            <th>Expired</th>
                            <th>For Subscription</th>
                            <th>Value</th>
                            <th class="text-right" width="150px">Actions</th>
                        </thead>
                        <tbody>
                        @foreach($coupons as $coupon)
                            <tr>
                                <td><a href="{!! route('admin.escritor.coupons.show', [$coupon->id]) !!}">{{ $coupon->code }}</a></td>
                                <td>@if ($coupon->expired()) <span class="fa fa-check"></span> @endif</td>
                                <td>@if ($coupon->for_subscriptions) <span class="fa fa-check"></span> @endif</td>
                                <td>{{ $coupon->value_string }}</td>
                                <td class="text-right">
                                    <a class="btn btn-secondary btn-sm float-right" href="{!! route('admin.escritor.coupons.show', [$coupon->id]) !!}"><i class="fa fa-eye"></i> View</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="row">
                        {!! $coupons !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

@stop
