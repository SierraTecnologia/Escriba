@extends( (isset($bladeLayout) && !empty($bladeLayout)) ?: \Illuminate\Support\Facades\Config::get('pedreiro.blade_layout', 'layouts.app'))

@section('pageTitle') Products @stop

@section('content')

    @include('escritor::admin.modals')

    @include('escritor::layouts.module-header', [ 'module' => 'products' ])

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                @if ($products->count() === 0)
                    @include('escritor::layouts.module-search', [ 'module' => 'products' ])
                @else
                    <table class="table table-sitecpaymentd">
                        <thead>
                            <th>{!! sortable('Name', 'name') !!}</th>
                            <th class="m-hidden">{!! sortable('Code', 'code') !!}</th>
                            <th class="m-hidden">{!! sortable('Price', 'price') !!}</th>
                            <th class="m-hidden">Stock</th>
                            <th class="m-hidden">Available</th>
                            <th class="m-hidden">Is Published</th>
                            <th class="m-hidden">Is Downloaded</th>
                            <th width="170px" class="text-right">Action</th>
                        </thead>
                        <tbody>

                        @foreach($products as $product)
                            <tr>
                                <td><a href="{!! route('admin.escritor.products.edit', [$product->id]) !!}">{!! $product->name !!}</a></td>
                                <td class="m-hidden">{!! $product->code !!}</td>
                                <td class="m-hidden">${!! $product->price !!}</td>
                                <td class="m-hidden">{!! $product->stock !!}</td>
                                <td class="m-hidden">
                                    @if ($product->is_available)
                                    <span class="fa fa-check"></span>
                                    @endif
                                </td>
                                <td class="m-hidden">
                                    @if ($product->is_published)
                                    <span class="fa fa-check"></span>
                                    @endif
                                </td>
                                <td class="m-hidden">
                                    @if ($product->is_download)
                                    <a href="{!! URL::to(app(FileService::class)->fileAsDownload($product->name, $product->file)) !!}" target="_blank"><span class="fa fa-download"></span> Download</a>
                                    @else
                                    <span class="fa fa-close"></span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="btn-toolbar justify-content-between">
                                        <a class="btn btn-sm btn-outline-primary mr-2" href="{!! route('admin.escritor.products.edit', [$product->id]) !!}"><i class="fa fa-pencil"></i> Edit</a>
                                        <form method="post" action="{!! url('admin'.'/products/'.$product->id) !!}">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="delete-btn btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <div class="text-center">
        {!! $pagination !!}
    </div>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript" >
        $(document).ready(function(){
            $('.variant-row').each(function(){
                var _variant = $(this).data('variant');
                var _row = $(this);
                $(this).children('td').children('.save-variant').click(function(){
                    var _key = _row.children('td').children('.key').val();
                    var _value = _row.children('td').children('.value').val();
                    $.ajax({
                        type: "POST",
                        url: _url+"/admin/products/variant/save",
                        data: {
                            _token: _token,
                            id: _variant,
                            key: _key,
                            value: _value
                        },
                        cache: false,
                        dataType: "html",
                        success: function(data){
                            siravelNotify('Your variant was saved', 'alert-success')
                        }
                    });
                });

                $(this).children('td').children('.delete-variant').click(function(){
                    $.ajax({
                        type: "POST",
                        url: _url+"/admin/products/variant/delete",
                        data: { id: _variant, _token: _token },
                        cache: false,
                        dataType: "html",
                        success: function(data){
                            siravelNotify('Your variant was deleted', 'alert-success')
                            _row.remove();
                        }
                    });
                });
            });
        });
    </script>

@endsection
