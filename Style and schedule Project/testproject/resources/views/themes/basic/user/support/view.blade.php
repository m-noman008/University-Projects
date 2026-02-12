@extends($theme.'layouts.user')
@section('title',trans($page_title))

@push('style')
    <style>
        button[name="replayTicket"] {
            border-radius: 0;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="support-ticket-section">
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="inbox-wrapper">
                            <!-- top bar -->
                            <div class="top-bar">
                                <div class="col-sm-10">
                                    @if($ticket->status == 0)
                                        <span class="badge bg-warning">@lang('Open')</span>
                                    @elseif($ticket->status == 1)
                                        <span class=" badge bg-success">@lang('Answered')</span>
                                    @elseif($ticket->status == 2)
                                        <span class="badge bg-primary">@lang('Customer Reply')</span>
                                    @elseif($ticket->status == 3)
                                        <span class="badge bg-danger">@lang('Closed')</span>
                                    @endif
                                    [{{trans('Ticket#'). $ticket->ticket }}] {{ $ticket->subject }}
                                </div>
                                <div>
                                    <button class="close-btn" id="infoBtn" data-bs-toggle="modal"
                                            data-bs-target="#closeTicketModal">
                                        <i class="fal fa-close"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- chats -->
                            <div class="chats">
                                @if(count($ticket->messages) > 0)
                                    @foreach($ticket->messages as $item)
                                        @if($item->admin_id == null)
                                            <div class="chat-box this-side">
                                                <div class="text-wrapper">
                                                    <p class="name">{{ __(optional($ticket->user)->username) }}</p>
                                                    <div class="text">
                                                        <p>{{ __($item->message) }}</p>
                                                    </div>
                                                    @if(0 < count($item->attachments))
                                                        @foreach($item->attachments as $k => $image)
                                                            <div class="file">
                                                                <a href="{{ route('user.ticket.download',encrypt($image->id)) }}">
                                                                    <i class="fal fa-file"></i>
                                                                    <span>@lang('File(s)') {{ __(++$k) }}</span>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    <span
                                                        class="time">{{ __($item->created_at->format('d M, Y h:i A')) }}</span>
                                                </div>
                                                <div class="img">
                                                    <img class="img-fluid"
                                                         src="{{getFile(config('location.user.path').optional($ticket->user)->image)}}"
                                                         alt="..."/>
                                                </div>
                                            </div>
                                        @else
                                            <div class="chat-box opposite-side">
                                                <div class="img">
                                                    <img class="img-fluid"
                                                         src="{{getFile(config('location.admin.path').optional($item->admin)->image)}}"
                                                         alt="..."/>
                                                </div>
                                                <div class="text-wrapper">
                                                    <p class="name">{{ __(optional($item->admin)->name) }}</p>
                                                    <div class="text">
                                                        <p>
                                                            {{ __($item->message) }}
                                                        </p>
                                                    </div>
                                                    @if(0 < count($item->attachments))
                                                        @foreach($item->attachments as $k => $image)
                                                            <div class="file">
                                                                <a href="{{ route('user.ticket.download',encrypt($image->id)) }}">
                                                                    <i class="fal fa-file"></i>
                                                                    <span>@lang('File(s)') {{ __(++$k) }}</span>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    <span
                                                        class="time">{{ __($item->created_at->format('d M, Y h:i A')) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <!-- typing area -->
                            <form class="form-row" action="{{ route('user.ticket.reply', $ticket->id)}}"
                                  method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="typing-area">
                                    <div class="img-preview">
                                        <button class="delete">
                                            <i class="fal fa-times" aria-hidden="true"></i>
                                        </button>
                                        <img
                                            id="attachment"
                                            src="{{getFile('local','dummy')}}"
                                            alt=""
                                            class="img-fluid insert"/>
                                    </div>
                                    <div class="input-group">
                                        <div>
                                            <button class="upload-img send-file-btn">
                                                <i class="fal fa-paperclip" aria-hidden="true"></i>
                                                <input
                                                    class="form-control"
                                                    accept="image/*"
                                                    type="file"
                                                    name="attachments[]"
                                                    onchange="previewImage('attachment')"
                                                />
                                            </button>
                                            <p class="text-danger select-files-count"></p>
                                        </div>
                                        <input type="text" name="message" value="{{ old('message') }}"
                                               class="form-control"/>
                                        <button type="submit" name="replayTicket" value="1" class="submit-btn">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="closeTicketModal">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <form method="post" action="{{ route('user.ticket.reply', $ticket->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h4 class="modal-title"> @lang('Confirmation')</h4>
                        <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>@lang('Are you want to close ticket?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-custom" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" name="replayTicket" value="2" class="btn-custom">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        'use strict';
        $(document).on('change', '#upload', function () {
            var fileCount = $(this)[0].files.length;
            $('.select-files-count').text(fileCount + ' file(s) selected')
        })
    </script>
@endpush


