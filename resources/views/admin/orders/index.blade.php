@extends( (isset($bladeLayout) && !empty($bladeLayout)) ?: \Illuminate\Support\Facades\Config::get('pedreiro.blade_layout', 'layouts.app'))

@section('pageTitle') Orders @stop

@section('content')

    @include('escritor::layouts.module-header', [ 'module' => 'orders' ])

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                @if ($orders->isEmpty())
                    @include('escritor::layouts.module-search', [ 'module' => 'orders' ])
                @else
                    <table class="table table-sitecpaymentd">
                        <thead>
                            <th>Order ID</th>
                            <th class="m-hidden">Transaction ID</th>
                            <th class="m-hidden">Customer</th>
                            <th class="m-hidden">Status</th>
                            <th class="m-hidden text-center">Shipped</th>
                            <th class="m-hidden">Tracking #</th>
                            <th width="100px" class="text-right">Action</th>
                        </thead>
                        <tbody>

                        @foreach($orders as $order)
                            <tr>
                                <td><a href="{!! route('admin.escritor.orders.edit', [$order->id]) !!}">Order #{!! $order->id !!}</a></td>
                                <td class="m-hidden"><a href="{!! route('admin.escritor.transactions.edit', [$order->transaction->id]) !!}">Transaction #{!! $order->transaction->id !!}</a></td>
                                <td class="m-hidden">{!! auth()->user()->find($order->user_id)->name !!}</td>
                                <td class="m-hidden">{!! ucfirst($order->status) !!}</td>
                                <td class="m-hidden text-center">
                                    @if ($order->is_shipped)
                                        <span class="fa fa-truck"></span>
                                    @else
                                        <span class="fa fa-close"></span>
                                    @endif
                                </td>
                                <td class="m-hidden">{!! $order->tracking_number !!}</td>
                                <td class="text-right">
                                    <a class="btn btn-sm btn-outline-primary float-right" href="{!! route('admin.escritor.orders.edit', [$order->id]) !!}"><i class="fa fa-edit"></i> Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="text-center">
                {{ $pagination }}
            </div>
        </div>
    </div>

@endsection
