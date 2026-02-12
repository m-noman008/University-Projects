@extends($theme.'layouts.user')
@section('title')
    {{ 'Pay with '.optional($order->gateway)->name ?? '' }}
@endsection


@section('content')

    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>



    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
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

                                    <div class="col-md-4">

                                        <h4>@lang('Please Pay') {{getAmount($order->final_amount)}} {{$order->gateway_currency}}</h4>
                                        <form action="{{$data->url}}" method="{{$data->method}}">
                                            <script
                                                src="{{$data->src}}"
                                                class="stripe-button"
                                                @foreach($data->val as $key=> $value)
                                                data-{{$key}}="{{$value}}"
                                                @endforeach>
                                            </script>
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
        <script>
            $(document).ready(function () {
                $('button[type="submit"]').removeClass("stripe-button-el").addClass("pay_btn").find('span').css('min-height', 'initial');
            })
        </script>
    @endpush

@endsection




