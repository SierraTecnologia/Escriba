@extends('siravel-frontend::layouts.store')

@section('store-content')

    @include('siravel-frontend::profile.tabs')

    <div class="row">
        <div class="col-md-6">
            <h2>Update Address</h2>

            <form id="" method="post" action="{!! route('account.profile.update') !!}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class="form-control" name="street" placeholder="Street">
                </div>
                <div class="form-group">
                    <input class="form-control" name="postal" placeholder="Postal">
                </div>
                <div class="form-group">
                    <input class="form-control" name="city" placeholder="City">
                </div>
                <div class="form-group">
                    <input class="form-control" name="state" placeholder="State">
                </div>
                <div class="form-group">
                    <input class="form-control" name="country" placeholder="Country">
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="shipping">
                        Shipping
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="billing">
                        Billing
                    </label>
                </div>
                <br />
                <input class="btn btn-primary float-right" type="submit" value="Save">
            </form>
        </div>
        <div class="col-md-6">
            <h2>Current Address</h2>
            <table class="table table-sitecpaymentd">
                <tr>
                    <td>Shipping Address</td>
                    <td>
                        {!! escritor()->customer()->shippingAddress('street') !!}
                        {!! escritor()->customer()->shippingAddress('postal') !!}
                        {!! escritor()->customer()->shippingAddress('city') !!}
                        {!! escritor()->customer()->shippingAddress('state') !!}
                        {!! escritor()->customer()->shippingAddress('country') !!}
                    </td>
                </tr>
                <tr>
                    <td>Billing Address</td>
                    <td>
                        {!! escritor()->customer()->billingAddress('street') !!}
                        {!! escritor()->customer()->billingAddress('postal') !!}
                        {!! escritor()->customer()->billingAddress('city') !!}
                        {!! escritor()->customer()->billingAddress('state') !!}
                        {!! escritor()->customer()->billingAddress('country') !!}
                    </td>
                </tr>
            </table>
        </div>
    </div>

@endsection

