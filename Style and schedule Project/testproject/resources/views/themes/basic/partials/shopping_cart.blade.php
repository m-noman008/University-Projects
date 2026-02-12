<div class="shopping-cart">
    <button class="dropdown-toggle">
        <i class="fal fa-shopping-cart"></i>
        <span class="count total-count"></span>
    </button>
    <ul class="cart-dropdown">
        <div class="dropdown-box show-cart">

        </div>
        <div class="cart-bottom">
            <div class="text_area d-flex justify-content-between">
                <p>@lang('Cart Subtotal:')</p>
                <div>
                    <small class="basicCurrency">{{ config('basic.currency_symbol') }}</small>
                    <span class="total-cart"></span>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('shopping.cart') }}" class="common_btn common_btn_cart">@lang('cart')</a>
                <a href="{{ route('user.checkout') }}" class="common_btn common_btn_checkout ">@lang('checkout')</a>
            </div>
        </div>
    </ul>
</div>

@push('script')
    <script>
        'use strict';
        let checkCart = JSON.parse(sessionStorage.getItem('shoppingCart'));
        if(checkCart !== null){
            if(Object.keys(checkCart).length === 0){
                $('.common_btn_checkout').addClass('d-none');
                $('.common_btn_cart').addClass('w-100');
            }else{
                $('.common_btn_checkout').removeClass('d-none');
                $('.common_btn_cart').removeClass('w-100');
            }
        }

    </script>
@endpush
