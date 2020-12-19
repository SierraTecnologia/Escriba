@extends('siravel-frontend::layouts.store')

@section('store-content')

    <h1 class="mb-4">Checkout: Confirmation</h1>

    <div class="row">
        <div class="col-md-4">
            <h4 class="mb-4">Shipping Info</h4>
            <form method="post" action="{!! route('siravel.calculate.shipping') !!}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class="form-control" required name="address[street]" placeholder="Street" value="{!! escritor()->customer()->shippingAddress('street') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[postal]" placeholder="Postal" value="{!! escritor()->customer()->shippingAddress('postal') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[city]" placeholder="City" value="{!! escritor()->customer()->shippingAddress('city') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[state]" placeholder="State" value="{!! escritor()->customer()->shippingAddress('state') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[country]" placeholder="Country" value="{!! escritor()->customer()->shippingAddress('country') !!}">
                </div>
                <input class="btn btn-outline-secondary float-right" type="submit" value="Re-calculate Shipping">
            </form>
        </div>
        <div class="col-md-8">
            <h4 class="mb-4">Shopping Cart</h4>
            @include('siravel-frontend::checkout.coupon')
            @include('siravel-frontend::checkout.products')
            <a class="float-right btn btn-primary" href="{!! route('siravel.payment') !!}">Purchase</a>
        </div>
    </div>

@endsection
