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

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        \View::addExtension("latte", "latte", function () {
            return new Engine;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }

}