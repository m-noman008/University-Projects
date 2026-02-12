@extends('admin.layouts.app')
@section('title')
    @lang('Book Appointment List')
@endsection
@section('content')
    <div class="p-2 pt-4 pl-4 m-0 my-4 shadow page-header card card-primary m-md-4 m-md-0">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{ route('admin.search.appointment') }}" method="get">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" name="service_id">
                                    <option value="">@lang('All Service')</option>
                                    @forelse($services as $data)
                                        <option value="{{ $data->id }}"
                                            {{ @request()->service_id == $data->id ? 'selected' : '' }}>@lang(optional($data->serviceDetails)->service_name)
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="full_name" value="{{ @request()->full_name }}"
                                    class="form-control" placeholder="@lang('Full Name')">
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
                                    id="datepicker" />
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
    <div class="p-3 m-0 my-4 shadow card card-primary m-md-4 m-md-0">
        <ul class="nav">
            @php
                $segment = collect(request()->segments())->last();
            @endphp
            <li class="nav-item">
                <a href="{{ route('admin.appointment.list', 'all_list') }}"
                    class="nav-link theme-a {{ $segment == 'all_list' ? 'activeList' : '' }}">@lang('All List')
                    ({{ $countAllAppointment }})</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.appointment.list', 'pending') }}"
                    class="nav-link theme-a {{ $segment == 'pending' ? 'activeList' : '' }}">@lang('Pending')
                    ({{ $countPendingAppointment }})</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.appointment.list', 'confirm') }}"
                    class="nav-link theme-a {{ $segment == 'confirm' ? 'activeList' : '' }}">@lang('Confirm')
                    ({{ $countConfirmAppointment }})</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.appointment.list', 'cancel') }}"
                    class="nav-link theme-a {{ $segment == 'cancel' ? 'activeList' : '' }}">@lang('Cancel')
                    ({{ $countCancelAppointment }})</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.appointment.list', 'done') }}"
                    class="nav-link theme-a {{ $segment == 'done' ? 'activeList' : '' }}">@lang('Done')
                    ({{ $countDoneAppointment }})</a>
            </li>
        </ul>
    </div>



    <div class="m-0 my-4 shadow card card-primary m-md-4 m-md-0">
        <div class="card-body">
            <div class="mb-2 text-right dropdown">
                <button class="btn btn-sm btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span><i class="pr-2 fas fa-bars"></i> @lang('Action')</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <button class="dropdown-item confirm" type="button" data-toggle="modal"
                        data-target="#all_inactive">@lang('Confirm')
                    </button>
                    <button class="dropdown-item cancel" type="button" data-toggle="modal"
                        data-target="#all_inactive">@lang('Cancel')
                    </button>
                    <form id="status-form" method="POST" action="{{ route('admin.done.appointment') }}">
                        @csrf
                        <input type="hidden" name="status" value="done">
                        <input type="hidden" id="str-ids" name="strIds" value="">
                        <button class="dropdown-item done" type="submit" data-toggle="modal"
                            data-target="#all_inactive">Done</button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table categories-show-table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center">
                                <input type="checkbox" class="form-check-input check-all tic-check" name="check-all"
                                    id="check-all">
                                <label for="check-all"></label>
                            </th>
                            <th scope="col">@lang('Service Name')</th>
                            <th scope="col">@lang('Username')</th>
                            <th scope="col">@lang('Message')</th>
                            <th scope="col">@lang('Date Of Appointment')</th>
                            <th scope="col">@lang('Time Of Appointment')</th>
                            <th scope="col">@lang('Status')</th>
                            @if (Auth::user()->role == 'admin')
                            <th scope="col">@lang('Action')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($book_appointment as $item)
                            <tr class="">
                                <td class="text-center">
                                    <input type="checkbox" id="chk-{{ $item->id }}"
                                        class="form-check-input row-tic tic-check" name="check"
                                        value="{{ $item->id }}" data-id="{{ $item->id }}">
                                    <label for="chk-{{ $item->id }}"></label>
                                </td>

                                <td data-label="@lang('Service Name')">
                                    @if (!$item->plan)
                                        @lang(optional(optional($item->service)->serviceDetails)->service_name)
                                    @else
                                        <p class="text-dark font-weight-normal">@lang(optional($item->plan)->name . ' ' . 'Plan Services')</p>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-lg-flex d-block align-items-center ">
                                        <div class="mr-3"><img
                                                src="{{ getFile(config('location.user.path') . optional($item->user)->image) }}"
                                                alt="user" class="rounded-circle" width="45" height="45">
                                        </div>
                                        <div class="">
                                            <h6 class="mb-0 text-dark font-16 font-weight-medium">@lang(optional($item->user)->username)</h6>
                                            <span class="text-muted font-14">@lang(optional($item->user)->email)</span>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="@lang('Message')" scope="col">
                                    <p class="text-dark font-weight-normal">{{ $item->message }}</p>
                                </td>

                                <td data-label="@lang('Date Of Appointment')">
                                    @if ($item->date_of_appointment == null)
                                        <span>N/A</span>
                                    @else()
                                        @lang(dateTime($item->date_of_appointment, 'd M Y'))
                                    @endif
                                </td>

                                <td data-label="@lang('Time Of Appointment')">
                                    @if (empty($item->appointment_time))
                                        <span>N/A</span>
                                    @else
                                        {{-- {{var_dump($item->appointment_time);}} --}}
                                        {{ \Carbon\Carbon::parse($item->appointment_time)->format('h:i A') }}
                                    @endif
                                </td>

                                <td>
                                    @if ($item->status == 0)
                                        <span class="text-white badge bg-warning">@lang('Pending')</span>
                                    @elseif($item->status == 1)
                                        <span class="text-white badge bg-success">@lang('Confirm')</span>
                                    @elseif($item->status == 2)
                                        <span class="text-white badge bg-danger">@lang('Cancel')</span>
                                    @elseif($item->status == 3)
                                        <span class="text-white badge bg-success">Done</span>
                                    @endif
                                </td>
                                @if (Auth::user()->role == 'admin')
                                <td class="book-appointment-action" data-label="@lang('Action')">
                                    <a class="btn btn-sm btn-primary notiflix-confirm" data-id="{{ $item->id }}"
                                        data-route="{{ route('admin.update.time', ['id' => $item->id]) }}"
                                        data-toggle="modal" data-target="#time-update-modal" href="javascript:void(0)">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger notiflix-confirm"
                                        data-route="{{ route('admin.delete.appointment', $item->id) }}"
                                        data-toggle="modal" data-target="#delete-modal" href="javascript:void(0)">
                                        <i class="fa fa-trash-alt"></i>
                                    </a>
                                </td>
                                @endif
                            </tr>

                        @empty
                            <tr>
                                <td colspan="100%">@lang('No Data Found')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $book_appointment->links('partials.pagination') }}
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Delete Confirmation')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to delete this?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="deleteRoute">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @if(isset($item))
    <div id="time-update-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="time-update-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="time-update-modalLabel">@lang('Update Appointment Time')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="{{ route('admin.update.time', ['id' => $item->id]) }}" method="POST"
                    class="timeUpdateRoute" id="updatetime">
                    @csrf
                    @method('PUT') <!-- Method Spoofing for PUT -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="appointmentTime">@lang('New Appointment Time')</label>
                            <input type="time" class="form-control" id="appointmentTime" name="appointment_time"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Save Changes')</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endif
