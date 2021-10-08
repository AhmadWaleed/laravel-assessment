<?php

namespace App\Providers;

use App\Reader;
use App\JsonCollectionReader;
use JsonCollectionParser\Parser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Reader::class, fn () => new JsonCollectionReader(new Parser));
    }

    public function boot(): void
    {
        //
    }
}
