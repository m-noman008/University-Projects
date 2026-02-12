@extends('admin.layouts.app')
@section('title')
    @lang('Basic Controls')
@endsection
@section('content')

    <div class="m-0 my-4 bd-callout bd-callout-warning m-md-4 m-md-0 ">
        <i class="mr-2 fas fa-info-circle"></i> @lang("If you get 500(server error) for some reason, please turn on <b>Debug Mode</b> and try again. Then you can see what was missing in your system.")
    </div>
    <div class="m-0 my-4 shadow card card-primary m-md-4 m-md-0">
        <div class="card-body">
            <form method="post" action="" class="needs-validation base-form">
                @csrf
                <div class="row">
                    <div class="form-group col-md-3">
                        <label class="text-dark">@lang('Site Title')</label>
                        <input type="text" name="site_title"
                               value="{{ old('site_title') ?? $control->site_title ?? 'Site Title' }}"
                               class="form-control ">

                        @error('site_title')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="form-group col-md-3">
                        <label class="text-dark">@lang('Base Color')</label>
                        <input type="color" name="base_color"
                               value="{{ old('base_color') ?? $control->base_color ?? '#6777ef' }}"
                               required="required" class="form-control ">
                        @error('base_color')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group col-md-3">
                        <label class="text-dark">@lang('Time Zone')</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="time_zone">
                            <option hidden>{{ old('time_zone', $control->time_zone)?? 'Select Time Zone' }}</option>
                            @foreach ($control->time_zone_all as $time_zone_local)
                                <option value="{{ $time_zone_local }}">@lang($time_zone_local)</option>
                            @endforeach
                        </select>

                        @error('time_zone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group col-sm-3 col-12">
                        <label class="text-dark">@lang('Base Currency')</label>
                        <input type="text" name="currency" value="{{ old('currency') ?? $control->currency ?? 'USD' }}"
                               required="required" class="form-control ">

                        @error('currency')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-3 col-12">
                        <label class="text-dark">@lang('Currency Symbol')</label>
                        <input type="text" name="currency_symbol"
                               value="{{ old('currency_symbol') ?? $control->currency_symbol ?? '$' }}"
                               required="required" class="form-control ">

                        @error('currency_symbol')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-3 col-12">
                        <label class="text-dark">@lang('Fraction number')</label>
                        <input type="text" name="fraction_number"
                               value="{{ old('fraction_number') ?? $control->fraction_number ?? '2' }}"
                               required="required" class="form-control ">
                        @error('fraction_number')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-3 col-12">
                        <label class="text-dark">@lang('Paginate Per Page')</label>
                        <input type="text" name="paginate" value="{{ old('paginate') ?? $control->paginate ?? '2' }}"
                               required="required" class="form-control ">
                        @error('paginate')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>





                    <div class="form-group col-sm-6 col-md-4 col-lg-3 ">
                        <label class="text-dark">@lang('Strong Password')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='strong_password'>
                            <input type="checkbox" name="strong_password" class="custom-switch-checkbox"
                                   id="strong_password"
                                   value="0" {{($control->strong_password == 0) ? 'checked' : ''}} >
                            <label class="custom-switch-checkbox-label" for="strong_password">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 col-md-4 col-lg-3 ">
                        <label class="text-dark">@lang('Registration')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='registration'>
                            <input type="checkbox" name="registration" class="custom-switch-checkbox"
                                   id="registration"
                                   value="0" {{($control->registration == 0) ? 'checked' : ''}} >
                            <label class="custom-switch-checkbox-label" for="registration">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>



                    <div class="form-group col-lg-3 col-md-6">
                        <label class="text-dark">@lang('Cron Set Up Pop Up')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='cron_set_up_pop_up'>
                            <input type="checkbox" name="cron_set_up_pop_up" class="custom-switch-checkbox"
                                   id="cron_set_up_pop_up"
                                   value="0" <?php if ($control->is_active_cron_notification == 0):echo 'checked'; endif ?> >
                            <label class="custom-switch-checkbox-label" for="cron_set_up_pop_up">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-sm-3 ">
                        <label class="text-dark">@lang('Debug Mode')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='error_log'>
                            <input type="checkbox" name="error_log" class="custom-switch-checkbox"
                                   id="error_log"
                                   value="0" <?php if ($control->error_log == 0):echo 'checked'; endif ?> >
                            <label class="custom-switch-checkbox-label" for="error_log">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-sm-12 ">
                        <h4 class="font-weight-bold text-dark">@lang('Section Active')</h4>
                    </div>

                    <div class="form-group col-sm-6 col-md-4 col-lg-3 ">
                        <label class="text-dark">@lang('Shop')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='shop'>
                            <input type="checkbox" name="shop" class="custom-switch-checkbox"
                                   id="shop"
                                   value="0" {{($control->shop == 0) ? 'checked' : ''}} >
                            <label class="custom-switch-checkbox-label" for="shop">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-sm-6 col-md-4 col-lg-3 ">
                        <label class="text-dark">@lang('Faq')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='faq'>
                            <input type="checkbox" name="faq" class="custom-switch-checkbox"
                                   id="faq"
                                   value="0" {{($control->faq == 0) ? 'checked' : ''}} >
                            <label class="custom-switch-checkbox-label" for="faq">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-sm-6 col-md-4 col-lg-3 ">
                        <label class="text-dark">@lang('Book Appointment')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='book_appointment'>
                            <input type="checkbox" name="book_appointment" class="custom-switch-checkbox"
                                   id="book_appointment"
                                   value="0" {{($control->book_appointment == 0) ? 'checked' : ''}} >
                            <label class="custom-switch-checkbox-label" for="book_appointment">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-sm-6 col-md-4 col-lg-3 ">
                        <label class="text-dark">@lang('Gallery')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='gallery'>
                            <input type="checkbox" name="gallery" class="custom-switch-checkbox"
                                   id="gallery"
                                   value="0" {{($control->gallery == 0) ? 'checked' : ''}} >
                            <label class="custom-switch-checkbox-label" for="gallery">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-sm-6 col-md-4 col-lg-3 ">
                        <label class="text-dark">@lang('Team')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='team'>
                            <input type="checkbox" name="team" class="custom-switch-checkbox"
                                   id="team"
                                   value="0" {{($control->team == 0) ? 'checked' : ''}} >
                            <label class="custom-switch-checkbox-label" for="team">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group col-sm-6 col-md-4 col-lg-3 ">
                        <label class="text-dark">@lang('Service')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='service'>
                            <input type="checkbox" name="service" class="custom-switch-checkbox"
                                   id="service"
                                   value="0" {{($control->service == 0) ? 'checked' : ''}} >
                            <label class="custom-switch-checkbox-label" for="service">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>


                    <div class="form-group col-sm-6 col-md-4 col-lg-3 ">
                        <label class="text-dark">@lang('Plan')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='plan'>
                            <input type="checkbox" name="plan" class="custom-switch-checkbox"
                                   id="plan"
                                   value="0" {{($control->plan == 0) ? 'checked' : ''}} >
                            <label class="custom-switch-checkbox-label" for="plan">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>

                </div>


                <button type="submit" class="mt-3 btn waves-effect waves-light btn-rounded btn-primary btn-block"><span><i
                            class="pr-2 fas fa-save"></i> @lang('Save Changes')</span></button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";
        $(document).ready(function () {
            $('select').select2({
                selectOnClose: true
            });
        });
    </script>
@endpush
