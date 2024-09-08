<?php

namespace App\Http\Controllers;

use App\Models\AssignBonus;
use Illuminate\Http\Request;

class AssignBonusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.admin.assign-bonus.index");
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
    public function show(AssignBonus $assignBonus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssignBonus $assignBonus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssignBonus $assignBonus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssignBonus $assignBonus)
    {
        //
    }
}
