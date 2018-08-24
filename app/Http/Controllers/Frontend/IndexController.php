<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class IndexController extends BaseController
{

    public function index()
    {
        return view('frontend.index.index');
    }

}
