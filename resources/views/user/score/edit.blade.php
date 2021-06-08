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
        clear_data();
        $('#large').modal('hide');
    }
    function click_skor(score1,hole1,par1){
        var score =score1;
        var hole =hole1;
        var par =par1;
        if(par<=3){
            $('#div-fwy').hide();
            $(".radio-fhy").prop('checked', false);
        }else{
            $('#div-fwy').show();
        }
        // AMBIL DATA
        $.ajax({
            url: "/user/score/get_score",
            type:"POST",
            dataType: 'json',
            data:{
              score_id:score1,
              hole_temp:hole1,
              _token: '{{ csrf_token() }}'
            },
            success: function(ambil){
                if(ambil.strokes!=null){
                    $("#total_stroke").val(ambil.strokes);
                    $('#putt').val(ambil.putt);
                    $('#pen_stroke').val(ambil.pen_stroke);
                }
                if(ambil.gir==1){
                 $("#customRadio1").prop('checked', true);
                }else if(ambil.gir==0){
                 $("#customRadio2").prop('checked', true);
                }
                if(ambil.fwies==1){
                 $("#customRadio3").prop('checked', true);
                }else if(ambil.fwies==0){
                 $("#customRadio4").prop('checked', true);
                }
                if(ambil.sand_save==1){
                 $("#customRadio5").prop('checked', true);
                }else if(ambil.sand_save==0){
                 $("#customRadio6").prop('checked', true);
                }
                $('#score_id').val(score);
                $('#hole_temp').val(hole);
                $('#par_temp').val(par);
                $(".modal-header").html('<h4 class="modal-title label-hole" id="myModalLabel17"><i data-feather="user" style="width: 2.286rem;height: 2.286rem;"></i> MY SCORE FOR HOLE '+ hole + '</h4><button type="button" class="close" onclick="close_modal()"><span aria-hidden="true">&times;</span></button>');
                feather.replace();
                $('#large').modal('show');
            },
        });
        //  AMBIL DAAATA
    }
    function clear_data(){
       $('#total_stroke').val('0');
       $('#putt').val('0');
       $('#pen_stroke').val('0');
       $(".radio-gir").prop('checked', false);
       $(".radio-fhy").prop('checked', false);
       $(".radio-ss").prop('checked', false);
    }
    function save_data(){
        var score_id = $('#score_id').val();
        var hole_temp = $('#hole_temp').val();
        var par_temp = $('#par_temp').val();
        var total_stroke = $('#total_stroke').val();
        var putt = $('#putt').val();
        var pen_stroke = $('#pen_stroke').val();
        var gir = $("input[name='gir']:checked").val();
        var fhy = $("input[name='fhy']:checked").val();
        var ss = $("input[name='ss']:checked").val();
        var tampung = parseInt(total_stroke) - parseInt(par_temp);
        if(tampung>0){
            tampung='+'+tampung;
        }
        if(total_stroke=='0' || total_stroke==''){
            alert('You have to insert total stroke');
        }else if(! $(".radio-gir").is(':checked')){
            alert('You have to choose green in regulation');
        }else if(par_temp>3 && ! $(".radio-fhy").is(':checked')){
            alert('You have to choose fairway hit');
        }else{
            $.ajax({
            url: "/user/score/update_score",
            type:"POST",
            data:{
              score_id:score_id,
              hole_temp:hole_temp,
              par_temp:par_temp,
              total_stroke:total_stroke,
              putt:putt,
              pen_stroke:pen_stroke,
              gir:gir,
              fhy:fhy,
              ss:ss,
              _token: '{{ csrf_token() }}'
            },
            success:function(response){},
            complete: function() {
                $('#skor_show_'+hole_temp).html('<h1 class="display-5"> '+ tampung +' </h1>');
                $('#large').modal('hide');
                clear_data();
            },
            });
        }
    }
</script>
@endsection