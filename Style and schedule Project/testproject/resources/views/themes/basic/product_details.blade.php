@extends($theme.'layouts.app')
@section('title', trans($title))
@section('content')
    <section class="single_product_area">
        <div class="container">
            <div class="row g-md-5 g-4">
                <div class="col-md-6" data-aos="fade-left">
                    <div class="section_left">
                        <div class="image_area single_product_slider">
                            @if($product_details->slider_image)
                                @forelse ($product_details->slider_image as $img)
                                    <img src="{{ getFile(config('location.product.path_slider').$img) ?: '' }}" alt="No Image Available">
                                @empty
                                <img src="{{ getFile(config('location.product.path_thumbnail') . $product_details->thumbnail_image) ?: '' }}"
                                                    alt="No image is available">
                                @endforelse
                            @endif
                        </div>
                        <div class="thumb_area single_product_thumbnail">
                            @if($product_details->slider_image)
                                @forelse ($product_details->slider_image as $img)
                                    <div class="image_area ">
                                        <img src="{{ getfile(config('location.product.path_slider').$img) ?: '' }}">
                                    </div>
                                @empty
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-right">
                    <div class="section_right pt-30">
                        <div class="section_header">
                            <h2>@lang(optional($product_details->details)->product_name)</h2>
                            <h4 class="mb-30">@lang('Price')
                                : {{ config('basic.currency_symbol') . number_format($product_details->price, 2) }}</h4>

                            @if(isset($templates['business-policy'][0]) && $openShop = $templates['business-policy'][0])
                            <h6 class="mb-20">
                                <span class="policy_icon">
                                    <i class="fas fa-undo product-icon"></i>
                                </span>
                                @lang(optional($openShop->description)->delivery_policy)
                            </h6>
                            <h6 class="pb-15">
                                <span class="cash_icon"><i class="fas fa-dollar-sign product-icon"></i></span>
                                @lang(optional($openShop->description)->return_policy)
                            </h6>
                            @endif
                        </div>
                        <hr>
                        <div class="section_body">
                            <p class="pb-20 pt-15"> @lang(optional($product_details->details)->description)</p>
                            <div class="mb-30">
                                @foreach($product_details->attribute_details as $key => $attributes)
                                    <div class="mt-4 size_details d-flex align-items-center attribute-length">
                                        <h5 class="attributeName pe-3">@lang($attributes->name):</h5>
                                        @foreach($attributes->attributes as $attrkey => $attr)
                                            <div class="form-check form-check-inline mt-9">
                                                <input class="form-check-input attribute-select ab" type="radio"
                                                       name="inlineRadioOptions{{ $key }}"
                                                       id="{{slug($attr->attributes)}}"
                                                       value="{{$attr->id}}" {{ $attrkey == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                       for="{{slug($attr->attributes)}}">{{$attr->attributes}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 mb-5 stockMessage">
                                <span class="stock" id="stock">
                                    <i class="fa fa-spinner fa-spin loader" aria-hidden="false"></i>
                                </span>
                            </div>
                            <div class="in_de_counter_area d-flex mb-30">
                                <button onclick="decrement()" class="counter">-</button>
                                <span id="counting"></span>
                                <button onclick="increment()" class="counter">+</button>
                            </div>
                            <ul class="transition product_miniature d-flex">
                                <li>
                                    <a href="javascript:void(0)" class="wishList"
                                       data-product="{{ $product_details->id }}" id="">
                                        @if($product_details->get_wishlist_count > 0)
                                            <i class="fas fa-heart save"></i>
                                        @else
                                            <i class="fa-solid fa-heart save"></i>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <button type="button" data-id="{{$product_details->id}}"
                                            data-name="{{optional($product_details->details)->product_name}}"
                                            data-price="{{$product_details->price}}"
                                            data-image="{{getFile(config('location.product.path_thumbnail').$product_details->thumbnail_image)}}"
                                            data-currency="{{config('basic.currency_symbol')}}"
                                            data-route="{{route('get.product.attributes.name')}}"
                                            data-attributes=""
                                            data-quantity="1" class="common_btn add-to-cart">@lang('ADD TO CART')
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="tabs_area mt-60">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                                    type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                                @lang('Description')
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile-tab-pane"
                                    type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                                @lang('Reviews') ({{optional($product_details->ratings)->count()}})
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                             tabindex="0">
                            <div class="description_area">
                                @lang(optional($product_details->details)->description)
                            </div>
                        </div>
                        <div class="tab-pane fade accordion accordionExample" id="profile-tab-pane"
                             role="tabpanel"
                             aria-labelledby="profile-tab" tabindex="0">
                            <div class="comment_area accordion-item">
                                <div class="comment" data-aos="fade-up">
                                    <div class="mt-40 section_header">
                                        <h4>{{ optional($product_details->ratings)->count() }} @lang('Reviews')</h4>
                                    </div>
                                    @forelse($product_details->ratings as $key => $rate)
                                        <div class="mt-20 comment_inner d-flex">
                                            <div class="image_area">
                                                <img class="w-50"
                                                    src="{{getFile(config('location.user.path').optional($rate->ratingable)->image) }}"
                                                    alt="user_image">
                                            </div>
                                            <div class="text_area">
                                                <h5 class="mb-2 d-flex justify-content-between accordion-header"
                                                    id="headingOne">
                                                    @lang(optional($rate->ratingable)->username)
                                                </h5>
                                                @if(Auth::guard('admin')->check())
                                                    <span class="accordion-button reply-btn" type="button"
                                                          data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}"
                                                          aria-expanded="true" aria-controls="collapseOne">
                                                        <i class="fal fa-reply"></i> @lang('Reply')
                                                    </span>
                                                @endif
                                                <span
                                                    class="highlight">{{ dateTime($rate->created_at, 'd M Y') }}</span>
                                                <p>
                                                    @lang($rate->review)
                                                </p>
                                                {{-- <div class="reply_area mt-30 mb-15 d-flex">
                                                    <div class="image_area">
                                                        <img
                                                            src="{{getFile(config('location.user.path').optional($rate->ratingable)->image) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="text_area mb-25">
                                                        <h5 class="mb-2 d-flex justify-content-between reply_text">
                                                            @lang(optional(optional($rate->reply)->ratingable)->username)
                                                        </h5>
                                                        <span
                                                            class="highlight">{{ dateTime($rate->created_at, 'd M Y') }}</span>
                                                        <p>
                                                            @lang(optional($rate->reply)->review)
                                                        </p>
                                                    </div>
                                                </div> --}}
                                                @if(Auth::guard('admin')->check() && $isReplyExists <= 0 )
                                                    <div id="collapse{{$key}}" class="accordion-collapse collapse show"
                                                         aria-labelledby="headingOne"
                                                         data-bs-parent="#accordionExample">
                                                        <form action="{{ route('reply',$rate->id) }}" method="post">
                                                            @csrf
                                                            <div class="mb-20 accordion-body reply_box">
                                                                <textarea class="form-control rounded-0" name="reply"
                                                                          id="exampleFormControlTextarea1" rows="5"
                                                                          cols="110"></textarea>
                                                            </div>
                                                            <input type="hidden" name="product_id"
                                                                   value="{{ $product_details->id }}">
                                                            <button type="submit"
                                                                    class="mb-10 common_btn">@lang('POST REPLY')</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            @if($isRatingExists <= 0)
                                <div class="mt-4 start_review_area" data-aos="fade-up">
                                    <div class="section_header">
                                        <h4>@lang('Add A Review')</h4>
                                    </div>
                                    <form action="{{ route('user.add.review.rating') }}" method="post">
                                        @csrf
                                        <div class="form_area">
                                            <div class="mb-1 raitng_review d-flex align-items-center">
                                                <div id="half-stars-example">
                                                    <div class="rating-group">
                                                        <input
                                                            class="rating__input rating__input--none"
                                                            checked=""
                                                            name="rating"
                                                            id="rating2-0"
                                                            value="0"
                                                            type="radio"/>
                                                        <label aria-label="0 stars" class="rating__label"
                                                               for="rating2-0">&nbsp;</label>
                                                        <label aria-label="1 star" class="rating__label"
                                                               for="rating2-10"><i class="rating__icon rating__icon--star fa fa-star"
                                                            aria-hidden="true"></i></label>
                                                        <input
                                                            class="rating__input"
                                                            name="rating"
                                                            id="rating2-10"
                                                            value="1"
                                                            type="radio"/>
                                                        <label aria-label="2 stars" class="rating__label"
                                                               for="rating2-20"><i class="rating__icon rating__icon--star fa fa-star"
                                                            aria-hidden="true"></i></label>
                                                        <input
                                                            class="rating__input"
                                                            name="rating"
                                                            id="rating2-20"
                                                            value="2"
                                                            type="radio"/>
                                                        <label aria-label="3 stars" class="rating__label"
                                                               for="rating2-30"><i class="rating__icon rating__icon--star fa fa-star"
                                                            aria-hidden="true"></i></label>
                                                        <input
                                                            class="rating__input"
                                                            name="rating"
                                                            id="rating2-30"
                                                            value="3"
                                                            type="radio"/>
                                                        <label aria-label="4 stars" class="rating__label"
                                                               for="rating2-40"><i class="rating__icon rating__icon--star fa fa-star" aria-hidden="true"></i>
                                                        </label>
                                                        <input
                                                            class="rating__input"
                                                            name="rating"
                                                            id="rating2-40"
                                                            value="4"
                                                            type="radio"
                                                        />
                                                        <label aria-label="5 stars" class="rating__label"
                                                               for="rating2-50"><i class="rating__icon rating__icon--star fa fa-star"
                                                            aria-hidden="true"></i></label>
                                                        <input
                                                            class="rating__input"
                                                            name="rating"
                                                            id="rating2-50"
                                                            value="5"
                                                            type="radio"
                                                        /><br>
                                                    </div>
                                                    <div>
                                                        @error('rating')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div>
                                                    <label for="exampleFormControlTextarea2"
                                                           class="form-label mt-30">@lang('Comment')
                                                        <span
                                                            class="highlight">*</span></label>
                                                    <textarea class="form-control" name="comment"
                                                              id="exampleFormControlTextarea2"
                                                              rows="10"></textarea>
                                                    @error('comment')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <input type="hidden" name="product_id"
                                                       value="{{ $product_details->id }}">
                                            </div>
                                            <button type="submit" class="common_btn mt-30">@lang('SUBMIT')</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        'use script';
        var data = 1;
        var stockQty = 0;
        document.getElementById("counting").innerText = data;

        function increment() {
            data = parseInt(data + 1);
            document.getElementById("counting").innerText = data;
            if (data >= stockQty) {
                Notiflix.Notify.Warning("@lang('Out Of Stock')");
                data = parseInt(data - 1);
            } else {
                $('.add-to-cart').data('quantity', data);
            }

        }

        function decrement() {
            if (data > 1) {
                data = data - 1;
                document.getElementById("counting").innerText = data;
                $('.add-to-cart').data('quantity', data);
            }

        }


        // Check Product Attributes Quantity
        $(".attribute-select").on('change', function () {
            $('#stock').html(`<i class="fa fa-spinner fa-spin loader" aria-hidden="false"></i>`)
            getStock();
        });

        function getStock() {
            let selectedIds = [];
            let attributeLength = $('.attribute-length').length;
            let productId = '{{ $id }}';

            $($(".attribute-select:checked")).each(function (key, value) {
                selectedIds.push($(value).val());
                $('.add-to-cart').data('attributes', selectedIds);
            });

            if (selectedIds.length != attributeLength) {
                return false;
            }

            $.ajax({
                url: "{{ route('get.product.stock.info') }}",
                method: "get",
                data: {
                    productId: productId,
                    attributeIds: selectedIds,
                },
                success: function (res) {
                    stockQty = res.stock;
                    if (res.message) {
                        $('#stock').html(`${res.message}<i class="loader" style="font-size:24px" aria-hidden="false"></i>`)
                        $('.loader').removeClass('fa fa-spinner fa-spin');
                    }
                    if (res.status == false) {
                        $('.counter').attr('disabled', 'true');
                        $(".add-to-cart").attr('disabled', true);
                        $(".add-to-cart").css({"background-color": "#fff", "color": "#df8e6a"});

                    } else {
                        $('.counter').prop('disabled', false)
                        $(".add-to-cart").attr('disabled', false);
                        $(".add-to-cart").css({"background-color": "#df8e6a", "color": "#fff"});

                    }
                }
            });
        }

        getStock();


        // product stock check when add to cart item
        $(".add-to-cart").on('click', function () {
            productCheck();
        });

        function productCheck() {
            var cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
            var storage_qty = 0;
            for (let obj in cart) {
                var storage_qty = cart[obj].count;
            }

            let selectedIds = [];
            let productId = '{{ $id }}';

            let quantity = $(this).data('quantity');

            let attributeLength = $('.attribute-length').length;

            $($(".attribute-select:checked")).each(function (key, value) {
                selectedIds.push($(value).val());
            });
            if (selectedIds.length != attributeLength) {
                return false;
            }

            $.ajax({
                url: "{{ route('product.stock.check') }}",
                method: "get",
                data: {
                    productId: productId,
                    attributeIds: selectedIds,
                    quantity: quantity,
                    storage_qty: storage_qty,
                },
                success: function (res) {
                    if (!res.status) {
                        $(".add-to-cart").attr('disabled', true);
                    }
                }
            });
        }

        productCheck();

        // WishList
        let isAuthenticate = "{{\Illuminate\Support\Facades\Auth::check()}}";
        let userId = "{{optional(auth()->user())->id}}";

        $('.wishList').on('click', function () {
            let _this = this.id;
            let user_id = userId;
            let product_id = $(this).data('product');
            if (isAuthenticate == 1) {
                wishList(user_id, product_id, _this);
            } else {
                window.location.href = '{{route('login')}}';
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
                success: function (data) {
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


    </script>
@endpush
