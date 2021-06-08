@extends('layouts/contentLayoutMaster')

@section('title', 'Input Score')
@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')) }}">
@endsection
@section('content')
<style>
    .popup-skor:hover {
        background-color: aliceblue;
        cursor: pointer;
    }
</style>
<!-- Bordered table start -->
<div class="row" id="table-bordered">
    <div class="col-12">
        <div class="card text-center">
            <div class="card-header text-center" style="display: block;">
                <h2>{{$data->field_name}}</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Hole</th>
                            <th>Par</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dari=0;
                        $sampai=0;
                            if($data->hole_type=='19'){
                                $dari=1;
                                $sampai=9;
                            }elseif ($data->hole_type=='1018') {
                                $dari=10;
                                $sampai=18;
                            }elseif ($data->hole_type=='18') {
                                $dari=1;
                                $sampai=18;
                            }
                            ?>
                        @for ($i = $dari; $i <= $sampai; $i++) <tr>
                            <td>
                                <h1 class="display-5">{{ $i }}</h1>
                            </td>
                            <td>
                                <input type="hidden" id="{{$i}}" value="{{ $data->{"hole_$i"} }}">
                                <h1 class="display-5">{{ $data->{"hole_$i"} }}</h1>
                            </td>
                            <td id="skor_show_{{$i}}" class="popup-skor"
                                onclick="click_skor({{$data->score_id}},{{$i}},{{ $data->{"hole_$i"} }})">
                                <h1 class="display-5">
                                    <?php if($data->{"score_hole_$i"}>0){ echo '+';} ?>{{ $data->{"score_hole_$i"} }}
                                </h1>
                            </td>
                            </tr>
                            @endfor
                    </tbody>
                    <input name="hole_type" id="hole_type2" value="" type="hidden">

                    <tfoot>
                        <form method="POST" id="formKu" autocomplete="off" action="/user/score/calculate_score"
                            enctype="multipart/form-data">
                            @csrf
                            <tr>
                                <td colspan="3">
                                    @if (!empty($data->score_evidence))
                                    <h6>You can still changes the evidence.</h6>
                                    @endif
                                    <div class="custom-file">
                                        <input value="{{$data->event_code}}" name="event_code" type="hidden">
                                        <input value="{{$data->score_code}}" name="score_code" type="hidden">
                                        <input type="file" name="file" <?php  if(empty($data->score_evidence)) echo  'required';
                                        ?> class="custom-file-input" name="image" id="imgInp" />
                                        <label class="custom-file-label" for="customFile">Choose Evidence</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <button class="btn btn-primary btn-block waves-effect" type="submit">Calculate My
                                        Score</button>
                                </td>
                            </tr>
                        </form>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade text-left" id="large" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

            </div>
            <div class="modal-body">
                <input type="hidden" type="number" id="score_id">
                <input type="hidden" type="number" id="hole_temp">
                <input type="hidden" type="number" id="par_temp">
                <div class="row">
                    <div class="col-6 col-lg-6 col-md-6">
                        <h4>Total Strokes</h4>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="input-group input-group-lg">
                            <input type="number" id="total_stroke" class="touchspin" value="0" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-6 col-lg-6 col-md-6">
                        <h4>Putts</h4>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="input-group input-group-lg">
                            <input type="number" id="putt" class="touchspin" value="0" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-6 col-lg-6 col-md-6">
                        <h4>Pen. Strokes</h4>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="input-group input-group-lg">
                            <input type="number" id="pen_stroke" class="touchspin" value="0" />
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-6 col-lg-6 col-md-6">
                        <h4>Green in Reg</h4>
                    </div>
                    <div class="form-check form-check-inline">
                        <div class="custom-control custom-radio" style="margin-left: 27px">
                            <input type="radio" id="customRadio1" value="1" name="gir"
                                class="custom-control-input radio-gir" />
                            <label class="custom-control-label" for="customRadio1">Yes</label>
                        </div>
                    </div>
                    <div class="form-check form-check-inline" style="margin-left: 2px;">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio2" value="0" name="gir"
                                class="custom-control-input radio-gir" />
                            <label class="custom-control-label" for="customRadio2">No</label>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;" id="div-fwy">
                    <div class="col-6 col-lg-6 col-md-6">
                        <h4>Fairway Hit</h4>
                    </div>
                    <div class="form-check form-check-inline">
                        <div class="custom-control custom-radio" style="margin-left: 27px">
                            <input type="radio" id="customRadio3" value="1" name="fhy"
                                class="custom-control-input radio-fhy" />
                            <label class="custom-control-label" for="customRadio3">Yes</label>
                        </div>
                    </div>
                    <div class="form-check form-check-inline" style="margin-left: 2px;">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio4" value="0" name="fhy"
                                class="custom-control-input radio-fhy" />
                            <label class="custom-control-label" for="customRadio4">No</label>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-6 col-lg-6 col-md-6">
                        <h4>Sand Save</h4>
                    </div>
                    <div class="form-check form-check-inline">
                        <div class="custom-control custom-radio" style="margin-left: 27px">
                            <input type="radio" id="customRadio5" value="1" name="ss"
                                class="custom-control-input radio-ss" />
                            <label class="custom-control-label" for="customRadio5">Yes</label>
                        </div>
                    </div>
                    <div class="form-check form-check-inline" style="margin-left: 2px;">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio6" value="0" name="ss"
                                class="custom-control-input radio-ss" />
                            <label class="custom-control-label" for="customRadio6">No</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="clear_data()">Clear</button>
                <button type="button" class="btn btn-primary" onclick="save_data()">Save</button>
            </div>
        </div>
    </div>
</div>

@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')) }}"></script>
@endsection
@endsection
@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-number-input.js')) }}"></script>
<script>
    function close_modal(){
        
        $('#large').modal('hide');
    }
    function click_skor(){
        
                $('#large').modal('show');
        
        //  AMBIL DAAATA
    }
</script>
@endsection