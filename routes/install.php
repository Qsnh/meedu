<?php

Route::any('/', 'InstallController@step1')->name('install.step1');
Route::any('/step2', 'InstallController@step2')->name('install.step2');
Route::any('/step3', 'InstallController@step3')->name('install.step3');