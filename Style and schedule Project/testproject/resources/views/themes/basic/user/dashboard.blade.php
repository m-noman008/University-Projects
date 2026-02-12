@extends($theme . 'layouts.user')
@section('title', trans('Dashboard'))
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="dashboard-heading mt-2">
                    <h2 class="mb-0">@lang('Dashboard')</h2>
                </div>
                @if($planOfServices > 0)
                <div class="bd-callout bd-callout-warning m-0 my-4 m-md-0 ">
                    <i class="fas fa-info-circle mr-2"></i>
                    @lang("You have purchased $planOfServices plans"). @lang('To get all the facilities of your plans.')
                    <span class="text-dark">
                        <a class="text-dark" href="{{ route('user.my.appointment') }}">@lang('Make Appointment')</a>
                    </span>
                </div>
                @endif
                <div class="dashboard-box-wrapper mt-3">
                    <div class="row g-4 mb-4">
                        @plan
                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h4>@lang('Purchase Plan')</h4>
                                <h3>{{ $planCount }}</h3>
                                <i class="fa-thin fa-list"></i>
                            </div>
                        </div>
                        @endplan
                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h4>@lang('Total Wishlist')</h4>
                                <h3>{{ $wishlistCount }}</h3>
                                <i class="fa-sharp fa-regular fa-heart"></i>
                            </div>
                        </div>
                        @shop
                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h4>@lang('Total Order')</h4>
                                <h3>{{ $orderCount }}</h3>
                                <i class="fa-thin fa-cart-plus"></i>
                            </div>
                        </div>
                        @endshop
                        @bookAppointment
                        <div class="col-xl-3 col-md-6 box">
                            <div class="dashboard-box">
                                <h4>@lang('Total Appointment')</h4>
                                <h3>{{ $appointmentCount }}</h3>
                                <i class="fa-thin fa-calendar-check"></i>
                            </div>
                        </div>
                        @endbookAppointment
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="calender">
        <div class="container-fluid">
            <div class="main row gy-5">
                @bookAppointment
                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="card-title">@lang('Upcoming Appointment')</h4>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
                @endbookAppointment
                @shop
                <div class="col-lg-6">
                    <!-- table -->
                    <div class="table-parent table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">@lang('#Order Number')</th>
                                <th scope="col">@lang('Payment Type')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Order Date')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($myOrderData as $data)
                                <tr>
                                    <td data-label="Order Number">
                                        #{{ optional($data->getOrder)->order_number }}
                                    </td>
                                    <td data-label="Payment Type">
                                        @lang(optional(optional($data->getOrder)->gateway)->name ?? optional($data->getOrder)->payment_type)
                                    </td>
                                    <td data-label="Price">
                                        @lang(config('basic.currency_symbol'))
                                        {{ $data->totalAmount }}
                                    </td>
                                    <td data-label="Order Date">
                                        {{ dateTime($data->created_at, 'd M Y') }}
                                    </td>
                                    <td data-label="Status">
                                        @if (optional($data->getOrder)->status == 0)
                                            <span class="badge bg-warning">@lang('Pending')</span>
                                        @elseif(optional($data->getOrder)->status == 1)
                                            <span class="badge bg-primary">@lang('Processing')</span>
                                        @elseif(optional($data->getOrder)->status == 2)
                                            <span class="badge bg-secondary">@lang('On Shipping')</span>
                                        @elseif(optional($data->getOrder)->status == 3)
                                            <span class="badge bg-info">@lang('Ship')</span>
                                        @elseif(optional($data->getOrder)->status == 4)
                                            <span class="badge bg-success">@lang('Completed')</span>
                                        @elseif(optional($data->getOrder)->status == 5)
                                            <span class="badge bg-danger">@lang('Cancel')</span>
                                        @endif
                                    </td>
                                    <td data-label="Action">
                                        <a href="{{ route('user.my.order.details', $data->order_id) }}" class="">
                                            <i class="fa-sharp fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <td class="text-center text-danger" colspan="100%">@lang('No User Data')</td>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            {{ $myOrderData->links('partials.pagination') }}
                        </ul>
                    </nav>
                </div>
                @endshop
            </div>
        </div>
    </div>

@endsection


@push('script')
    <script defer>
        "use strict";
        $('#calendar').fullCalendar({
            themeSystem: 'bootstrap4',
            header: {
                left: 'today',
                center: 'prev title next',
                right: 'month,basicWeek,basicDay'
            },
            defaultDate: "{{ $appointment }}",
            editable: false,
            eventLimit: true,
            events: "{{ route('user.my.book.appointment') }}",
            eventColor: "#1c2d41",
            height: 500,
        });
    </script>
@endpush
