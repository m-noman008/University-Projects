@extends($theme.'layouts.app')
@section('title', trans($title))

@section('content')
    <section class="cart_area" id="cart-app">
        <div class="container">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="col-2">
                                <div class="section_header">
                                    @lang('Image')
                                </div>
                            </th>
                            <th class="col-2">
                                <div class="section_header">
                                    @lang('Product Name')
                                </div>
                            </th>
                            <th class="col-2">
                                <div class="section_header">
                                    @lang('Price')
                                </div>
                            </th>
                            <th class="col-2">
                                <div class="section_header">
                                    @lang('Attributes')
                                </div>
                            </th>
                            <th class="col-2">
                                <div class="section_header">
                                    @lang('Quantity')
                                </div>
                            </th>
                            <th class="col-2">
                                <div class="section_header">
                                    @lang('Total')
                                </div>
                            </th>
                            <th class="col-2">
                                <div class="section_header">
                                    @lang('Remove')
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(obj, index) in cart_item" :value="obj.id">
                            <th scope="row">
                                <div class="image_area" v-cloak>
                                    <img :src="obj.image" alt="">
                                </div>
                            </th>
                            <td>
                                <div class="table_data" v-cloak>
                                    @{{ obj.name }}
                                </div>
                            </td>
                            <td>
                                <div class="table_data" v-cloak>
                                    @{{ obj.currency }}@{{ obj.price }}
                                </div>
                            </td>
                            <td>
                                <span v-if="obj.attributesName">
                                    <span v-for="(attributesName, index) in JSON.parse(obj.attributesName)"
                                          class="attribute_name">
                                    <span v-for="key of Object.keys(attributesName)" v-cloak>
                                        @{{ key }}:
                                    </span>
                                    <span v-for="value of Object.values(attributesName)" v-cloak>
                                        @{{ value }}
                                    </span>
                                    </span>
                                </span>
                                <span v-else class="attribute_name"> @lang('N/A') </span>
                            </td>
                            <td>
                                <div class="in_de_counter_area d-flex">
                                    <button @click.prevent="minus(obj)">-</button>
                                    <span id="counting" :value="obj.count" v-cloak>@{{ obj.count }}</span>
                                    <button :id="obj.id" @click.prevent="plus(obj)">+</button>
                                </div>
                            </td>
                            <td>
                                <div class="table_data" v-cloak>
                                    @{{ obj.currency }}@{{ obj.price * obj.count }}
                                </div>
                            </td>
                            <td>
                                <div class="bin_area">
                                    <button type="button" class="cart_delete_btn" @click.prevent="remove(obj)"><i
                                            class="fa-regular fa-trash-can"></i></button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="coupon_area">
                <div class="row g-lg-4 g-3 coupon_inner">

                    <div class="col-lg-12 d-flex justify-content-between">
                        <div class="contineu_shopping_btn">
                            <a href="{{ route('products') }}"
                               class="common_btn d-flex align-items-center justify-content-center">@lang('CONTINUE SHOPPING')</a>
                        </div>
                        <div class="update_cart_btn">
                            <button class="common_btn d-flex align-items-center justify-content-center" :disabled="isButtonDisabled" @click.prevent="removeAll()">@lang('CLEAR CART')</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="cart_total_area mt-40">
                <div class="row">
                    <div class="col-sm-6 ms-sm-auto">
                        <div class="cart_table">
                            <ul>
                                <li><h4>@lang('Cart Total')</h4></li>
                                <li><h5>@lang('Sub Total')</h5><h5>{{ config('basic.currency_symbol') }}@{{ cart_total }}</h5></li>
                            </ul>
                            <div class="btn_area d-flex justify-content-end">
                                <a href="{{ route('user.checkout') }}"
                                   class="common_btn  d-flex justify-content-center align-items-center ">
                                    @lang('PROCEED CHECKOUT')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        'use script'
        var newApp = new Vue({
            el: "#cart-app",
            data: {
                cart_item: [],
                total: 0,
                cart_total: 0,
                productObj: {},
                isButtonDisabled: false,
            },
            mounted() {
                let _this = this;
                _this.cartItem();
                _this.cart_item = JSON.parse(sessionStorage.getItem('shoppingCart'));
                if (_this.cart_item.length === 0){
                    this.isButtonDisabled = true;
                }
                $.each(_this.cart_item, function (key, value) {
                    var obj = value
                    _this.plus(obj, 1);
                });
            },
            methods: {
                cartItem() {
                    let _this = this;
                    _this.cart_item = JSON.parse(sessionStorage.getItem('shoppingCart'));
                    _this.calc();
                },
                remove(obj) {
                    let _this = this;
                    _this.cart_item.splice(_this.cart_item.indexOf(obj), 1);
                    _this.calc();
                    var selectData = JSON.parse(sessionStorage.getItem('shoppingCart'));
                    console.log(selectData);
                    var storeIds = selectData.filter(function (item) {
                        if (item.name === obj.name) {
                            return false;
                        }
                        return true;
                    });
                    sessionStorage.setItem("shoppingCart", JSON.stringify(storeIds));
                    shoppingCart.removeItemFromCartAll(obj.name);
                    displayCart();
                    Notiflix.Notify.Success("Remove from Cart");
                },
                minus(obj) {
                    shoppingCart.removeItemFromCart(obj.name);
                    this.cartItem();
                    displayCart();
                },
                plus(obj, check = null) {
                    this.check(obj)
                    if (check == null) {
                        shoppingCart.addItemToCart(obj.id, obj.name, obj.price, obj.count, obj.image, obj.currency, null, obj.attributes);
                    }
                    this.cartItem();
                    displayCart();
                },
                check(obj) {
                    let productObj = this.productObj;
                    productObj.productId = obj.id;
                    productObj.attributeIds = obj.attributes;
                    productObj.storage_qty = obj.count;

                    axios.post("{{ route('check.shopping.cart.item') }}", this.productObj)
                        .then(function (response) {
                            if (response.data.status == false) {
                                $(`#${response.data.productId}`).attr('disabled', true);
                                Notiflix.Notify.Failure("Out Of Stock");
                            }
                            return true;

                        })
                        .catch(function (error) {
                            let errors = error.response.data;
                            errors = errors.errors
                            for (let err in errors) {
                                let selector = document.querySelector("." + err);
                                if (selector) {
                                    selector.innerText = `${errors[err]}`;
                                }
                            }
                        });
                },
                clearCart() {
                    cart_item = [];
                    this.cartItem();
                },

                removeAll() {
                    let _this = this;
                    let cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
                    console.log(this.cart_item.length === 0)
                    if(this.cart_item.length === 0){
                        this.isButtonDisabled = true;
                    }else{
                        this.isButtonDisabled = false;
                    }
                    shoppingCart.clearCart();
                    this.cartItem();
                    displayCart();
                },

                calc() {
                    let _this = this;
                    _this.cart_total = 0;
                    _this.total = 0;

                    var cart_item = _this.cart_item;
                    for (let obj in cart_item) {
                        var qty = cart_item[obj].count;
                        var price = cart_item[obj].price;

                        var total_price = qty * price;
                        _this.cart_total += total_price;

                        var count = parseInt(cart_item[obj].count);
                        _this.total = parseInt(_this.total) + parseInt(count);
                    }
                    return 0;
                }
            }
        })
    </script>
    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.Failure("{{trans($error)}}");
            @endforeach
        </script>
    @endif
@endpush
