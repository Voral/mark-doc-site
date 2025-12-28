<?php

use Illuminate\Support\Facades\Route;

Route::get('/{path?}', [\App\Http\Controllers\DocsController::class, 'show'])
    ->name('mark-doc.show')
    ->where('path', '.*');
