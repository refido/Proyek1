<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $check =  DB::table('scores')
            ->where('scores.join_status', '=', 'accepted')
            // ID MIDDLEWWARE USER
            ->where('scores.user_id', '=', Auth::id())
            ->first();

        $data = DB::table('scores')
            ->select('scores.id as score_id', 'scores.*', 'events.*', 'fields.*')
            ->join('events', 'events.event_code', '=', 'scores.event_code')
            ->join('fields', 'fields.id', '=', 'events.field_id')
            ->where('scores.join_status', '=', 'accepted')
            // ID MIDDLEWWARE USER
            ->where('scores.user_id', '=', Auth::id())
            ->orderByDesc('scores.id')
            ->get();

        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/user/score", 'name' => "Score"], ['name' => "List Score"]];
        return view('/user/score/index', [
            'breadcrumbs' => $breadcrumbs,
            'data' => $data,
            'check' => $check
        ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/user/score", 'name' => "Score"], ['name' => "Update Score"]];
        return view('/user/score/edit', [
            'breadcrumbs' => $breadcrumbs,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
