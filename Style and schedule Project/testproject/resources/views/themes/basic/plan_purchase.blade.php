@extends($theme . 'layouts.app')
@section('title', trans('Plan Purchase'))
@section('content')
    <section class="plan_payment_section mt-5 mb-5">
        <div class="container">
            <div class="main row g-4">
                <div class="col-lg-8">
                    <div class="payment-methods">
                        <form action="{{ route('user.plan.payment') }}" method="post">
                            @csrf
                            <div class="row gy-4 gx-3">
                                <div class="col-12">
                                    <h4>@lang('Select Payment Method')</h4>
                                    <div class="payment-box mb-4">
                                        <div class="payment-options">
                                            <div class="row g-2">
                                                @foreach ($gateways as $key => $gateway)
                                                    <div class="col-4 col-md-3 col-xl-2">
                                                        <input type="radio" class="btn-check" name="options"
                                                               id="option{{ $gateway->id }}" autocomplete="off"/>
                                                        <input type="hidden" name="gateway" value="">
                                                        <label class="paymentCheck" id="{{ $key }}"
                                                               data-gateway="{{ $gateway->id }}"
                                                               data-payment="{{ $gateway->id }}"
                                                               data-plan="{{ $id }}" for="option{{ $gateway->id }}">
                                                            <img class="img-fluid custom___img"
                                                                 src="{{ asset(getFile(config('location.gateway.path') . $gateway->image)) }}"
                                                                 alt="gateway image"/>
                                                            <i class="fa-solid fa-check check custom___check tag d-none"
                                                               id="circle{{ $key }}"></i>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input class="form-control" name="plan_id" type="hidden"
                                                   value="{{ $id }}" placeholder=""/>
                                        </div>
                                    </div>
                                    <button class="btn-custom pay_now">@lang('Pay now')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="plan-side-bar mt-5">
                        <div class="plan-side-box m-0">
                            <h4>@lang('Checkout Summary')</h4>
                            <ul>
                                <li>@lang('Plan Price') <span class="plan_price"></span></li>
                                <li>@lang('Conversation Rate')<span class="conversation_rate"></span></li>
                                <li>@lang('Percentage  Charge')<span class="percentage_charge"></span></li>
                                <li>@lang('Fixed Charge')<span class="fixed_charge"></span></li>
                                <li>@lang('Total Amount')<span class="total_amount"></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



@push('script')
    <script>
        'use strict';

        $(document).on('click', '.paymentCheck', function () {
            var id = this.id;
            $('.tag').not(this).addClass('d-none');
            $(`#circle${id}`).removeClass("d-none");

            let planId = $(this).data('plan');
            let paymentId = $(this).data('payment');

            $("input[name='gateway']").val($(this).data('gateway'));

            $('.paymentCheck').not(this).removeClass('paymentActive');
            $(`#${id}`).addClass("paymentActive");


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('user.get.payment.info') }}",
                data: {
                    paymentId: paymentId,
                    planId: planId,
                },
                datatType: 'json',
                type: "POST",
                success: function (data) {

                    let planPrice = parseFloat(data.data.planInfo.price).toFixed(2);
                    let conventionRate = parseFloat(data.data.paymentGatewayInfo.convention_rate)
                        .toFixed(2);
                    let percentageCharge = parseFloat(data.data.paymentGatewayInfo.percentage_charge)
                        .toFixed(2);
                    let fixedCharge = parseFloat(data.data.paymentGatewayInfo.fixed_charge).toFixed(2);
                    let totalAmount = parseFloat(planPrice) + parseFloat(conventionRate) + parseFloat(
                        percentageCharge) + parseFloat(fixedCharge);
                    totalAmount = parseFloat(totalAmount).toFixed(2);


                    let symbol = "{{ trans($basic->currency_symbol) }}";
                    $('.plan_price').text(`${symbol} ${planPrice}`);
                    $('.conversation_rate').text(`${symbol} ${conventionRate}`);
                    $('.percentage_charge').text(`${symbol} ${percentageCharge}`);
                    $('.fixed_charge').text(`${symbol} ${fixedCharge}`);
                    $('.total_amount').text(`${symbol} ${totalAmount}`);
                }
            });

        });
    </script>
@endpush
