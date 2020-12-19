@extends( (isset($bladeLayout) && !empty($bladeLayout)) ?: \Illuminate\Support\Facades\Config::get('pedreiro.blade_layout', 'layouts.app'))

@section('pageTitle') Subscription Plans @stop

@section('content')

    @include('escritor::layouts.module-header', [ 'module' => 'plans' ])

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                @if ($plans->isEmpty())
                    @include('escritor::layouts.module-search', [ 'module' => 'plans' ])
                @else
                    <table class="table table-sitecpaymentd">
                        <thead>
                            <th>Name</th>
                            <th>Enabled</th>
                            <th class="text-right" width="150px">Actions</th>
                        </thead>
                        <tbody>
                        @foreach($plans as $plan)
                            <tr>
                                <td><a href="{!! route('admin.escritor.plans.edit', [$plan->id]) !!}">{{ $plan->name }}</a></td>
                                <td>@if ($plan->enabled) <span class="fa fa-check"></span> @endif</td>
                                <td class="text-right">
                                    <a class="btn btn-outline-primary btn-sm float-right" href="{!! route('admin.escritor.plans.edit', [$plan->id]) !!}"><i class="fa fa-edit"></i> Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="row">
                        {!! $plans !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

@stop
