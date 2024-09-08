<?php

namespace App\Http\Controllers;

use App\Models\MasterBonus;
use Illuminate\Http\Request;

class MasterBonusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.admin.master-bonus.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterBonus $masterBonus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterBonus $masterBonus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterBonus $masterBonus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterBonus $masterBonus)
    {
        //
    }
}
