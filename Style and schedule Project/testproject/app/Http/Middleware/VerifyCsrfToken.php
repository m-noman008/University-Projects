<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '*users-inactive',
        '*users-active',
        'admin/service',
        '*plans-active',
        '*plans-inactive',

        '*sort-payment-methods',
        '*add-fund',
        'success',
        'failed',
        'payment/*',
        '*/plan-purchase/payment/info',
        '*/check-shopping-cart-item',
        '*/order-payment-check',
        '*/product-place-order',
        '*/wish-list',
        '*/confirm-appointment',
        '*/pending-appointment',
        '*/cancel-appointment',
        '*/order/pending',
        '*/order/processing',
        '*/order/on-shipping',
        '*/order/ship',
        '*/order/completed',
        '*/order/cancel'
    ];
}
