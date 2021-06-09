<?php

namespace App\Http\Controllers\Admin;

use App\Field;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = \App\Field::all();
        $breadcrumbs = [['link' => "/admin", 'name' => "Home"], ['link' => "/admin/field", 'name' => "Field"], ['name' => "List"]];
        return view('/admin/field/index', [
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
        $breadcrumbs = [['link' => "/admin", 'name' => "Home"], ['link' => "/admin/field", 'name' => "Field"], ['name' => "Create"]];
        return view('/admin/field/create', [
            'breadcrumbs' => $breadcrumbs
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
        // $user = Auth::guard('admin')->user();

        $waktu = date('ymdhis');
        $data = new \App\Field;
        $code = 'FL_' . $waktu;
        $name_file = $waktu . '_' . $request->file('image')->getClientOriginalName();

        $data->field_code =  $code;
        $data->field_name = $request->field_name;
        $data->address = $request->address;
        // $data->id_admin = $user->id;
        $data->image = $name_file;

        $data->save();

        $data_par = new \App\Par;
        //Hole input
        for ($i = 1; $i <= 18; $i++) {
            $data_par->{"hole_" . $i} = $request->{"hole_" . $i};
        }
        $data_par->field_code =  $code;
        $data_par->save();

        $request->file('image')->storeAs(
            'masterImages',
            $name_file,
            'public'
        );
        $notification = array(
            'message' => 'Insert Field Success!',
            'alert-type' => 'success'
        );
        return redirect('/admin/field')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        $breadcrumbs = [['link' => "/admin", 'name' => "Home"], ['link' => "/admin/field", 'name' => "Field"], ['name' => "Detail"]];
        return view('/admin/field/show', [
            'breadcrumbs' => $breadcrumbs,
            'data' => $field
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        $breadcrumbs = [['link' => "/admin", 'name' => "Home"], ['link' => "/admin/field", 'name' => "Field"], ['name' => "Edit"]];
        return view('/admin/field/edit', [
            'breadcrumbs' => $breadcrumbs,
            'data' => $field
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        $bawa = Field::find($field)->first();

        $file = $request->file('image');
        if (!empty($file)) {
            Storage::disk('public')->delete('masterImages/' . $bawa->image);
            $waktu = date('ymdhis');

            $name_file = $waktu . '_' . $request->file('image')->getClientOriginalName();
            $bawa->image = $name_file;
            $request->file('image')->storeAs(
                'masterImages',
                $name_file,
                'public'
            );
        }
        $bawa->field_name = $request->field_name;
        $bawa->address = $request->address;
        $bawa->save();

        $data_par = \App\Par::where('field_code', $request->field_code)->first();
        //Hole input
        for ($i = 1; $i <= 18; $i++) {
            $data_par->{"hole_" . $i} = $request->{"hole_" . $i};
        }
        $data_par->save();

        $notification = array(
            'message' => 'Update Field Success!',
            'alert-type' => 'success'
        );
        return redirect('/admin/field')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        $bawa = Field::where('id',$field->id)->first();
        Storage::disk('public')->delete('masterImages/' . $bawa->image);
        $field->delete();
        return;
    }
}
