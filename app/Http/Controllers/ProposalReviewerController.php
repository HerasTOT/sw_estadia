<?php

namespace App\Http\Controllers;

use App\Models\proposal_reviewer;
use App\Http\Requests\Storeproposal_reviewerRequest;
use App\Http\Requests\Updateproposal_reviewerRequest;

class ProposalReviewerController extends Controller
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
     * @param  \App\Http\Requests\Storeproposal_reviewerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeproposal_reviewerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\proposal_reviewer  $proposal_reviewer
     * @return \Illuminate\Http\Response
     */
    public function show(proposal_reviewer $proposal_reviewer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\proposal_reviewer  $proposal_reviewer
     * @return \Illuminate\Http\Response
     */
    public function edit(proposal_reviewer $proposal_reviewer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateproposal_reviewerRequest  $request
     * @param  \App\Models\proposal_reviewer  $proposal_reviewer
     * @return \Illuminate\Http\Response
     */
    public function update(Updateproposal_reviewerRequest $request, proposal_reviewer $proposal_reviewer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\proposal_reviewer  $proposal_reviewer
     * @return \Illuminate\Http\Response
     */
    public function destroy(proposal_reviewer $proposal_reviewer)
    {
        //
    }
}
