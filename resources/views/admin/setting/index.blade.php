@extends('admin.layout.master')

@section('content')

<h3><i class="fa fa-angle-right"></i>Settings</h3>

<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
            <section>
                <table class="table table-bordered table-striped table-condensed">
                    <tbody>
                        <tr>
                            <td><h5>Bartender Halfday Fee</h5></td>
                            <td><h5><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->hprice}}</span></h5></td>
                        </tr>
                        <tr>
                            <td><h5>Bartender Fullday Fee</h5></td>
                            <td><h5><i class="material-icons">attach_money</i><span class="icon-name">{{$entry->fprice}}</span></h5></td>
                        </tr>
                        <tr>
                            <td><h5>Tax</h5></td>
                            <td><h5>{{$entry->tax}}%</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Payment Mode</h5></td>
                            <td><h5>{{$entry->payment_mode}}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Paypal Client ID</h5></td>
                            <td><h5>{{$entry->paypal_client_id}}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Paypal Secret Key</h5></td>
                            <td><h5>{{$entry->paypal_secret}}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Stripe Publishable Key</h5></td>
                            <td><h5>{{$entry->stripe_publishable_key}}</h5></td>
                        </tr>
                        <tr>
                            <td><h5>Stripe Secret Key</h5></td>
                            <td><h5>{{$entry->stripe_secret_key}}</h5></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a class="btn btn-info" href="{{ route('admin::settings.edit',  $entry->id) }}">Edit</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>

@stop
