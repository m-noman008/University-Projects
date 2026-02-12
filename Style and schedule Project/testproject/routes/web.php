<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear', function () {

    $output = new \Symfony\Component\Console\Output\BufferedOutput();
    Artisan::call('optimize:clear', array(), $output);
    return $output->fetch();
})->name('/clear');


Route::get('/user', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/loginModal', 'Auth\LoginController@loginModal')->name('loginModal');

Route::get('queue-work', function () {
    return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['guest']], function () {
    Route::get('register/{sponsor?}', 'Auth\RegisterController@sponsor')->name('register.sponsor');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/check', 'User\VerificationController@check')->name('check');
    Route::get('/resend_code', 'User\VerificationController@resendCode')->name('resendCode');
    Route::post('/mail-verify', 'User\VerificationController@mailVerify')->name('mailVerify');
    Route::post('/sms-verify', 'User\VerificationController@smsVerify')->name('smsVerify');
    Route::middleware('userCheck')->group(function () {
        Route::get('/dashboard', 'User\HomeController@index')->name('home');

        Route::get('/my-book-appointment/', 'User\HomeController@mybookAppointment')->name('my.book.appointment');

        //Fronted
        Route::post('/book-appointment', 'Frontend\BookAppointmentController@bookAppointmentStore')->name('book.appointment');

        Route::get('/plan-purchase/{id?}', 'Frontend\PlanPurchaseController@planPurchase')->name('plan.purchase');
        Route::post('/plan-purchase/payment', 'Frontend\PlanPurchaseController@planPayment')->name('plan.payment');
        Route::post('/plan-purchase/payment/info', 'Frontend\PlanPurchaseController@getPaymentInfo')->name('get.payment.info');

        //checkout
        Route::get('/checkout', 'FrontendController@checkout')->name('checkout');
        Route::post('/order-payment-check', 'Frontend\OrderPaymentController@orderPaymentCheck')->name('order.payment.check');
        Route::post('/product-place-order', 'Frontend\OrderPaymentController@productPlaceOrder')->name('product.place.order');
        Route::get('/order-confirm/{id?}', 'FrontendController@orderConfirm')->name('order.confirm');

        // WishList
        Route::post('/wish-list', 'Frontend\WishListController@wishList')->name('wishList');
        Route::get('/my-favourite-list', 'Frontend\WishListController@myFavList')->name('myFavList');
        Route::get('/wish-list/remove/{id}', 'Frontend\WishListController@wishListRemove')->name('wishListRemove');


        // Review Rating
        Route::post('/add-review', 'Frontend\ReviewRatingController@addReviewRating')->name('add.review.rating');


        //Fund
        Route::get('add-fund', 'User\HomeController@addFund')->name('addFund');
        Route::post('add-fund', 'PaymentController@addFundRequest')->name('addFund.request');
        Route::get('addFundConfirm', 'PaymentController@depositConfirm')->name('addFund.confirm');
        Route::post('addFundConfirm', 'PaymentController@fromSubmit')->name('addFund.fromSubmit');


        //transaction
        Route::get('/transaction', 'User\HomeController@transaction')->name('transaction');
        Route::get('/transaction-search', 'User\HomeController@transactionSearch')->name('transaction.search');
        Route::get('fund-history', 'User\HomeController@fundHistory')->name('fund-history');
        Route::get('fund-history-search', 'User\HomeController@fundHistorySearch')->name('fund-history.search');



        Route::get('push-notification-show', 'SiteNotificationController@show')->name('push.notification.show');
        Route::get('push.notification.readAll', 'SiteNotificationController@readAll')->name('push.notification.readAll');
        Route::get('push-notification-readAt/{id}', 'SiteNotificationController@readAt')->name('push.notification.readAt');

        // });


        // Edit Profile
        Route::get('/profile', 'User\HomeController@profile')->name('profile');
        Route::post('/updateProfile', 'User\HomeController@updateProfile')->name('updateProfile');
        Route::put('/updateInformation', 'User\HomeController@updateInformation')->name('updateInformation');
        Route::post('/updatePassword', 'User\HomeController@updatePassword')->name('updatePassword');


        // My Plan
        Route::get('/my-plan', 'User\MyPlanController@myPlan')->name('my.plan');
        Route::get('/plan/search', 'User\MyPlanController@searchPlan')->name('search.plan');

        // My Appointment
        Route::get('/my-appointment', 'User\MyAppointmentController@myAppointment')->name('my.appointment');
        Route::put(
            '/appointment/date-fixed/{id?}',
            'User\MyAppointmentController@myAppointmentDateFixed'
        )->name('my.appointment.date.fixed');
        Route::get('/appointment/search', 'User\MyAppointmentController@searchAppointment')->name('search.appointment');

        // My WishList
        Route::get('/my-wishlist', 'User\MyWishListController@myWishList')->name('my.wishlist');
        Route::get('/wishlist/search', 'User\MyWishListController@searchWishlist')->name('search.wishlist');
        Route::get('/my-wishlist/delete/{id?}', 'User\MyWishListController@myWishListDelete')->name('my.wishlist.delete');


        // My Order List
        Route::get('/my-order-list', 'User\MyOrderController@myOrder')->name('my.order');
        Route::get('/my-order-details/{id?}', 'User\MyOrderController@myOrderDetails')->name('my.order.details');
        Route::get('/order-search', 'User\MyOrderController@orderSearch')->name('order.search');


        // My Transaction
        Route::get('/my-transaction', 'User\MyTransactionController@myTransactionList')->name('my.transaction');
        Route::get('/transaction-search', 'User\MyTransactionController@transactionSearch')->name('transaction.search');


        Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
            Route::get('/', 'User\SupportController@index')->name('list');
            Route::get('/create', 'User\SupportController@create')->name('create');
            Route::post('/create', 'User\SupportController@store')->name('store');
            Route::get('/view/{ticket}', 'User\SupportController@ticketView')->name('view');
            Route::put('/reply/{ticket}', 'User\SupportController@reply')->name('reply');
            Route::get('/download/{ticket}', 'User\SupportController@download')->name('download');
        });
    });
});


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', 'Admin\LoginController@showLoginForm')->name('login');
    Route::post('/', 'Admin\LoginController@login')->name('login');
    Route::post('/logout', 'Admin\LoginController@logout')->name('logout');


    Route::get('/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('password.update');


    Route::get('/403', 'Admin\DashboardController@forbidden')->name('403');

    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('/dashboard', 'Admin\DashboardController@dashboard')->name('dashboard');

        Route::get('/profile', 'Admin\DashboardController@profile')->name('profile');
        Route::put('/profile', 'Admin\DashboardController@profileUpdate')->name('profileUpdate');
        Route::get('/password', 'Admin\DashboardController@password')->name('password');
        Route::put('/password', 'Admin\DashboardController@passwordUpdate')->name('passwordUpdate');


        /* ====== Transaction Log =====*/
        Route::get('/transaction', 'Admin\LogController@transaction')->name('transaction');
        Route::get('/transaction-search', 'Admin\LogController@transactionSearch')->name('transaction.search');


        /*====Manage Users ====*/
        Route::get('/users', 'Admin\UsersController@index')->name('users');
        Route::get('/users/search', 'Admin\UsersController@search')->name('users.search');
        Route::post('/users-active', 'Admin\UsersController@activeMultiple')->name('user-multiple-active');
        Route::post('/users-inactive', 'Admin\UsersController@inactiveMultiple')->name('user-multiple-inactive');
        Route::get('/user/edit/{id}', 'Admin\UsersController@userEdit')->name('user-edit');
        Route::post('/user/update/{id}', 'Admin\UsersController@userUpdate')->name('user-update');
        Route::post('/user/password/{id}', 'Admin\UsersController@passwordUpdate')->name('userPasswordUpdate');
        Route::post('/user/balance-update/{id}', 'Admin\UsersController@userBalanceUpdate')->name('user-balance-update');

        Route::get('/user/send-email/{id}', 'Admin\UsersController@sendEmail')->name('send-email');
        Route::post('/user/send-email/{id}', 'Admin\UsersController@sendMailUser')->name('user.email-send');
        Route::get('/user/transaction/{id}', 'Admin\UsersController@transaction')->name('user.transaction');
        Route::get('/user/fundLog/{id}', 'Admin\UsersController@funds')->name('user.fundLog');
        Route::post('/email-send', 'Admin\UsersController@sendEmailToUsers')->name('email-send.store');


        /*=====Payment Log=====*/
        Route::get('payment-methods', 'Admin\PaymentMethodController@index')->name('payment.methods');
        Route::post(
            'payment-methods/deactivate',
            'Admin\PaymentMethodController@deactivate'
        )->name('payment.methods.deactivate');
        Route::get(
            'payment-methods/deactivate',
            'Admin\PaymentMethodController@deactivate'
        )->name('payment.methods.deactivate');
        Route::post('sort-payment-methods', 'Admin\PaymentMethodController@sortPaymentMethods')->name('sort.payment.methods');
        Route::get('payment-methods/edit/{id}', 'Admin\PaymentMethodController@edit')->name('edit.payment.methods');
        Route::put('payment-methods/update/{id}', 'Admin\PaymentMethodController@update')->name('update.payment.methods');


        Route::get('payment/pending', 'Admin\PaymentLogController@pending')->name('payment.pending');
        Route::put('payment/action/{id}', 'Admin\PaymentLogController@action')->name('payment.action');
        Route::get('payment/log', 'Admin\PaymentLogController@index')->name('payment.log');
        Route::get('payment/search', 'Admin\PaymentLogController@search')->name('payment.search');


        /* ===== Support Ticket ====*/
        Route::get('tickets/{status?}', 'Admin\TicketController@tickets')->name('ticket');
        Route::get('tickets/view/{id}', 'Admin\TicketController@ticketReply')->name('ticket.view');
        Route::put('ticket/reply/{id}', 'Admin\TicketController@ticketReplySend')->name('ticket.reply');
        Route::get('ticket/download/{ticket}', 'Admin\TicketController@ticketDownload')->name('ticket.download');
        Route::post('ticket/delete', 'Admin\TicketController@ticketDelete')->name('ticket.delete');

        /* ===== Subscriber =====*/
        Route::get('subscriber', 'Admin\SubscriberController@index')->name('subscriber.index');
        Route::post('subscriber/remove', 'Admin\SubscriberController@remove')->name('subscriber.remove');
        Route::get('subscriber/send-email', 'Admin\SubscriberController@sendEmailForm')->name('subscriber.sendEmail');
        Route::post('subscriber/send-email', 'Admin\SubscriberController@sendEmail')->name('subscriber.mail');


        /* ===== website controls =====*/
        Route::any('/basic-controls', 'Admin\BasicController@index')->name('basic-controls');
        Route::post('/basic-controls', 'Admin\BasicController@updateConfigure')->name('basic-controls.update');

        Route::any('/email-controls', 'Admin\EmailTemplateController@emailControl')->name('email-controls');
        Route::post('/email-controls', 'Admin\EmailTemplateController@emailConfigure')->name('email-controls.update');
        Route::post(
            '/email-controls/action',
            'Admin\EmailTemplateController@emailControlAction'
        )->name('email-controls.action');
        Route::post('/email/test', 'Admin\EmailTemplateController@testEmail')->name('testEmail');

        Route::get('/email-template', 'Admin\EmailTemplateController@show')->name('email-template.show');
        Route::get('/email-template/edit/{id}', 'Admin\EmailTemplateController@edit')->name('email-template.edit');
        Route::post('/email-template/update/{id}', 'Admin\EmailTemplateController@update')->name('email-template.update');

        /*========Sms control ========*/
        Route::match(['get', 'post'], '/sms-controls', 'Admin\SmsTemplateController@smsConfig')->name('sms.config');
        Route::post('/sms-controls/action', 'Admin\SmsTemplateController@smsControlAction')->name('sms-controls.action');
        Route::get('/sms-template', 'Admin\SmsTemplateController@show')->name('sms-template');
        Route::get('/sms-template/edit/{id}', 'Admin\SmsTemplateController@edit')->name('sms-template.edit');
        Route::post('/sms-template/update/{id}', 'Admin\SmsTemplateController@update')->name('sms-template.update');

        Route::get('/notify-config', 'Admin\NotifyController@notifyConfig')->name('notify-config');
        Route::post('/notify-config', 'Admin\NotifyController@notifyConfigUpdate')->name('notify-config.update');
        Route::get('/notify-template', 'Admin\NotifyController@show')->name('notify-template.show');
        Route::get('/notify-template/edit/{id}', 'Admin\NotifyController@edit')->name('notify-template.edit');
        Route::post('/notify-template/update/{id}', 'Admin\NotifyController@update')->name('notify-template.update');


        Route::get('/logo-seo', 'Admin\BasicController@logoSeo')->name('logo');
        Route::put('/logoUpdate', 'Admin\BasicController@logoUpdate')->name('logoUpdate');
        Route::put('/seoUpdate', 'Admin\BasicController@seoUpdate')->name('seoUpdate');


        /* ===== ADMIN TEMPLATE SETTINGS ===== */

        

        Route::get('push-notification-show', 'SiteNotificationController@showByAdmin')->name('push.notification.show');
        Route::get('push.notification.readAll', 'SiteNotificationController@readAllByAdmin')->name('push.notification.readAll');
        Route::get('push-notification-readAt/{id}', 'SiteNotificationController@readAt')->name('push.notification.readAt');
        Route::match(['get', 'post'], 'pusher-config', 'SiteNotificationController@pusherConfig')->name('pusher.config');

        Route::middleware('module:service')->group(function () {
            //Manage Service
            Route::get('/service/list', 'Admin\ServiceController@serviceList')->name('service.list');
            Route::get('/service/create', 'Admin\ServiceController@serviceCreate')->name('service.create');
            Route::post('/service/store/{language?}', 'Admin\ServiceController@serviceStore')->name('service.store');
            Route::delete('/service/delete/{id?}', 'Admin\ServiceController@serviceDelete')->name('service.delete');
            Route::get('/service/edit/{id?}', 'Admin\ServiceController@serviceEdit')->name('service.edit');
            Route::put('/service/update/{id?}/{language?}', 'Admin\ServiceController@serviceUpdate')->name('service.update');
        });

        Route::middleware('module:gallery')->group(function () {
            //Manage Gallery
            Route::get('/gallery/tag/list', 'Admin\ManageGalleryController@galleryTagList')->name('gallery.tag.list');
            Route::post('/gallery/tag/store', 'Admin\ManageGalleryController@galleryTagStore')->name('gallery.tag.store');
            Route::put('/gallery/tag/update/{id?}', 'Admin\ManageGalleryController@galleryTagUpdate')->name('gallery.tag.update');
            Route::delete('/gallery/tag/delete/{id}', 'Admin\ManageGalleryController@galleryTagDelete')->name('gallery.tag.delete');

            //Manage Gallery Items
            Route::get('/gallery/items/list', 'Admin\ManageGalleryController@galleryItemsList')->name('gallery.items.list');
            Route::get('/gallery/items/create', 'Admin\ManageGalleryController@galleryItemsCreate')->name('gallery.items.create');
            Route::post('/gallery/items/store', 'Admin\ManageGalleryController@galleryItemsStore')->name('gallery.items.store');
            Route::get('/gallery/items/edit/{id?}', 'Admin\ManageGalleryController@galleryItemsEdit')->name('gallery.items.edit');
            Route::put(
                '/gallery/items/update/{id?}',
                'Admin\ManageGalleryController@galleryItemsUpdate'
            )->name('gallery.items.update');
            Route::delete(
                '/gallery/items/delete/{id}',
                'Admin\ManageGalleryController@galleryItemsDelete'
            )->name('gallery.items.delete');
        });

        Route::middleware('module:team')->group(function () {
            //Manage Team
            Route::get('/team/list', 'Admin\TeamController@teamList')->name('team.list');
            Route::get('/team/create', 'Admin\TeamController@teamCreate')->name('team.create');
            Route::post('/team/store/{language?}', 'Admin\TeamController@teamStore')->name('team.store');
            Route::delete('/team/delete/{id?}', 'Admin\TeamController@teamDelete')->name('team.delete');
            Route::get('/team/edit/{id?}', 'Admin\TeamController@teamEdit')->name('team.edit');
            Route::put('/team/update/{id?}/{language?}', 'Admin\TeamController@teamUpdate')->name('team.update');
        });

        //Manage Staff
        Route::get('/staff/list', 'Admin\StaffController@teamList')->name('staff.list');
        Route::get('/staff/create', 'Admin\StaffController@teamCreate')->name('staff.create');
        Route::post('/staff/store/{language?}', 'Admin\StaffController@teamStore')->name('staff.store');
        Route::delete('/staff/delete/{id?}', 'Admin\StaffController@teamDelete')->name('staff.delete');
        Route::get('/staff/edit/{id?}', 'Admin\StaffController@teamEdit')->name('staff.edit');
        Route::put('/staff/update/{id?}', 'Admin\StaffController@teamUpdate')->name('staff.update');



        Route::middleware('module:plan')->group(function () {
            //Manage Plan
            Route::get('/plan/list', 'Admin\PlanController@planList')->name('plan.list');
            Route::get('/plan/create', 'Admin\PlanController@planCreate')->name('plan.create');
            Route::post('/plan/store', 'Admin\PlanController@planStore')->name('plan.store');
            Route::get('/plan/edit/{id?}', 'Admin\PlanController@planEdit')->name('plan.edit');
            Route::put('/plan/update{id?}', 'Admin\PlanController@planUpdate')->name('plan.update');
            Route::delete('/plan/delete{id?}', 'Admin\PlanController@planDelete')->name('plan.delete');
        });

        Route::middleware('module:shop')->group(function () {
            // Manage Product Category
            Route::get(
                '/product/category/list',
                'Admin\ProductCategoryController@productCategoryList'
            )->name('product.category.list');
            Route::get(
                '/product/category/create',
                'Admin\ProductCategoryController@productCategoryCreate'
            )->name('product.category.create');
            Route::post(
                '/product/category/store/{language?}',
                'Admin\ProductCategoryController@productCategoryStore'
            )->name('product.category.store');
            Route::delete(
                '/product/category/delete/{id?}',
                'Admin\ProductCategoryController@productCategoryDelete'
            )->name('product.category.delete');
            Route::get(
                '/product/category/edit/{id?}',
                'Admin\ProductCategoryController@productCategoryEdit'
            )->name('product.category.edit');
            Route::put(
                '/product/category/update/{id?}/{language?}',
                'Admin\ProductCategoryController@productCategoryUpdate'
            )->name('product.category.update');

            // Manage Attribute
            Route::get(
                '/product-attribute/list',
                'Admin\ProductAttributeController@productAttributeList'
            )->name('product.attribute.list');
            Route::get(
                '/product-attribute/create',
                'Admin\ProductAttributeController@productAttributeCreate'
            )->name('product.attribute.create');
            Route::post(
                '/product-attribute/store',
                'Admin\ProductAttributeController@productAttributeStore'
            )->name('product.attribute.store');
            Route::delete(
                '/product-attribute/delete/{id?}',
                'Admin\ProductAttributeController@productAttributeDelete'
            )->name('product.attribute.delete');
            Route::get(
                '/product-attribute/edit/{id?}',
                'Admin\ProductAttributeController@productAttributeEdit'
            )->name('product.attribute.edit');
            Route::put(
                '/product-attribute/update/{id?}',
                'Admin\ProductAttributeController@productAttributeUpdate'
            )->name('product.attribute.update');


            // Manage Product
            Route::get('/product/list', 'Admin\ProductController@productList')->name('product.list');
            Route::get('/product/create', 'Admin\ProductController@productCreate')->name('product.create');
            Route::post('/product/store/{language?}', 'Admin\ProductController@productStore')->name('product.store');
            Route::delete('/product/delete/{id?}', 'Admin\ProductController@productDelete')->name('product.delete');
            Route::get('/product/edit/{id?}', 'Admin\ProductController@productEdit')->name('product.edit');
            Route::put('/product/update/{id?}/{language?}', 'Admin\ProductController@productUpdate')->name('product.update');
            Route::delete(
                '/product/image-delete/{id}/{imgDelete?}',
                'Admin\ProductController@productImageDelete'
            )->name('product.image.delete');
            Route::get('/product-search', 'Admin\ProductController@productSearch')->name('product.search');

            // Manage Stock
            Route::get('/product-stock/list', 'Admin\ProductStockController@productStockList')->name('product.stock.list');
            Route::get('/product-stock/create', 'Admin\ProductStockController@productStockCreate')->name('product.stock.create');
            Route::post('/product-stock/store', 'Admin\ProductStockController@productStockStore')->name('product.stock.store');
            Route::get('/product-stock/edit/{id?}', 'Admin\ProductStockController@productStockEdit')->name('product.stock.edit');
            Route::put(
                '/product-stock/update/{id?}',
                'Admin\ProductStockController@productStockUpdate'
            )->name('product.stock.update');
            Route::get('/product-stock/search', 'Admin\ProductStockController@productStockSearch')->name('product.stock.search');
        });

        Route::middleware('module:book_appointment')->group(function () {
            // Manage Book Appointment
            Route::get(
                '/book-appointment/list/{status?}',
                'Admin\BookAppointmentController@appointmentList'
            )->name('appointment.list');
            Route::get('/edit-book-appointment/{id?}', 'Admin\BookAppointmentController@editAppointment')->name('edit.appointment');
            Route::put('/update-appointment-time/{id}', 'Admin\BookAppointmentController@updateTime')->name('update.time');

            Route::delete(
                '/delete-book-appointment/{id?}',
                'Admin\BookAppointmentController@deleteAppointment'
            )->name('delete.appointment');
            Route::put(
                '/book-appointment/update/{id?}',
                'Admin\BookAppointmentController@updateAppointment'
            )->name('update.appointment');

            Route::post('/pending-appointment', 'Admin\BookAppointmentController@pendingAppointment')->name('pending.appointment');
            Route::post('/confirm-appointment', 'Admin\BookAppointmentController@confirmAppointment')->name('confirm.appointment');
            Route::post('/cancel-appointment', 'Admin\BookAppointmentController@cancelAppointment')->name('cancel.appointment');
            Route::post('/done-appointment', 'Admin\BookAppointmentController@doneAppointment')->name('done.appointment');
            Route::get('/book-appointment/search', 'Admin\BookAppointmentController@searchAppointment')->name('search.appointment');
        });

        Route::middleware('module:plan')->group(function () {
            // Manage Plan Purchase
            Route::get('/plan-sold-list', 'Admin\ManagePlanPurchaseController@planSoldList')->name('plan.sold.list');
            Route::get('/plan-sold/search', 'Admin\ManagePlanPurchaseController@searchPlanSoldList')->name('search.plan.sold');
        });

        Route::middleware('module:shop')->group(function () {
            // Manage Ordered Product
            Route::get('/product-order/list/{stage?}', 'Admin\ManageProductOrderController@orderList')->name('order.list');
            Route::get(
                '/product-order/product/info/{id}',
                'Admin\ManageProductOrderController@orderProduct'
            )->name('order.product.info');
            Route::post(
                '/product-order/list/stage/change/{orderId}',
                'Admin\ManageProductOrderController@stageChange'
            )->name('stage.change.single');
            Route::get(
                '/product-order/search',
                'Admin\ManageProductOrderController@productOrderSearch'
            )->name('product.order.search');

            //Active Multiple Product Order
            Route::post('/order/pending', 'Admin\ManageProductOrderController@pending')->name('stage.pending');
            Route::post('/order/processing', 'Admin\ManageProductOrderController@processing')->name('stage.processing');
            Route::post('/order/on-shipping', 'Admin\ManageProductOrderController@onShipping')->name('stage.on.shipping');
            Route::post('/order/ship', 'Admin\ManageProductOrderController@ship')->name('stage.ship');
            Route::post('/order/completed', 'Admin\ManageProductOrderController@completed')->name('stage.completed');
            Route::post('/order/cancel', 'Admin\ManageProductOrderController@cancel')->name('stage.cancel');
        });
    });
});




