@extends($theme . 'layouts.app')
@section('title', trans($title))
@section('content')
    <section class="all_product_area">
        <div class="container">
            <div class="row g-xl-5 g-4">
                <div class="order-2 col-lg-8 order-lg-1">
                    <div class="product_area">
                        <div class="section_header d-flex justify-content-between align-items-center pb-65">
                            <div class="text_area">
                                <h5>@lang('Showing All Results')</h5>
                            </div>
                            <div class="sorting_area">
                                <select class="form-select select_sorting" aria-label="Default select example">
                                    <option selected>@lang('Default Sorting')</option>
                                    <option value="latest">@lang('Latest')</option>
                                    <option value="low_to_high">@lang('Low to High')</option>
                                    <option value="high_to_low">@lang('High to Low')</option>
                                </select>
                            </div>
                        </div>
                        <div class="section_body">
                            <div class="row g-xl-5">
                                @forelse($all_products as $key => $product)
                                    <div class="col-md-6">
                                        <div class="product_box">
                                            <ul class="transition product_miniature d-flex">
                                                <li>
                                                    <a href="javascript:void(0)" class="wishList"
                                                        data-product="{{ $product->id }}" id="{{ $key }}">
                                                        @if ($product->get_wishlist_count > 0)
                                                            <i class="fas fa-heart save{{ $key }}"></i>
                                                        @else
                                                            <i class="fa-solid fa-heart save{{ $key }}"></i>
                                                        @endif
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="common_btn"
                                                        href="{{ route('product.details', [slug(optional($product->details)->product_name), $product->id]) }}">
                                                        @lang('DETAILS')
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="image_area">
                                                <img src="{{ getFile(config('location.product.path_thumbnail') . $product->thumbnail_image) ?: 'path/to/default/image.jpg' }}"
                                                    alt="{{optional($product->details)->product_name}}">
                                            </div>
                                        </div>
                                        <div class="text-center product_box_footer d-flex justify-content-center">
                                            <div class="section_text">
                                                <h5 class="pb-20">@lang(optional($product->details)->product_name)</h5>
                                                <h5>{{ config('basic.currency_symbol') . number_format($product->price, 2) }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-5 d-flex flex-column justify-content-center">
                                        <h3 class="mt-5 mb-3 text-center">@lang("Product doesn't Available")</h3>
                                        <a href="{{ route('products') }}" class="text-center">
                                            <button class="btn common_btn">@lang('Back')</button>
                                        </a>
                                    </div>
                                @endforelse
                                <div class="pagination_area">
                                    <nav aria-label="...">
                                        <ul class="pagination justify-content-center">
                                            {{ $all_products->links('partials.pagination') }}
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-1 col-lg-4 order-lg-2">
                    <div class="side_bar">
                        <form action="{{ route('product.filter') }}" method="get">
                            <div class="mb-40 search_area d-flex align-items-center">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="@lang('Search Here...')" value="{{ @request()->search }}"
                                        autocomplete="off">
                                    <button type="submit" class="input-group-text hover" id="basic-addon1"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>
                            <div class="mb-40 categories_area cmn_bg_border">
                                <div class="section_header">
                                    <h5 class="mb-20">@lang('Categories')</h5>
                                </div>
                                <ul class="categories_list">
                                    @forelse($product_category as $key => $item)
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="vehicleCat{{ $key }}" name="category_id[]"
                                                    value="{{ $item->id }}" multiple
                                                    @if (request()->category_id) @foreach (request()->category_id as $data)
                                                               @if ($data == $item->id)checked @endif
                                                    @endforeach
                                    @endif
                                    />
                                    <label class="form-check-label" for="vehicleCat{{ $key }}">@lang(optional($item->details)->name)
                                        <span>({{ $item->products_count }})</span></label>
                            </div>
                            </li>
                            @empty
                                @endforelse
                                </ul>
                        </div>

                        @foreach ($productAttribute as $key => $attributes)
                            <div class="mb-40 attribute_area cmn_bg_border">
                                <h5 class="attribute_name">@lang($attributes->name)</h5>
                                <div class="check-box attribute-length">
                                    @foreach ($attributes->attributes as $attrkey => $attr)
                                        <div class="form-check">
                                            <input class="form-check-input attribute-select" name="productAttributes[]"
                                                type="checkbox" value="{{ $attr->id }}"
                                                id="attribute-{{ slug($attr->attributes) }}" multiple
                                                @if (request()->productAttributes) @foreach (request()->productAttributes as $data)
                                                               @if ($data == $attr->id)checked @endif
                                                @endforeach
                                    @endif
                                    />
                                    <label class="form-check-label"
                                        for="attribute-{{ slug($attr->attributes) }}">{{ $attr->attributes }}</label>
                                </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div class="mb-40 price_filter_area cmn_bg_border">
                    <div class="section_header">
                        <h5 class="mb-40">@lang('Filter by Price')</h5>
                        <h6 class="mb-30">@lang('Price') : <span
                                class="highlight">{{ config('basic.currency_symbol') . $min }} -
                                {{ config('basic.currency_symbol') . $max }}</span>
                        </h6>
                    </div>
                    <div class="range_area">
                        <input type="text" class="js_range_slider" name="my_range" value="" data-type="double"
                            data-min="0" data-max="1000" data-from="{{ $min }}" data-to="{{ $max }}"
                            data-grid="false" data-min="false" />
                        <input type="hidden" class="js-input-from" name="minPrice" value="0" readonly />
                        <input type="hidden" class="js-input-to" value="0" name="maxPrice" readonly />
                    </div>
                </div>
                <div class="button_area filter_section">
                    <button type="submit" class="common_btn">@lang('Submit')</button>
                </div>
                </form>
            </div>
            </div>
            </div>
            </div>
        </section>
    @endsection

    @push('script')
        <script>
            'use strict';

            let isAuthenticate = "{{ \Illuminate\Support\Facades\Auth::check() }}";
            let userId = "{{ optional(auth()->user())->id }}";

            $('.wishList').on('click', function() {

                let _this = this.id;
                let user_id = userId;
                let product_id = $(this).data('product');
                if (isAuthenticate == 1) {
                    wishList(user_id, product_id, _this);
                } else {
                    window.location.href = '{{ route('login') }}';
                }
            });

            function wishList(user_id = null, product_id = null, id = null) {
                $.ajax({
                    url: "{{ route('user.wishList') }}",
                    type: "POST",
                    data: {
                        user_id: user_id,
                        product_id: product_id,
                    },
                    success: function(data) {

                        if (data.data == 'added') {
                            $(`.save${id}`).removeClass("fal fa-heart");
                            $(`.save${id}`).addClass("fas fa-heart");
                            Notiflix.Notify.Success(data.addNotify);
                        }
                        if (data.data == 'remove') {
                            $(`.save${id}`).removeClass("fas fa-heart");
                            $(`.save${id}`).addClass("fal fa-heart");
                            Notiflix.Notify.Success(data.removeNotify);
                        }
                    },
                });
            }


            let $range = $(".js-range-slider"),
                $inputFrom = $(".js-input-from"),
                $inputTo = $(".js-input-to"),
                instance,
                min = 0,
                max = {{ $rangeMax }};

            // all_product_area_start range_area
            $(".js_range_slider").ionRangeSlider({
                type: "double",
                min: min,
                max: max,
                from: {{ request('minPrice') ?? $min }},
                to: {{ request('maxPrice') ?? $max }},
                grid: true,
                onStart: updateInputs,
                onChange: updateInputs,
                onFinish: finishInputs
            });

            function updateInputs(data) {
                $inputFrom.prop("value", data.from);
                $inputTo.prop("value", data.to);
            }

            function finishInputs(data) {
                $inputFrom.prop("value", data.from);
                $inputTo.prop("value", data.to);

                setTimeout(function() {
                    $('#searchFormSubmit').submit();
                }, 1000)
            }


            // Sorting Product
            $(".select_sorting").on('change', function() {
                var value = $(this).val()
                if (value) {
                    var route = "{{ route('product.sorting', '') }}" + "/" + value;
                }
                window.location.href = route;
            });
        </script>
    @endpush
