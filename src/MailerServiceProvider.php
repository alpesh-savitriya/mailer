<?php
/**
 * Created by PhpStorm.
 * User: alpesh
 * Date: 4/3/19
 * Time: 12:05 PM
 */

namespace PseudoMailer\Mailer;
use Illuminate\Support\ServiceProvider;

class MailerServiceProvider extends ServiceProvider {

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {

        $this->app->singleton(Mailer::class, function () {
            return new Mailer();
        });

        $this->app->alias(Mailer::class, 'mailer');
    }

    public function boot() {

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }
}