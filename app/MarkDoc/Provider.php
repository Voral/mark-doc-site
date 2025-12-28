<?php

namespace App\MarkDoc;

use App\MarkDoc\Services\Tree;
use App\MarkDoc\Services\TreeSorter;
use App\MarkDoc\View\Components\Menu;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Tree::class, function (Application $app) {
            $docsPath = config('mark-doc.path');
            return new Tree($docsPath, new TreeSorter());
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::component('mark-doc-menu', Menu::class);
    }
}
