<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        return view('guest.landing.index');
    }

    public function dashboard()
    {
        return view('dashboard.index');
    }
}
