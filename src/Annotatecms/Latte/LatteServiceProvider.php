<?php
namespace Annotatecms\Latte;

use Illuminate\Support\ServiceProvider;

class LatteServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = FALSE;

    public function boot() {
        $this->package("annotatecms/latte", "annotatecms/latte");
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app["annotate.latte"] = $this->app->share(function ($app) {
            return new Latte();
        });

        \View::addExtension("latte", "latte", function () {
            return new Engine;
        });
    }
}