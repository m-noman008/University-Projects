@extends($theme.'layouts.user')
@section('title',__($page_title))

@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <section class="profile-setting">
                    <div class="sidebar-wrapper">
                        <form class="form-row" action="{{route('user.ticket.store')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="col-md-12">
                                <div class="input-box col-md-12">
                                    <label>@lang('Subject')</label>
                                    <input class="form-control" type="text" name="subject"
                                           value="{{old('subject')}}" placeholder="@lang('Enter Subject')">
                                    @error('subject')
                                    <div class="error text-danger">@lang($message) </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="input-box col-md-12">
                                    <label>@lang('Message')</label>
                                    <textarea class="form-control ticket-box" name="message" rows="5"
                                              id="textarea1"
                                              placeholder="@lang('Enter Message')">{{old('message')}}</textarea>
                                    @error('message')
                                    <div class="error text-danger">@lang($message) </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="input-box col-md-12">
                                    <input type="file" name="attachments[]"
                                           class="form-control "
                                           multiple
                                           placeholder="@lang('Upload File')">
                                    @error('attachments')
                                    <span class="text-danger">{{trans($message)}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <button type="submit"
                                            class="btn-custom">
                                        <span>@lang('Submit')</span></button>

                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection
