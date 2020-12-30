<?php

use DcatAdminExt\Sceditor\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('sceditor', Controllers\SceditorController::class.'@index');