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
        $this->package("annotatecms/latte");
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        \App::bind("latte", function(){
            return new Latte();
        });

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
        return array(
            "latte"
        );
    }

}