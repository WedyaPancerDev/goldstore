<?php

namespace App\Http\Controllers;

use App\Models\BiayaGaji;
use App\Models\BiayaLainya;
use Illuminate\Http\Request;
use App\Models\BiayaProduksi;
use App\Models\BiayaOperasional;

class LabaRugiController extends Controller
{
    public function index()
    {
        return view('pages.akuntan.laba-rugi.index');
    }
}
