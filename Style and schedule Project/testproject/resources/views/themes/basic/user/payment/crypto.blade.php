@extends($theme.'layouts.user')
@section('title')
    {{ 'Pay with '.optional($order->gateway)->name ?? '' }}
@endsection


@section('content')

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
                                <h4> @lang('PLEASE SEND EXACTLY') <span
                                        class="text-success"> {{ getAmount($data->amount) }}</span> {{$data->currency}}
                                </h4>
                                <h5>@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>

                                <img class="w-50" src="{{$data->img}}" alt="..">

                                <h4 class="text-success mt-3 font-weight-bold">@lang('SCAN TO SEND')</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

