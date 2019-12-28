<?php


Route::get('/captcha/image', 'CaptchaController@imageCaptcha');

Route::post('/login/password', 'LoginController@passwordLogin');