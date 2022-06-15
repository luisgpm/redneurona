<?php

namespace App\Http\Controllers;

use App\Events\DataWasReceived;
use App\Models\sensores;
use Illuminate\Http\Request;

class SensoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q1 = sensores::all()->pluck('q1');
        $q2 = sensores::all()->pluck('q2');
        $q3 = sensores::all()->pluck('q3');
        $id = sensores::all()->pluck('id');
        return view('welcome', compact('q1', 'q2', 'q3', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sensores = sensores::create($request->all());

        event(new \App\Events\DataWasReceived($sensores));
       // event(new DataWasReceived()); //el evento esta en pasado diciendo que ya sucedio
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sensores  $sensores
     * @return \Illuminate\Http\Response
     */
    public function show(sensores $sensores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sensores  $sensores
     * @return \Illuminate\Http\Response
     */
    public function edit(sensores $sensores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sensores  $sensores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sensores $sensores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sensores  $sensores
     * @return \Illuminate\Http\Response
     */
    public function destroy(sensores $sensores)
    {
        //
    }
}
