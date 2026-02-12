@extends($theme.'layouts.user')
@section('title',trans('Order List'))
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="search-bar">
                    <form action="{{ route('user.order.search') }}" method="get">
                        <div class="row g-3 align-items-end">
                            <div class="input-box col-lg-2">
                                <label for="">@lang('Order Number')</label>
                                <input type="text" class="form-control" name="order_number"
                                       placeholder="@lang('Order Number')" value="{{@request()->order_number}}"
                                       autocomplete="off">
                            </div>

                            <div class="input-box col-lg-2">
                                <label for="">@lang('Payment Type')</label>
                                <input type="text" class="form-control" name="payment_type"
                                       placeholder="@lang('Payment Type')" value="{{@request()->payment_type}}"
                                       autocomplete="off">
                            </div>
                            <div class="input-box col-lg-2">
                                <label for="">@lang('Order Date')</label>
                                <input type="text" class="form-select flatpickr" name="date" placeholder="@lang('Date')"
                                       value="{{@request()->date}}" autocomplete="off">
                            </div>
                            <div class="input-box col-lg-2">
                                <button class="btn-custom w-100"><i class="fal fa-search"></i> @lang('Search')</button>
                            </div>
                        </div>
                    </form>
                </div>
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
                        @if($data->getOrder->user_id == auth()->id())
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
                                    @if(optional($data->getOrder)->status == 0)
                                        <span class="badge bg-warning">@lang('Pending')</span>
                                    @elseif(optional($data->getOrder)->status == 1)
                                        <span class="badge bg-primary">@lang('Processing')</span>
                                    @elseif(optional($data->getOrder)->status == 2)
                                        <span class="badge bg-secondary">@lang('On Shipping')</span>
                                    @elseif(optional($data->getOrder)->status == 4)
                                        <span class="badge bg-success">@lang('Completed')</span>
                                    @elseif(optional($data->getOrder)->status == 5)
                                        <span class="badge bg-danger">@lang('Cancel')</span>
                                    @endif
                                </td>
                                <td data-label="Action">
                                    <a
                                        href="{{ route('user.my.order.details', $data->order_id) }}"
                                        class="">
                                        <i class="fa-sharp fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endif
                        @empty
                            <td class="text-center text-danger" colspan="100%">@lang('No Found Data')</td>
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
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        $(".flatpickr").flatpickr();
        console.log(@json($myOrderData).data);
    </script>


@endpush
