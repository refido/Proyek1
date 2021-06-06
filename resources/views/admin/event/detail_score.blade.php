@extends('layouts/contentLayoutMaster')

@section('title', 'Detail Score')

@section('vendor-style')
<link rel="stylesheet" href="{{asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css'))}}">
<link rel="stylesheet" href="{{asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css'))}}">
@endsection
@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-invoice-list.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
<style>
    .div-ku {
        width: 15px;
        border-radius: 2px;
        height: 15px;
        float: left;
        margin-top: 2px;
        margin-right: 4px;
    }
</style>
@endsection

@section('content')
<section class="app-user-view">
    <!-- User Card & Plan Starts -->
    <div class="row">
        <!-- User Card starts-->
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="card user-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                            <div class="user-avatar-section">
                                <div class="d-flex justify-content-start">
                                    <?php 
                  if(empty($get_data->image)){
                  $url1='storage/coreImages/user.png';
                  }else{
                      $url1='storage/profileImages/'.$get_data->image;
                  }
                 
                   ?>
                                    <img class="img-fluid rounded" src="{{asset($url1)}}" height="104" width="104"
                                        alt="User avatar" />
                                    <div class="d-flex flex-column ml-1" style="margin-top:35px">
                                        <div class="user-info mb-1">
                                            <h4 class="mb-0">{{$get_data->name}}</h4>
                                            <?php if(!empty($get_data->birth_date)){ 
                         $dateOfBirth = $get_data->birth_date;
                         $today = date("Y-m-d");
                         $diff = date_diff(date_create($dateOfBirth), date_create($today));
                        ?>
                                            <span class="card-text">{{$diff->format('%y')}} years old</span><br>
                                            <?php }?>
                                            <?php if(!empty($get_data->gender)){ ?>
                                            <span class="card-text">{{$get_data->gender}}</span><br>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center user-total-numbers">
                                <div class="d-flex align-items-center mr-2">
                                    <div class="color-box bg-light-primary">
                                        <i data-feather='award'></i>
                                    </div>
                                    <div class="ml-1">
                                        <h5 class="mb-0">{{$get_data->event_name}}</h5>
                                        <small>Event Name</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="color-box bg-light-success">
                                        <i data-feather='airplay'></i>
                                    </div>
                                    <div class="ml-1">
                                        <h5 class="mb-0">{{$get_data->field_name}}</h5>
                                        <small>Golf Course</small>
                                    </div>
                                </div>
                            </div>
                            <?php
              $collection = \App\Leaderboard::where('leaderboards.score_code',$get_data->score_code)->first();
              ?>
                        </div>
                        <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                            <div class="user-info-wrapper">
                                <div class="d-flex flex-wrap">
                                    <div class="user-info-title">
                                        <i data-feather="minus" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">To Par</span>
                                    </div>
                                    <p class="card-text mb-0">
                                        <?php if(($collection->tot_strokes - $tot_par)>0){ echo "+";}?>{{ ($collection->tot_strokes -$tot_par)}}
                                    </p>
                                </div>
                                <div class="d-flex flex-wrap my-50">
                                    <div class="user-info-title">
                                        <i data-feather="check" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">Green in R.</span>
                                    </div>
                                    <p class="card-text mb-0">{{$collection->gir}}%</p>
                                </div>
                                <div class="d-flex flex-wrap my-50">
                                    <div class="user-info-title">
                                        <i data-feather="star" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">Fairway Hit</span>
                                    </div>
                                    <p class="card-text mb-0">{{$collection->fwh}}%</p>
                                </div>
                                <div class="d-flex flex-wrap my-50">
                                    <div class="user-info-title">
                                        <i data-feather="flag" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">Putts</span>
                                    </div>
                                    <p class="card-text mb-0">{{$collection->putts}}</p>
                                </div>
                                <div class="d-flex flex-wrap my-50">
                                    <div class="user-info-title">
                                        <i data-feather="key" class="mr-1"></i>
                                        <span class="card-text user-info-title font-weight-bold mb-0">Status</span>
                                    </div>
                                    <?php if($get_data->score_status=='waiting'){ ?>
                                    <div class="badge badge-warning">Waiting</div>
                                    <?php }elseif($get_data->score_status=='correct'){?>
                                    <div class="badge badge-primary">Correct</div>
                                    <?php }elseif($get_data->score_status=='false'){?>
                                    <div class="badge badge-danger">False</div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /User Card Ends-->

        <!-- Plan Card starts-->
        <!-- /Plan CardEnds -->
    </div>
    <!-- User Card & Plan Ends -->
    <div class="row invoice-list-wrapper">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>HOLE</th>
                            @for ($i = $start; $i <= $end; $i++) <th>{{$i}}</th>
                                @endfor
                                <th>TOT</th>
                        </tr>
                        <tr>
                            <th>Par</th>
                            @for ($i = $start; $i <= $end; $i++) <td><?php echo $get_data->{"hole_$i"};?></td>
                                @endfor
                                <td>{{ $tot_par }}</td>
                        </tr>
                        <tr>
                            <th>Score</th>
                            @for ($i = $start; $i <= $end; $i++) <td>
                                <?php 
                  $tmp=$get_data->{"strokes_hole_$i"}-$get_data->{"hole_$i"};
                  if($tmp<-1 && $get_data->{"hole_$i"}==3){ ?>
                                <div class="text-center bg-secondary bg-lighten-4 shadow div-ku shadow"
                                    title="A perfect stroke in golf or we said it as?" style="width: 20px;height:20px">
                                    {{ $get_data->{"strokes_hole_$i"} }}
                                </div>
                                <?php }else if($tmp==-1){ ?>
                                <div class="text-center bg-success bg-lighten-4 shadow div-ku shadow"
                                    style="width: 20px;height:20px">
                                    {{ $get_data->{"strokes_hole_$i"} }}
                                </div>
                                <?php }else if($tmp<-1){ ?>
                                <div class="text-center bg-warning bg-lighten-4 shadow div-ku shadow"
                                    style="width: 20px;height:20px">
                                    {{ $get_data->{"strokes_hole_$i"} }}
                                </div>
                                <?php }else if($tmp==0){ ?>
                                {{ $get_data->{"strokes_hole_$i"} }}
                                <?php }else if($tmp==1){ ?>
                                <div class="text-center bg-danger bg-lighten-4 shadow div-ku shadow"
                                    style="width: 20px;height:20px">
                                    {{ $get_data->{"strokes_hole_$i"} }}
                                </div>
                                <?php }else if($tmp>1){ ?>
                                <div class="text-center bg-info bg-lighten-4 shadow div-ku shadow"
                                    style="width: 20px;height:20px">
                                    {{ $get_data->{"strokes_hole_$i"} }}
                                </div>
                                <?php } ?>
                                </td>
                                @endfor
                                <td>{{ $collection->tot_strokes }}</td>
                        </tr>
                        <tr>
                            <td colspan="{{($end+2)}}">
                                <div class="d-inline-block mr-1" style="padding: 0px;">
                                    <div class="bg-warning bg-lighten-4 shadow div-ku"></div>
                                    <span class="card-text user-info-title">EAGLE</span>
                                </div>
                                <div class="d-inline-block mr-1" style="padding: 0px;">
                                    <div class="bg-success bg-lighten-4 shadow div-ku"></div>
                                    <span class="card-text user-info-title">BIRDIE</span>
                                </div>
                                <div class="d-inline-block mr-1" style="padding: 0px;">
                                    <div class="bg-danger bg-lighten-4 shadow div-ku"></div>
                                    <span class="card-text user-info-title">BOGEY</span>
                                </div>
                                <div class="d-inline-block mr-1" style="padding: 0px;">
                                    <div class="bg-info bg-lighten-4 shadow div-ku"></div>
                                    <span class="card-text user-info-title">DBL BOGEY OR MORE</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Invoice Ends-->
    <div class="row invoice-list-wrapper">
        <div class="col-12">
            <div class="card user-card p-1">
                <div class="row">
                    <div class="col-lg-12 col-md-12 text-center">
                        <h3>Score Evidence</h3>
                        <img class="img-fluid rounded image-show" id="img-upload" alt="No Score Image"
                            src="{{asset("storage/scoreImages/".$get_data->score_evidence) }}" width="100%" /><br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row invoice-list-wrapper">
        <div class="col-12">
            <div class="card user-card p-1">
                <div class="row">
                    <div class="col-6 col-md-6 col-sm-6">
                        <button onclick="save_data('false')" class="btn btn-danger  btn-block"
                            style="margin-right: 10px">False</button>
                    </div>
                    <div class="col-6 col-md-6 col-sm-6">
                        <button onclick="save_data('correct')" class="btn btn-primary  btn-block">Correct</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('vendor-script')
<script src="{{asset(mix('vendors/js/extensions/moment.min.js'))}}"></script>
<script src="{{asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js'))}}"></script>
<script src="{{asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js'))}}"></script>
<script src="{{asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js'))}}"></script>
<script src="{{asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js'))}}"></script>
<script src="{{asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js'))}}"></script>
<script src="{{asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js'))}}"></script>
@endsection
@section('page-script')
{{-- Page js files --}}
<script src="{{ asset(mix('js/scripts/pages/app-user-view.js')) }}"></script>
<div id="modalku" class="zoom-modal">
    <i data-feather='x' class="zoom-close font-large-1 mr-50" onclick="closezoom()"></i>
    <img class="zoom-modal-content" id="img01">
    <div id="caption"></div>
</div>
<script>
    var modal = document.getElementById("modalku");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
  
    $(document).on("click", ".image-show", function(e) {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.title;
        $("body").addClass("modal-open");
    });
  
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("zoom-close")[0];
    
    window.onclick = function(event) {
    if (event.target == modal) {
        closezoom();
    }
    }
    // When the user clicks on <span> (x), close the modal
    function closezoom() {
        modal.style.display = "none";
        $("body").removeClass("modal-open");
    }
</script>
<script>
    function save_data(key){
      $.ajax({
            url: "/admin/event/update_score",
            type:"POST",
            data:{
              score_status:key,
              score_code:'{{ $get_data->score_code }}',
              _token: '{{ csrf_token() }}'
            },
            success:function(response){},
            complete: function() {
                alert('Data updated Successfully!')
                window.location.href= "/admin/event/" + '{{ $get_data->event_code }}' + "/manage_score";
            },
          });
       
      }
</script>
@endsection