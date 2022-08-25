<?php

namespace App\Http\Controllers;

use App\Models\target_semester;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;

class TargetSemesterController extends Controller
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
     * @param  \App\Models\target_semester  $target_semester
     * @return \Illuminate\Http\Response
     */
    public function show(target_semester $target_semester)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\target_semester  $target_semester
     * @return \Illuminate\Http\Response
     */
    public function edit(target_semester $target_semester)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\target_semester  $target_semester
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, target_semester $target_semester)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\target_semester  $target_semester
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $res = target_semester::findOrFail($id);
        if ($res) {
            $res->delete();
            return "success";
        }
        return "fail";
    }
}
