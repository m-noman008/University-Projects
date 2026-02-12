@extends($theme . 'layouts.user')
@section('title', trans('My Appointment'))
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="search-bar">
                    <form action="{{ route('user.search.appointment') }}" method="get">
                        <div class="row g-3 align-items-end">
                            <div class="input-box col-lg-2">
                                <label for="">@lang('Service Name')</label>
                                <select class="form-select" name="service_name" aria-label="Default select example">
                                    <option value="">@lang('All Service')</option>
                                    @forelse($services as $data)
                                        <option value="{{ $data->id }}"
                                            {{ @request()->service_name == $data->id ? 'selected' : '' }}>@lang(optional($data->serviceDetails)->service_name)
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="input-box col-lg-2">
                                <label for="">@lang('From Appointment Date')</label>
                                <input type="text" class="form-select flatpickr" name="from_date"
                                    placeholder="@lang('Date')" value="{{ @request()->from_date }}" autocomplete="off">
                            </div>
                            <div class="input-box col-lg-2">
                                <label for="">@lang('To Appointment Date')</label>
                                <input type="text" class="form-select flatpickr" name="to_date"
                                    placeholder="@lang('Date')" value="{{ @request()->to_date }}" autocomplete="off">
                            </div>
                            <div class="input-box col-lg-2">
                                <button class="btn-custom w-100"><i class="fal fa-search"></i>@lang('Search')</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-parent table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">@lang('SL No.')</th>
                                <th scope="col">@lang('Service Name')</th>
                                <th scope="col">@lang('Date Of Appointment')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Appointment Time')</th>
                                <th scope="col">@lang('Status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointment_list as $data)
                                <tr>
                                    <td data-label="SL No.">{{ $loop->index + 1 }}</td>
                                    <td data-label="Service Name">
                                        @if (!$data->plan)
                                            @lang(optional(optional($data->service)->serviceDetails)->service_name)
                                        @else
                                            @lang(optional($data->plan)->name . ' ' . 'Plan Services')
                                        @endif
                                    </td>
                                    <td data-label="Date Of Appointment">
                                        @if (!$data->date_of_appointment)
                                            <span>N/A</span>
                                        @else
                                            {{ dateTime($data->date_of_appointment, 'd M Y') }}
                                        @endif
                                    </td>
                                    <td data-label="Appointment Price">
                                        @if(!empty($data->service->price))
                                            {{ $data->service->price }}
                                        @else
                                        <span>N/A</span>
                                        @endif
                                    </td>
                                    <td data-label="Appointment Time">
                                        {{ !empty($data->appointment_time) ? timeFormat($data->appointment_time) : 'N/A' }}
                                    </td>
                                    <td data-label="Status">
                                        @if ($data->status == 0)
                                            <span class="badge bg-warning">@lang('Pending')</span>
                                        @elseif($data->status == 1)
                                            <span class="badge bg-success">@lang('Confirm')</span>
                                        @elseif($data->status == 2)
                                            <span class="badge bg-danger">@lang('Cancel')</span>
                                        @elseif($data->status == 3)
                                            <span class="badge bg-success">Done</span>
                                        @endif
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
                        {{ $appointment_list->links('partials.pagination') }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>

@endsection


@push('script')
    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
                Notiflix.Notify.Failure("{{ trans($error) }}");
            @endforeach
        </script>
    @endif
@endpush
