<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LabaRugiController extends Controller
{
    public function index()
    {
        return view('laba-rugi.index');
    }
}
