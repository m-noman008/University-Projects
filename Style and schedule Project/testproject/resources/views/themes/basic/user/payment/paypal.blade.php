@extends($theme.'layouts.user')
@section('title')
    {{ 'Pay with '.optional($order->gateway)->name ?? '' }}
@endsection
@section('content')

    <div class="container-fluid">
        <div class="main row">
            <div class="col-md-12">
                <div class="dashboard-heading mt-2">
                    <h2 class="mb-0">@lang('Pay with '.optional($order->gateway)->name ?? '' )</h2>
                </div>


                <div class="dashboard-box-wrapper mt-3">
                    <div class="row g-4 mb-4">
                        <div class="col-md-8">

                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('script')
        <script
            src="https://www.paypal.com/sdk/js?client-id={{ $data->cleint_id }}&currency={{$data->currency}}"></script>
        <script>
            paypal.Buttons({
                createOrder: function (data, actions) {
                    return actions.order.create({
                        purchase_units: [
                            {
                                description: "{{ $data->description }}",
                                custom_id: "{{ $data->custom_id }}",
                                amount: {
                                    currency_code: "{{ $data->currency }}",
                                    value: "{{ $data->amount }}",
                                    breakdown: {
                                        item_total: {
                                            currency_code: "{{ $data->currency }}",
                                            value: "{{ $data->amount }}"
                                        }
                                    }
                                }
                            }
                        ]
                    });
                },
                onApprove: function (data, actions) {
                    return actions.order.capture().then(function (details) {
                        var trx = "{{ $data->custom_id }}";
                        window.location = '{{ url('payment/paypal')}}/' + trx + '/' + details.id
                    });
                }
            }).render('#paypal-button-container');
        </script>
    @endpush
@endsection