Route::match(['get', 'post'], 'success', 'PaymentController@success')->name('success');
Route::match(['get', 'post'], 'failed', 'PaymentController@failed')->name('failed');
Route::match(['get', 'post'], 'payment/{code}/{trx?}/{type?}', 'PaymentController@gatewayIpn')->name('ipn');


Route::get('/language/{code?}', 'FrontendController@language')->name('language');




Route::get('/', 'FrontendController@index')->name('home');
Route::get('/about', 'FrontendController@about')->name('about');

Route::middleware('module:team')->group(function () {
    Route::get('/service', 'FrontendController@service')->name('service');
    Route::get('/service-details/{slug?}/{id}', 'FrontendController@serviceDetails')->name('service.details');
});

Route::middleware('module:team')->group(function () {
    Route::get('/all-team-member', 'FrontendController@team')->name('team');
    Route::get('/team-details/{slug?}/{id}', 'FrontendController@teamDetails')->name('team.details');
});

Route::middleware('module:plan')->group(function () {
    Route::get('/pricing-plan', 'FrontendController@pricingPlan')->name('plan.pricing');
});

Route::middleware('module:gallery')->group(function () {
    Route::get('/gallery', 'FrontendController@gallery')->name('gallery');
});

Route::middleware('module:faq')->group(function () {
    Route::get('/faq', 'FrontendController@faq')->name('faq');
});

