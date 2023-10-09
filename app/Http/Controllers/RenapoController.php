<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Renapo;

class RenapoController extends Controller
{
    protected string $routeName;
    protected string $module = 'renapo';
    protected Renapo $model;
    protected string $source = 'Auth/';


    public function __construct()
    {
        $this->routeName = "renapo.";
        $this->model     = new Renapo();
    }

    public function index()
    {
    }

    public function create()
    {
    }

    public function store($request)
    {
        return $request;
    }

    public function show($request)
    {
        if ($this->model::where('curp', $request)->exists()) {
            $records = $this->model::where('curp', $request)->get();
        } else {
            $request = Http::withToken('6244dffd-036a-494e-8e34-eef40b3173cd')->post("https://apimarket.mx/api/renapo/grupo/valida-curp",['curp' => $request])['data'];

            $records = Renapo::create(
                [
                    "curp" =>  $request['curp'],
                    "nombres" => $request['nombres'],
                    "apellidoPaterno" => $request['apellidoPaterno'],
                    "apellidoMaterno" =>  $request['apellidoMaterno'],
                ]
            )->where('curp', $request['curp'])->get();
        }

        return $records[0];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Renapo  $renapo
     * @return \Illuminate\Http\Response
     */
    public function edit(Renapo $renapo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Renapo  $renapo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Renapo $renapo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Renapo  $renapo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Renapo $renapo)
    {
        //
    }
}