@endsection


@push('js')

    <script>
        "use strict";

        $(document).on('click', '#check-all', function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $('.notiflix-confirm').on('click', function() {
            var route = $(this).data('route');
            $('.deleteRoute').attr('action', route)
        })

        $(document).on('change', ".row-tic", function() {
            let length = $(".row-tic").length;
            let checkedLength = $(".row-tic:checked").length;
            if (length == checkedLength) {
                $('#check-all').prop('checked', true);
            } else {
                $('#check-all').prop('checked', false);
            }
        });

        $('#status-form').on('submit', function() {
            var strIds = $('.row-tic:checked').map(function() {
                return $(this).data('id');
            }).get().join(',');

            $('#str-ids').val(strIds);
        });

        //dropdown menu is not working
        $(document).on('click', '.dropdown-menu', function(e) {
            e.stopPropagation();
        });

        //multiple processing
        $(document).on('click', '.confirm', function(e) {

            e.preventDefault();
            var allVals = [];
            $(".row-tic:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });

            var strIds = allVals;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                url: "{{ route('admin.confirm.appointment') }}",
                data: {
                    strIds: strIds
                },
                datatType: 'json',
                type: "post",
                success: function(data) {
                    location.reload();

                },
            });
        });

        $(document).on('click', '.cancel', function(e) {
            e.preventDefault();
            var allVals = [];
            $(".row-tic:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });

            var strIds = allVals;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                },
                url: "{{ route('admin.cancel.appointment') }}",
                data: {
                    strIds: strIds
                },
                datatType: 'json',
                type: "post",
                success: function(data) {
                    location.reload();

                },
            });
        });

        $(document).ready(function() {
            $('.notiflix-confirm').click(function() {
                var appointmentId = $(this).data('id'); // Get the ID
                var updateRoute = $(this).data('route'); // Get the route if needed

                // Assuming you have an input field with id="appointmentId" inside your modal
                $('#appointmentId').val(appointmentId);

                // If you want to update the form action
                $('#updatetime').attr('action', updateRoute);
            });
        });
        // $(document).on('click', '.done', function(e) {
        // e.preventDefault();
        // var allVals = [];
        // $(".row-tic:checked").each(function() {
        // allVals.push($(this).attr('data-id'));
        // });

        // var strIds = allVals;

        // $.ajax({
        // headers: {
        // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // },
        // url: "{{ route('admin.done.appointment') }}",
        // data: {
        // strIds: strIds
        // },
        // datatType: 'json',
        // type: "post",
        // success: function(data) {
        // location.reload();
        // },

        // error: (function(data) {
        // console.log(data.responseText);
        // console.log(data.responseJSON);
        // })
        // });
        // });
    </script>

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
