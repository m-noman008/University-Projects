@extends($theme.'layouts.user')
@section('title',trans('My Profile'))
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="search-bar">
                    <form action="{{ route('user.search.plan') }}" method="get">
                        <div class="row g-3 align-items-end">
                            <div class="input-box col-lg-2">
                                <label for="">@lang('Plan Name')</label>
                                <select class="form-select" name="plan_id" aria-label="Default select example">
                                    <option value="">@lang('All Plans')</option>
                                    @forelse($plans as $plan)
                                        <option
                                            value="{{ $plan->id }}" {{ @request()->plan_id == $plan->id ? 'selected' : '' }}>@lang($plan->name)</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="input-box col-lg-2">
                                <label for="">@lang('Purchase Date')</label>
                                <input type="text" class="form-select flatpickr" name="purchase_date"
                                       value="{{ @request()->purchase_date }}" autocomplete="off">
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
                            <th scope="col">@lang('SL No.')</th>
                            <th scope="col">@lang('Plan Name')</th>
                            <th scope="col">@lang('Price')</th>
                            <th scope="col">@lang('Purchase Date')</th>
                            <th scope="col">@lang('Status')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($myPlanPurchase as $data)
                            <tr>
                                <td data-label="SL No.">{{ $loop->index + 1 }}</td>
                                <td data-label="Plan Name">
                                    @lang(optional($data->plans)->name)
                                </td>
                                <td data-label="Price">
                                    @lang(config('basic.currency_symbol'))
                                    {{ optional($data->plans)->price }}
                                </td>
                                <td data-label="Purchase Date">{{ dateTime($data->purchase_date, 'd M Y') }}</td>
                                <td data-label="Date Of Appointment">
                                    @if(optional($data->bookAppointment)->date_of_appointment)
                                        <span class="badge bg-danger">@lang('Given')</span>
                                    @else
                                        <span class="badge bg-warning">@lang('Not yet')</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <td class="text-center text-danger" colspan="100%">@lang('No Found Data')</td>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        'use strict';
        $(".flatpickr").flatpickr();
    </script>
@endpush
