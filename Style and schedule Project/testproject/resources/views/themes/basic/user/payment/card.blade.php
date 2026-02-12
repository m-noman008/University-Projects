@extends($theme.'layouts.user')
@section('title')
    {{ 'Pay with '.optional($order->gateway)->name ?? '' }}
@endsection

@section('content')
    @push('style')
        <link href="{{ asset('assets/admin/css/card-js.min.css') }}" rel="stylesheet" type="text/css"/>
        <style>
            .card-js .icon {
                top: 5px;
            }
        </style>
    @endpush


    <div class="container-fluid">
        <div class="main row">
            <div class="col-md-12">

                <div class="dashboard-heading mt-2">
                    <h2 class="mb-0">@lang('Pay with '.optional($order->gateway)->name ?? '' )</h2>
                </div>


                <div class="dashboard-box-wrapper mt-3">
                    <div class="row g-4 mb-4">
                        <div class="col-md-8">
                            <div class=" dashboard-box ">
                                <div class=" row">

                                    <div class="col-md-3">
                                        <img
                                            src="{{getFile(config('location.gateway.path').optional($order->gateway)->image)}}"
                                            class="w-75" alt="..">
                                    </div>


                                    <div class="col-md-9">
                                        <form class="form-horizontal" id="example-form"
                                              action="{{ route('ipn', [optional($order->gateway)->code ?? '', $order->transaction]) }}"
                                              method="post">
                                            <div class="card-js form-group --payment-card">
                                                <input class="card-number form-control"
                                                       name="card_number"
                                                       placeholder="@lang('Enter your card number')"
                                                       autocomplete="off"
                                                       required>
                                                <input class="name form-control"
                                                       id="the-card-name-id"
                                                       name="card_name"
                                                       placeholder="@lang('Enter the name on your card')"
                                                       autocomplete="off"
                                                       required>
                                                <input class="expiry form-control"
                                                       autocomplete="off"
                                                       required>
                                                <input class="expiry-month" name="expiry_month">
                                                <input class="expiry-year" name="expiry_year">
                                                <input class="cvc form-control"
                                                       name="card_cvc"
                                                       autocomplete="off"
                                                       required>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-3 ">@lang('Submit')</button>
                                        </form>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('assets/admin/js/card-js.min.js') }}"></script>
    @endpush

@endsection
