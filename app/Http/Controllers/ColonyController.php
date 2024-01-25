<?php

namespace App\Http\Controllers;

use App\Models\Colony;
use App\Http\Requests\StoreColonyRequest;
use App\Http\Requests\UpdateColonyRequest;
use App\Models\State;
use Illuminate\Http\Request;


class ColonyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = new Colony();
        $records = $records->when($request, function ($query, $search) {
            if ($search->cp != '') {
                $query->where('postal_code', 'like', "%$search->cp%");
            }
        })->get();

        $records->load('township');

        $records[] = state::find($records[0]->township->id);

        return $records;
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
     * @param  \App\Http\Requests\StoreColonyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreColonyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Colony  $colony
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Colony  $colony
     * @return \Illuminate\Http\Response
     */
    public function edit(Colony $colony)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateColonyRequest  $request
     * @param  \App\Models\Colony  $colony
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateColonyRequest $request, Colony $colony)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Colony  $colony
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colony $colony)
    {
        //
    }
}
