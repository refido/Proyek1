<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EventController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = \App\Event::all();
        $breadcrumbs = [['link' => "/admin", 'name' => "Home"], ['link' => "/admin/event", 'name' => "Event"], ['name' => "List"]];
        return view('/admin/event/index', [
            'breadcrumbs' => $breadcrumbs,
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $field = \App\Field::all();
        $breadcrumbs = [['link' => "/admin", 'name' => "Home"], ['link' => "/admin/event", 'name' => "Event"], ['name' => "Create"]];
        return view('/admin/event/create', [
            'breadcrumbs' => $breadcrumbs,
            'field' => $field
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $waktu = date('ymdhis');
        $data_event = new \App\Event;


        $file = $request->file('image');
        if (!empty($file)) {
            $name_file = $waktu . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs(
                'masterImages',
                $name_file,
                'public'
            );
        } else {
            $name_file = null;
        }
        $code = 'EV_' . date('ymdhis');

        $data_event->event_code = $code;
        $data_event->event_name = $request->event_name;
        $data_event->user_id = 1;
        $data_event->field_id = $request->field_id;
        $data_event->teeing_ground = $request->teeing_ground;
        $data_event->max_player = $request->max_player;
        $data_event->description = $request->quilltext;
        $data_event->short_description = $request->short_description;
        $data_event->poster = @$name_file;
        $data_event->event_type = $request->event_type;
        $data_event->hole_type = $request->hole_type;
        $data_event->kick_off = $request->kick_off;
        $data_event->deadline_register = $request->deadline_register;
        $data_event->status = 'open';
        if ($request->calculate_ld == true) {
            $data_event->calculate_ld = 1;
        } else {
            $data_event->calculate_ld = 0;
        }



        $data_event->save();


        $notification = array(
            'message' => 'Insert Event Success!',
            'alert-type' => 'success'
        );

        return redirect('/admin/event')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $field = \App\Field::all();
        $breadcrumbs = [['link' => "/admin", 'name' => "Home"], ['link' => "/admin/event", 'name' => "Event"], ['name' => "Edit"]];
        return view('/admin/event/show', [
            'breadcrumbs' => $breadcrumbs,
            'data' => $event,
            'field' => $field
        ]);
    }
    public function update_score(Request $request)
    {

        if (empty($request->check_list)) {
            $status1 = \App\Score::where('score_code', $request->score_code)->first();
            $status1->score_status = $request->score_status;
            $status1->save();
        } else {
            @$max = sizeof($request->check_list);
            for ($i = 0; $i < $max; $i++) {
                $data_check = \App\Score::where('score_code', $request->check_list[$i])->first();
                if (!empty($data_check)) {
                    $status = \App\Score::where('score_code', $request->check_list[$i])->first();
                    $status->score_status = $request->score_status;
                    $status->save();
                }
            }
        }
    }

    public function update_participant(Request $request)
    {
        @$max = sizeof($request->check_list);

        for ($i = 0; $i < $max; $i++) {
            $data_check = \App\Score::where('score_code', $request->check_list[$i])->first();
            if (!empty($data_check)) {
                $data_check->join_status = $request->join_status;
                $data_check->save();
            }

            $checklead = \App\Leaderboard::where('score_code', $request->check_list[$i])->first();
            if ($checklead == null && $request->join_status == 'accepted') {
                $data_score = new \App\Leaderboard;
                $data_score->score_code = $request->check_list[$i];
                $data_score->save();
            }
        }
    }
    public function manage_participant(Request $request, Event $event)
    {
        $field = \App\Field::all();
        $data = \App\Event::where('event_code', $request->event_code)->first();

        $peserta = DB::table('scores')
            ->select('scores.*', 'users.*')
            ->join('users', 'users.id', '=', 'scores.user_id')
            ->where('scores.event_code', $request->event_code)
            ->orderByDesc('scores.join_status')
            ->get();

        // dd($data);
        // dd($event);
        $breadcrumbs = [['link' => "/admin", 'name' => "Home"], ['link' => "/admin/event", 'name' => "Event"], ['name' => "Manage Participant"]];
        return view('/admin/event/manage_participant', [
            'breadcrumbs' => $breadcrumbs,
            'field' => $field,
            'peserta' => $peserta,
            'data' => $data
        ]);
    }
    public function detail_score(Request $request, Event $event)
    {
        $get_data = DB::table('scores')
            ->select(
                'scores.id as score_id',
                'scores.*',
                'strokes.*',
                'putts.*',
                'pen_strokes.*',
                'girs.*',
                'fwies.*',
                'sand_saves.*',
                'events.hole_type',
                'events.event_name',
                'fields.field_name',
                'pars.*',
                'users.*'
            )
            ->join('strokes', 'strokes.score_id', '=', 'scores.id')
            ->join('putts', 'putts.score_id', '=', 'scores.id')
            ->join('pen_strokes', 'pen_strokes.score_id', '=', 'scores.id')
            ->join('girs', 'girs.score_id', '=', 'scores.id')
            ->join('fwies', 'fwies.score_id', '=', 'scores.id')
            ->join('sand_saves', 'sand_saves.score_id', '=', 'scores.id')
            // FIELD DETAILD
            ->join('events', 'events.event_code', '=', 'scores.event_code')
            ->join('fields', 'fields.id', '=', 'events.field_id')
            ->join('pars', 'pars.field_code', '=', 'fields.field_code')
            ->join('users', 'users.id', '=', 'scores.user_id')
            ->where('scores.score_code', '=', $request->score_code)
            ->first();

        $tot_par = 0;
        $start = 0;
        $end = 0;
        if ($get_data->hole_type == 18) {
            $start = 1;
            $end = 18;
        } else if ($get_data->hole_type == 19) {
            $start = 1;
            $end = 9;
        } else if ($get_data->hole_type == 1018) {
            $start = 10;
            $end = 18;
        }

        for ($i = $start; $i <= $end; $i++) {
            $tot_par += $get_data->{"hole_$i"};
        }

        $breadcrumbs = [['link' => "/admin", 'name' => "Home"], ['link' => "/admin/event", 'name' => "Event"], ['link' => "/admin/event/" . $get_data->event_code . "/manage_score", 'name' => "Manage Score"], ['name' => "Detail Score"]];
        return view('/admin/event/detail_score', [
            'breadcrumbs' => $breadcrumbs,
            'get_data' => $get_data,
            'tot_par' => $tot_par,
            'start' => $start,
            'end' => $end,
        ]);
    }
    public function manage_score(Request $request)
    {
        $data = DB::table('events')
            ->select(
                'events.event_code',
                'events.hole_type',
                'events.event_name',
                'events.kick_off',
                'fields.field_name',
                'pars.*'
            )
            // FIELD DETAILD
            ->join('fields', 'fields.id', '=', 'events.field_id')
            ->join('pars', 'pars.field_code', '=', 'fields.field_code')
            ->where('events.event_code', '=', $request->event_code)
            ->first();
        $tot_par = 0;
        $start = 0;
        $end = 0;
        if ($data->hole_type == 18) {
            $start = 1;
            $end = 18;
        } else if ($data->hole_type == 19) {
            $start = 1;
            $end = 9;
        } else if ($data->hole_type == 1018) {
            $start = 10;
            $end = 18;
        }
        for ($i = $start; $i <= $end; $i++) {
            $tot_par += $data->{"hole_$i"};
        }

        $breadcrumbs = [['link' => "/admin", 'name' => "Home"], ['link' => "/admin/event", 'name' => "Event"], ['name' => "Manage Participant"]];
        return view('/admin/event/manage_score', [
            'breadcrumbs' => $breadcrumbs,
            'tot_par' => $tot_par,
            'data' => $data
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

        $field = \App\Field::all();
        $breadcrumbs = [['link' => "/admin", 'name' => "Home"], ['link' => "/admin/event", 'name' => "Event"], ['name' => "Edit"]];
        return view('/admin/event/edit', [
            'breadcrumbs' => $breadcrumbs,
            'data' => $event,
            'field' => $field
        ]);
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

        $waktu = date('ymdhis');
        $file = $request->file('image');
        if (!empty($file)) {
            if (!empty($event->poster)) {
                Storage::disk('public')->delete('masterImages/' . $event->poster);
            }
            $name_file = $waktu . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs(
                'masterImages',
                $name_file,
                'public'
            );
            $event->poster = @$name_file;
        }

        $event->event_name = $request->event_name;
        $event->user_id = 1;
        $event->field_id = $request->field_id;
        $event->teeing_ground = $request->teeing_ground;
        $event->max_player = $request->max_player;
        $event->description = $request->quilltext;
        $event->short_description = $request->short_description;
        $event->event_type = $request->event_type;
        $event->hole_type = $request->hole_type;
        $event->kick_off = $request->kick_off;
        $event->avg_drive = @$request->avg_drive;
        $event->long_drive = @$request->long_drive;
        $event->deadline_register = $request->deadline_register;
        $event->status = $request->status;
        if ($request->calculate_ld == true) {
            $event->calculate_ld = 1;
        } else {
            $event->calculate_ld = 0;
        }



        $event->save();


        $notification = array(
            'message' => 'Update Event Success!',
            'alert-type' => 'success'
        );

        return redirect('/admin/event')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $bawa = Event::where('event_code', $event->event_code)->first();
        Storage::disk('public')->delete('masterImages/' . $bawa->poster);
        $event->delete();
        return;
    }
}