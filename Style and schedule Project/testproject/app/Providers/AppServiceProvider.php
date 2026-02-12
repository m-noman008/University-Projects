<?php

namespace App\Providers;


use App\Models\ContentDetails;
use App\Models\Fund;
use App\Models\Gateway;
use App\Models\Language;
use App\Models\ManageGallery;
use App\Models\PayoutLog;
use App\Models\Template;
use App\Models\Ticket;
use App\Helper;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $data['basic'] = (object)config('basic');
        $data['theme'] = template();
        $data['themeTrue'] = template(true);

        View::share($data);

        try {
            DB::connection()->getPdo();

            view()->composer(['admin.ticket.nav', 'dashboard'], function ($view) {
                $view->with('pending', Ticket::whereIn('status', [0, 2])->latest()->with('user')->limit(10)->with('lastReply')->get());
            });

            view()->composer([
                $data['theme'] . 'partials.footer',
                $data['theme'] . 'partials.topbar',
            ], function ($view) {

                $view->with('languages', Language::orderBy('name')->where('is_active', 1)->get());

                $view->with('topbarSection', Template::templateMedia()->whereIn('section_name', ['topbar'])->get()->groupBy('section_name'));


                $templateSection = ['contact-us'];
                $view->with('contactUs', Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name'));

                $templateNewsletter = ['news-letter'];
                $view->with('newsLetter', Template::templateMedia()->whereIn('section_name', $templateNewsletter)->get()->groupBy('section_name'));

                $manageGallery = ManageGallery::latest()->get();
                $view->with('manageGallery', $manageGallery);

                $contentSection = ['pages', 'social'];
                $view->with('contentDetails', ContentDetails::select('id', 'content_id', 'description')
                    ->whereHas('content', function ($query) use ($contentSection) {
                        return $query->whereIn('name', $contentSection);
                    })
                    ->with(['content:id,name',
                        'content.contentMedia' => function ($q) {
                            $q->select(['content_id', 'description']);
                        }])
                    ->get()->groupBy('content.name'));
            });


        } catch (\Exception $e) {
//            die("Could not connect to the database.  Please check your configuration according to documentation" );
        }

        Blade::if('shop', function () {
            return config('basic.shop');
        });

        Blade::if('faq', function () {
            return config('basic.faq');
        });

        Blade::if('bookAppointment', function () {
            return config('basic.book_appointment');
        });

        Blade::if('gallery', function () {
            return config('basic.gallery');
        });

        Blade::if('team', function () {
            return config('basic.team');
        });

        Blade::if('service', function () {
            return config('basic.service');
        });


        Blade::if('plan', function () {
            return config('basic.plan');
        });

    }
}
