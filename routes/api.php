<?php

use Illuminate\Support\Facades\Route;
use \Digitalcloud\NovaMailchimp\Http\MailChimpController;

Route::get('/lists', MailChimpController::class . '@lists');
Route::get('/lists/{id}', MailChimpController::class . '@showList');

Route::get('/campaigns', MailChimpController::class . '@campaigns');
Route::get('/campaigns/{id}', MailChimpController::class . '@showCampaign');
