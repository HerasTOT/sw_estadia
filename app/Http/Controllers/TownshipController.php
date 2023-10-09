<?php

namespace App\Http\Controllers;

use App\Models\Township;
use App\Http\Requests\StoreTownshipRequest;
use App\Http\Requests\UpdateTownshipRequest;

class TownshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTownshipRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTownshipRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Township  $township
     * @return \Illuminate\Http\Response
     */
    public function show(Township $township)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Township  $township
     * @return \Illuminate\Http\Response
     */
    public function edit(Township $township)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTownshipRequest  $request
     * @param  \App\Models\Township  $township
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTownshipRequest $request, Township $township)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Township  $township
     * @return \Illuminate\Http\Response
     */
    public function destroy(Township $township)
    {
        //
    }
}
