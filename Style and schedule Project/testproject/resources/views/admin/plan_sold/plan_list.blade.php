@extends('admin.layouts.app')
@section('title')
    @lang('Book Appointment List')
@endsection
@section('content')
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-2 pt-4 pl-4 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{ route('admin.search.plan.sold') }}" method="get">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" name="plan_id">
                                    <option value="">@lang('All Plans')</option>
                                    @forelse($plans as $plan)
                                        <option value="{{ $plan->id }}"
                                            {{ @request()->plan_id == $plan->id ? 'selected' : '' }}>@lang($plan->name)
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="user_name" value="{{ @request()->user_name }}"
                                       class="form-control" placeholder="@lang('User Name')">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="email" value="{{ @request()->email }}" class="form-control"
                                       placeholder="@lang('Email')">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="date" class="form-control" name="date" value="{{ @request()->date }}"
                                       id="datepicker"/>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn waves-effect waves-light btn-primary"><i
                                        class="fas fa-search"></i> @lang('Search')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('Plan Name')</th>
                        <th scope="col">@lang('User Name')</th>
                        <th scope="col">@lang('Purchase Date')</th>
                        <th scope="col">@lang('Date Of Appointment')</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($plan_sold as $item)
                        <tr class="">
                            <td data-label="@lang('Plan Name')">
                                @lang(optional($item->plans)->name)
                            </td>
                            <td>
                                <div class="d-lg-flex d-block align-items-center ">
                                    <div class="mr-3"><img
                                            src="{{ getFile(config('location.user.path') . optional($item->users)->image) }}"
                                            alt="user" class="rounded-circle" width="45" height="45"></div>
                                    <div class="">
                                        <h6 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($item->users)->username)</h6>
                                        <span class="text-muted font-14">@lang(optional($item->users)->email)</span>
                                    </div>
                                </div>
                            </td>
                            <td data-label="@lang('Purchase Date')">
                                @lang(dateTime($item->purchase_date, 'd M Y'))
                            </td>
                            <td data-label="@lang('Date Of Appointment')">
                                @if(optional($item->bookAppointment)->date_of_appointment)
                                    <span class="badge badge-success">Given</span>
                                @else
                                    <span class="badge badge-warning">Not yet</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">@lang('No Data Found')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $plan_sold->links('partials.pagination') }}
        </div>
    </div>
@endsection


@push('js')

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
