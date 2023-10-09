<?php

namespace App\Http\Controllers;

use App\Models\proposals_user;
use App\Http\Requests\Storeproposals_userRequest;
use App\Http\Requests\Updateproposals_userRequest;

class ProposalsUserController extends Controller
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
     * @param  \App\Http\Requests\Storeproposals_userRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeproposals_userRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\proposals_user  $proposals_user
     * @return \Illuminate\Http\Response
     */
    public function show(proposals_user $proposals_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\proposals_user  $proposals_user
     * @return \Illuminate\Http\Response
     */
    public function edit(proposals_user $proposals_user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateproposals_userRequest  $request
     * @param  \App\Models\proposals_user  $proposals_user
     * @return \Illuminate\Http\Response
     */
    public function update(Updateproposals_userRequest $request, proposals_user $proposals_user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\proposals_user  $proposals_user
     * @return \Illuminate\Http\Response
     */
    public function destroy(proposals_user $proposals_user)
    {
        //
    }
}
