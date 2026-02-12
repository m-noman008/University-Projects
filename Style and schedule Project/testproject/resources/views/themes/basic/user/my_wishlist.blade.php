@extends($theme.'layouts.user')
@section('title',trans('Dashboard'))
@section('content')
    <div class="container-fluid">
        <div class="main row">
            <div class="col-12">
                <div class="search-bar">
                    <form action="{{ route('user.search.wishlist') }}" method="get">
                        <div class="row g-3 align-items-end">
                            <div class="input-box col-lg-2">
                                <label for="">@lang('Product Name')</label>
                                <input type="text" class="form-control" name="product_name"
                                       placeholder="@lang('Product Name')" value="{{@request()->product_name}}"
                                       autocomplete="off">
                            </div>

                            <div class="input-box col-lg-2">
                                <label for="">@lang('Date')</label>
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
                            <th scope="col">@lang('SL No.')</th>
                            <th scope="col">@lang('Product')</th>
                            <th scope="col">@lang('Price')</th>
                            <th scope="col">@lang('Added Date')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($wishlist_data as $data)
                            <tr>
                                <td data-label="SL No.">{{ $loop->index + 1 }}</td>
                                <td data-label="Product">
                                    <span class="currency">
                                          <img
                                              src="{{getFile(config('location.product.path_thumbnail').optional($data->productInfo)->thumbnail_image)}}"
                                              alt="..."
                                          />
                                          @lang(optional(optional($data->productInfo)->trashDetails)->product_name)
                                       </span>

                                </td>
                                <td data-label="Price">
                                    @lang(config('basic.currency_symbol'))
                                    {{ optional($data->productInfo)->price }}
                                </td>
                                <td data-label="Added Date">
                                    {{ dateTime($data->created_at, 'd M Y') }}
                                </td>
                                <td data-label="Action">
                                    <a
                                        href="{{ route('user.my.wishlist.delete', $data->id) }}"
                                        class="">
                                        <i class="fal fa-trash-alt"></i>
                                    </a>
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
                        {{ $wishlist_data->links('partials.pagination') }}
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
