<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Score;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
            //SOALNYA BELUM ADA AUTH
            // ->where('scores.user_id', '=', Auth::id())
            ->first();

        $data = DB::table('scores')
            ->select('scores.id as score_id', 'scores.*', 'events.*', 'fields.*')
            ->join('events', 'events.event_code', '=', 'scores.event_code')
            ->join('fields', 'fields.id', '=', 'events.field_id')
            ->where('scores.join_status', '=', 'accepted')
            // ID MIDDLEWWARE USER
            //SOALNYA BELUM ADA AUTH
            // ->where('scores.user_id', '=', Auth::id())
            // ->where('scores.user_id', '=', Auth::id())
            ->orderByDesc('scores.id')
            ->get();

        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/user/score", 'name' => "Score"], ['name' => "List Score"]];
        return view('/user/score/index', [
            'breadcrumbs' => $breadcrumbs,
            'data' => $data,
            'check' => $check
        ]);
    }
    public function calculate_score(Request $request)
    {
        $data_score =  \App\Score::where('score_code', $request->score_code)->first();
        // Create leaderboard after accepted by admin *not yet
        $leaderboard =  \App\Leaderboard::where('score_code', $request->score_code)->first();
        // dd($leaderboard);

        $waktu = date('ymdhis');
        $file = $request->file('file');
        if (!empty($file)) {
            if (!empty($data_score->score_evidence)) {
                Storage::disk('public')->delete('scoreImages/' . $data_score->score_evidence);
            }
            $name_file = $waktu . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs(
                'scoreImages',
                $name_file,
                'public'
            );
            $data_score->score_evidence = @$name_file;
            $data_score->save();
        }

        // AMBIL DATA SKOR U KALKULASI
        $ambil = DB::table('scores')
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
            ->where('scores.score_code', '=', $request->score_code)
            ->orderByDesc('scores.id')
            ->first();


        // AMBIL DATA SKOR U KALKULASI
        $start = 0;
        $end = 0;
        $tot_strokes_temp = 0;
        $gir_temp = 0;
        $fwh_temp = 0;
        $putts_temp = 0;
        $check_fwh = 0;

        if ($ambil->hole_type == 18) {
            $start = 1;
            $end = 18;
        } else if ($ambil->hole_type == 19) {
            $start = 1;
            $end = 9;
        } else if ($ambil->hole_type == 1018) {
            $start = 10;
            $end = 18;
        }

        for ($i = $start; $i <= $end; $i++) {
            $tot_strokes_temp += $ambil->{"strokes_hole_$i"};
            $gir_temp += $ambil->{"gir_hole_$i"};
            $putts_temp += $ambil->{"putt_hole_$i"};
            if (is_null($ambil->{"fwies_hole_$i"}) == false) {
                $fwh_temp += $ambil->{"fwies_hole_$i"};
                $check_fwh += 1;
            }
        }

        $gir_temp =  ($gir_temp / $end) * 100;

        $fwh_temp = ($fwh_temp / $check_fwh) * 100;
        $putts_temp = $putts_temp / 9;

        // $leaderboard->status = 'waiting';
        $leaderboard->tot_strokes = $tot_strokes_temp;
        $leaderboard->gir = round($gir_temp, 2);
        $leaderboard->fwh = round($fwh_temp, 2);
        $leaderboard->putts = round($putts_temp, 2);


        $leaderboard->save();

        $notification = array(
            'message' => 'Update Score Success!',
            'alert-type' => 'success'
        );

        return redirect('/user/score')->with($notification);
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
    public function show_leaderboard(Request $request)
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
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/user/score", 'name' => "Score"], ['name' => "Leaderboard"]];
        // dd($data);
       
        // dd($tot_par);

        return view('/user/score/leaderboard', [
            'breadcrumbs' => $breadcrumbs,
            
        ]);
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

        $data_str->{"strokes_hole_$lubang"} = $request->total_stroke;
        $data_pt->{"putt_hole_$lubang"} = $request->putt;
        $data_fwy->{"fwies_hole_$lubang"} = $request->fhy;
        $data_gir->{"gir_hole_$lubang"} = $request->gir;
        $data_ps->{"pen_stroke_hole_$lubang"} = $request->pen_stroke;
        $data_ss->{"sand_save_hole_$lubang"} = $request->ss;

        $data_score->{"score_hole_$lubang"} = $request->total_stroke - $request->par_temp;

        $data_str->save();
        $data_pt->save();
        $data_fwy->save();
        $data_gir->save();
        $data_ps->save();
        $data_ss->save();
        $data_score->save();
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
