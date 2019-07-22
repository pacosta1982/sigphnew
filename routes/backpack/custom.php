<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    CRUD::resource('modality', 'ModalityCrudController');
    CRUD::resource('land', 'LandCrudController');
    CRUD::resource('document', 'DocumentCrudController');
    CRUD::resource('category', 'CategoryCrudController');
    CRUD::resource('assignment', 'AssignmentCrudController');
}); // this should be the absolute last line of this file