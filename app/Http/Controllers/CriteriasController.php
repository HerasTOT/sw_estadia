<?php

namespace App\Http\Controllers;

use App\Models\Criterias;
use App\Http\Requests\StoreCriteriasRequest;
use App\Http\Requests\UpdateCriteriasRequest;
use Illuminate\Http\Request;
use Inertia\Response;


class CriteriasController extends Controller
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
     * @param  \App\Http\Requests\StoreCriteriasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $delete = false;

        foreach ($request->datos as $key => $value) {
            if (Criterias::where('proposal_id', '=', $value['proposal_id'])->exists()) {
                $delete = true;
                break;
            }
        }

        if (!$delete) {
            foreach ($request->datos as $key => $value) {
                Criterias::create($value);
            }
        } else {
            $elements = Criterias::where('proposal_id', '=', $request->datos[0]['proposal_id'])->get();

            foreach ($elements as $key => $value) {
                $value->delete();
            }

            foreach ($request->datos as $key => $value) {
                Criterias::create($value);
            }
        }

        return response('ok', 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Criterias  $criterias
     * @return \Illuminate\Http\Response
     */
    public function show(Criterias $criterias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Criterias  $criterias
     * @return \Illuminate\Http\Response
     */
    public function edit(Criterias $criterias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCriteriasRequest  $request
     * @param  \App\Models\Criterias  $criterias
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCriteriasRequest $request, Criterias $criterias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Criterias  $criterias
     * @return \Illuminate\Http\Response
     */
    public function destroy(Criterias $criterias)
    {
        //
    }
}
