<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Score;

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
    public function edit(Score $score)
    {
        $data = DB::table('scores')
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
                'fields.*',
                'pars.*'
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
            ->where('scores.score_code', '=', $score->score_code)
            ->orderByDesc('scores.id')
            ->first();
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/user/score", 'name' => "Score"], ['name' => "Update Score"]];
        return view('/user/score/edit', [
            'breadcrumbs' => $breadcrumbs,
            'data' => $data
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
    public function update_score(Request $request)
    {
        $data_str = \App\Stroke::where('score_id', $request->score_id)->first();
        $data_pt = \App\Putt::where('score_id', $request->score_id)->first();
        $data_fwy = \App\Fwy::where('score_id', $request->score_id)->first();
        $data_gir = \App\Gir::where('score_id', $request->score_id)->first();
        $data_ps = \App\PenStroke::where('score_id', $request->score_id)->first();
        $data_ss = \App\SandSave::where('score_id', $request->score_id)->first();
        $data_score = \App\Score::where('id', $request->score_id)->first();

        $lubang = $request->hole_temp;

        

        $data_score->{"score_hole_$lubang"} = $request->total_stroke - $request->par_temp;

        
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