Route::middleware('module:book_appointment')->group(function () {
    Route::get('/appointment', 'FrontendController@appointment')->name('appointment');
});


Route::middleware('module:shop')->group(function () {


    Route::get('/products', 'FrontendController@products')->name('products');
    Route::get('/product-details/{slug?}/{id}', 'FrontendController@productDetails')->name('product.details');

    Route::get('/shopping-cart', 'FrontendController@shoppingCart')->name('shopping.cart');
    Route::get('/product-filter', 'FrontendController@productFilter')->name('product.filter');
    Route::get('/product-sorting/{value?}', 'FrontendController@productSorting')->name('product.sorting');


    Route::get('/product-stock-info', 'Frontend\ProductController@getProductStockInfo')->name('get.product.stock.info');
    Route::get('/product-stock-check', 'Frontend\ProductController@productStockCheck')->name('product.stock.check');
    Route::get(
        '/product-attributes-name',
        'Frontend\ProductController@productAttributesName'
    )->name('get.product.attributes.name');
    Route::post(
        '/check-shopping-cart-item',
        'Frontend\ProductController@checkShoppingCartItem'
    )->name('check.shopping.cart.item');

    Route::post('/reply-by-admin/{parentId?}', 'Frontend\ReviewRatingController@reply')->name('reply');
});


Route::get('/contact', 'FrontendController@contact')->name('contact');
Route::post('/contact', 'FrontendController@contactSend')->name('contact.send');

Route::post('/subscribe', 'FrontendController@subscribe')->name('subscribe');

Route::get('/{getLink}/{content_id}', 'FrontendController@getLink')->name('getLink');
