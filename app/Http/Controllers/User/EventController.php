<?php

namespace App\Http\Controllers\User;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class EventController extends UserController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data =  DB::table('events')
            // ->where('status', 'open')
            ->orderBy('id', 'desc')
            ->get();
        $check =  DB::table('events')
            // ->where('status', 'open')
            ->orderBy('id', 'desc')
            ->first();

        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/user/event", 'name' => "Event"], ['name' => "List"]];

        return view('/user/event/index', [
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

    public function join_event(Request $request)
    {
        $data_scores = new \App\Score();

        $randomangka = rand(100,999);

        $data_scores->score_code = 'SC_'.$randomangka.Auth::id().date('mdhis');
        $data_scores->user_id = Auth::id();
        $data_scores->join_status = 'waiting';
        $data_scores->event_code = $request->key;

        $data_scores->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {

        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/user/event", 'name' => "Event"], ['name' => "Detail"]];

        return view('/user/event/show', [
            'breadcrumbs' => $breadcrumbs,
            'data' => $event,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}