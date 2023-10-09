<?php

namespace App\Http\Controllers;

use App\Models\Proceedings;
use App\Http\Requests\StoreProceedingsRequest;
use App\Http\Requests\UpdateProceedingsRequest;

class ProceedingsController extends Controller
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
     * @param  \App\Http\Requests\StoreProceedingsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProceedingsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proceedings  $proceedings
     * @return \Illuminate\Http\Response
     */
    public function show(Proceedings $proceedings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proceedings  $proceedings
     * @return \Illuminate\Http\Response
     */
    public function edit(Proceedings $proceedings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProceedingsRequest  $request
     * @param  \App\Models\Proceedings  $proceedings
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProceedingsRequest $request, Proceedings $proceedings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proceedings  $proceedings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proceedings $proceedings)
    {
        //
    }
}
