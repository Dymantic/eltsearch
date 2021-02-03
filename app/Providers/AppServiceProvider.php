<?php

namespace App\Providers;

use App\Purchasing\Transaction;
use App\Purchasing\TestClerk;
use App\Purchasing\TwoCheckoutClient;
use App\Purchasing\TwoCheckoutTransaction;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Transaction::class, function() {
            $client = new TwoCheckoutClient(config('two-checkout.merchant_code'), config('two-checkout.secret_key'));
            return new TwoCheckoutTransaction($client);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Str::macro('markdown', function ($content) {
            $converter = new GithubFlavoredMarkdownConverter([
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
            ]);

            return $converter->convertToHtml($content);
        });
    }
}
