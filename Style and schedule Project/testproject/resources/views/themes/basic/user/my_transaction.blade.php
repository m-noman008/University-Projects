@extends($theme.'layouts.user')
@section('title',trans('My Profile'))
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="search-bar">
                    <form action="{{ route('user.transaction.search') }}" method="get">
                        <div class="row g-3 align-items-end">
                            <div class="input-box col-lg-2">
                                <label for="">@lang('Transaction Id')</label>
                                <input type="text" class="form-control" name="transaction_id"
                                       placeholder="@lang('Transaction Id')" value="{{@request()->transaction_id}}"
                                       autocomplete="off">
                            </div>
                            <div class="input-box col-lg-2">
                                <label for="">@lang('Remarks')</label>
                                <input type="text" class="form-control" name="remarks" placeholder="@lang('Remarks')"
                                       value="{{@request()->remarks}}" autocomplete="off">
                            </div>
                            <div class="input-box col-lg-2">
                                <label for="">@lang('Date')</label>
                                <input type="text" class="form-select flatpickr" name="datetrx"
                                       placeholder="@lang('Date')" value="{{ @request()->datetrx }}" autocomplete="off">
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
                            <th scope="col">@lang('Transaction ID')</th>
                            <th scope="col">@lang('Amount')</th>
                            <th scope="col">@lang('Remark')</th>
                            <th scope="col">@lang('Date')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($transactions as $data)
                            <tr>
                                <td data-label="SL No.">{{ $loop->index + 1 }}</td>
                                <td data-label="TRX">
                                    {{ $data->trx_id }}
                                </td>
                                <td data-label="Amount">
                                    @lang(config('basic.currency_symbol'))
                                    {{ $data->amount }}
                                </td>
                                <td data-label="Remarks">
                                    @lang($data->remarks)
                                </td>
                                <td data-label="Status">
                                    {{ dateTime($data->created_at, 'd M Y') }}
                                </td>
                            </tr>
                        @empty
                            <td class="text-center text-danger" colspan="100%">@lang('No Found Data')</td>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        {{ $transactions->links('partials.pagination') }}
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
    </script>
@endpush
