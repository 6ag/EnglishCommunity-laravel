<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends BaseController
{
    public function index()
    {
        return view('admin.index');
    }

}