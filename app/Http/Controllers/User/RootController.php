<?php

namespace App\Http\Controllers\User;

use App\Models\Root;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RootController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('root.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Root  $root
     * @return \Illuminate\Http\Response
     */
    public function show(Root $root)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Root  $root
     * @return \Illuminate\Http\Response
     */
    public function edit(Root $root)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Root  $root
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Root $root)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Root  $root
     * @return \Illuminate\Http\Response
     */
    public function destroy(Root $root)
    {
        //
    }
}
