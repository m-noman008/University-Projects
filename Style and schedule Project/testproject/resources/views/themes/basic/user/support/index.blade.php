@extends($theme.'layouts.user')
@section('title',__($page_title))

@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="dashboard-heading">
                    <h4 class="card-title">@lang($page_title)</h4>
                    <a href="{{route('user.ticket.create')}}" class="btn-custom">
                        Create Ticket
                    </a>
                </div>
                <div class="table-parent table-responsive mt-2">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">@lang('Subject')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Last Reply')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tickets as $key => $ticket)
                            <tr>
                                <td data-label="@lang('Subject')">
                                    <span class="font-weight-bold"> [{{ trans('Ticket#').$ticket->ticket }}
                                                        ] {{ $ticket->subject }}
                                    </span>
                                </td>
                                <td data-label="@lang('Status')">
                                    @if($ticket->status == 0)
                                        <span
                                            class="badge badge-pill badge-success">@lang('Open')</span>
                                    @elseif($ticket->status == 1)
                                        <span
                                            class="badge badge-pill badge-primary">@lang('Answered')</span>
                                    @elseif($ticket->status == 2)
                                        <span
                                            class="badge badge-pill badge-warning">@lang('Replied')</span>
                                    @elseif($ticket->status == 3)
                                        <span class="badge badge-pill badge-dark">@lang('Closed')</span>
                                    @endif
                                </td>

                                <td data-label="@lang('Last Reply')">
                                    {{diffForHumans($ticket->last_reply) }}
                                </td>

                                <td data-label="@lang('Action')">
                                    <a href="{{ route('user.ticket.view', $ticket->ticket) }}"
                                       class="btn btn-sm btn-primary"
                                       data-toggle="tooltip" title="" data-original-title="Details">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="100%">{{__('No Data Found!')}}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
