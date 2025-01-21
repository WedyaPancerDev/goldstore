<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LabaRugiController extends Controller
{
    public function index()
    {
        return view('pages.akuntan.laba-rugi.index');
    }
}
