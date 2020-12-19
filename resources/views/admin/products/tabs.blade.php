<ul class="nav nav-tabs raw-margin-bottom-24">
    <li class="nav-item">
        <a class="nav-link @if(request('tab') == 'details') active @elseif(!request('tab')) active @endif" href="{!! url('admin'.'/products/'.$product->id.'/edit?tab=details') !!}">Details</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(request('tab') == 'variants') active @endif" href="{!! url('admin'.'/products/'.$product->id.'/edit?tab=variants') !!}">Variants</a>
    </li>
    @if ($product->is_download)
        <li class="nav-item">
            <a class="nav-link @if(request('tab') == 'download') active @endif" href="{!! url('admin'.'/products/'.$product->id.'/edit?tab=download') !!}">Download</a>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link @if(request('tab') == 'dimensions') active @endif" href="{!! url('admin'.'/products/'.$product->id.'/edit?tab=dimensions') !!}">Dimensions</a>
        </li>
    @endif
    <li class="nav-item">
        <a class="nav-link @if(request('tab') == 'discount') active @endif" href="{!! url('admin'.'/products/'.$product->id.'/edit?tab=discount') !!}">Discounts</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(request('tab') == 'images') active @endif" href="{!! url('admin'.'/products/'.$product->id.'/edit?tab=images') !!}">Images</a>
    </li>
</ul>


@if ((request('tab') == 'details') || isset($tabs['details']))
    @include('escritor::admin.products.tabs.details')
@endif

@if (request('tab') == 'variants')
    @include('escritor::admin.products.tabs.variants')
@endif

@if (request('tab') == 'discount')
    @include('escritor::admin.products.tabs.discount')
@endif

@if (request('tab') == 'download')
    @include('escritor::admin.products.tabs.download')
@endif

@if (request('tab') == 'dimensions')
    @include('escritor::admin.products.tabs.dimensions')
@endif

@if (request('tab') == 'images')
    @include('escritor::admin.products.tabs.images')
@endif
