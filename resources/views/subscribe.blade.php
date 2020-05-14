@extends('template')

@section('content')
<div class="container">
    <div class="row">
        <div class="col md-12">
            <h4> Manage Subscription</h4>
            @if (Auth::user()->subscription('primary') && Auth::user()->subscription('primary')->onGracePeriod())
            <div class="alert alert-danger">
                You have cancelled, but still have pre-paid until the end of your subscription period.
            </div>
            @endif
            @if (Auth::user()->subscription('primary') && Auth::user()->subscription('primary')->onTrial())
            <div class="alert alert-info">
                Enjoy your 14 day free trial
            </div>
            @endif
            @if (Auth::user()->subscribed('primary'))
            @if (Auth::user()->subscribedToPLan('monthly', 'primary'))
            <p>
                You are subscribed Monthly!
            </p>
            <table class="table">
                <thead>
                    <th>Invoice Date</th>
                    <th>Tital</th>
                    <th>Download</th>
                </thead>
                <tbody>
                    @foreach (Auth::user()->invoices() as $invoice)
                    <tr>
                        <td> {{ $invoice->date()->toFormattedDateString()}}</td>
                        <td> {{ $invoice->total() }} </td>
                        <td> <a href="/user/invoice/{{$invoice->id}}"> Download</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="/pay/yearly" class="btn btn-sm btn-info"> Upgrade to Annually</a>
            @else
            <p>
                You are subscribed Annually!
            </p>
            <a href="/pay/monthly" class="btn btn-sm btn-primary"> Downgrade to Monthly</a>
            @endif
            <a href="/cancel" class="btn btn-sm btn-danger"> Cancel Subscription</a>
            @else
            <p>
                You are not subscribed!
            </p>
            <h4> Subscribe</h4>
            @if (!Auth::user()->subscribedToPLan('monthly', 'primary'))
            <form action="/pay/monthly" method="POST">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col">
                        <label for="coupon"> Please enter your coupon here</label>
                    </div>
                    <div class="col">
                        <input type="text" name="coupon" id="coupon" value="">
                    </div>

                </div>

                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{env('STRIPE_KEY')}}" data-amount="{{500 * 0.9}}" data-name="Cashier" data-currency="EUR"
                    data-description="Monthly Subscription"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png" data-locale="auto"
                    data-label="Subscribe Monthly" data-panel-label="Subscribe">
                </script>
            </form>
            @endif
            <br />
            @if (!Auth::user()->subscribedToPLan('yearly', 'primary'))
            <form action="/pay/yearly" method="POST">
                {{ csrf_field() }}
                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{env('STRIPE_KEY')}}" style="margin-top:10px;" data-amount="{{2000 * 0.9}}"
                    data-name="Cashier" data-currency="EUR" data-description="Yearly Subscription"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png" data-locale="auto"
                    data-label="Subscribe Yearly" data-panel-label="Subscribe">
                </script>
            </form>
            @endif
            @endif
        </div>
        @endsection
