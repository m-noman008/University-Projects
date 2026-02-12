@extends($theme.'layouts.user')
@section('title')
    {{ 'Pay with '.optional($order->gateway)->name ?? '' }}
@endsection

@section('content')

    <div class="container">
        <div class="main row">
            <div class="col-12">
                <div class="dashboard-heading mt-2">
                    <h2 class="mb-0">@lang('Pay with '.optional($order->gateway)->name ?? '' )</h2>
                </div>

                <div class="dashboard-box-wrapper mt-3">
                    <div class="row g-4 mb-4">
                        <div class="col-md-8">

                            <div class="dashboard-box">
                                <div class="row">

                                    <div class="col-md-3">
                                        <img
                                            src="{{getFile(config('location.gateway.path').optional($order->gateway)->image)}}"
                                            class="w-50" alt="..">
                                    </div>

                                    <div class="col-md-4">
                                        <h4>@lang('Please Pay') {{getAmount($order->final_amount)}} {{$order->gateway_currency}}</h4>
                                        <form action="{{$data->url}}" method="{{$data->method}}">
                                            <script src="{{$data->checkout_js}}"
                                                    @foreach($data->val as $key=>$value)
                                                    data-{{$key}}="{{$value}}"
                                                @endforeach >
                                            </script>
                                            <input type="hidden" custom="{{$data->custom}}" name="hidden">
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
                $('input[type="submit"]').addClass("pay_btn");
            })
        </script>
    @endpush
@endsection




