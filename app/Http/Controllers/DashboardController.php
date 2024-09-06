<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexAdmin()
    {
        return view('pages.admin.dashboard');
    }

    public function indexManajer()
    {
        return view('pages.manajer.dashboard');
    }

    public function indexAkuntan()
    {
        return view('pages.akuntan.dasboard');
    }

    public function indexStaff()
    {
        return view('pages.staff.dashboard');
    }
}
