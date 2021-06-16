@extends('layouts/contentLayoutMaster')

@section('title', 'Rankings')
@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection
@section('content')
<style>
    .row-ku:hover {
        cursor: pointer;
        background-color: aliceblue;
    }
</style>
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">The {{$data->event_name}}</h4>
            </div>
            <div class="card-body">
                <p class="card-text">

                    {{ Carbon\Carbon::parse($data->kick_off)->isoFormat('LL') }}<br>
                    Course {{ $data->field_name }}<br>
                    Par {{ $tot_par }}<br>
                </p>
            </div>
            {{-- <div class="avatar-wrapper"><div class="avatar bg-light-danger mr-50"><div class="avatar-content">LA</div></div></div> --}}
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>RANK</th>
                            <th>PLAYER</th>
                            <th>TO PAR</th>
                            <th>GIR</th>
                            <th>FWH</th>
                            <th>AVG Putts</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $collection = \App\Score::where('scores.event_code',$data->event_code)
                            // ->where('leaderboards.status','accepted')
                            ->Join('leaderboards', 'leaderboards.score_code', '=', 'scores.score_code')
                            ->Join('users', 'users.id', '=', 'scores.user_id')
                            ->where('score_status','correct')
                            ->orderBy('tot_strokes', 'asc')
                            ->get();
                            
                            $check = \App\Score::where('scores.event_code',$data->event_code)
                            ->where('score_status','correct')
                            ->first();
                        ?>
                        @if (@empty($check))
                        <tr>
                            <td colspan="6" class="text-center">Please wait for admin to review this rankings.</td>
                        </tr>
                        @endif
                        @foreach ($collection as $item)
                        <?php 
                        // dd($item);
                        $random = rand(0,6);
                        $warna = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                        $state = $warna[$random];
                        $words = explode(" ", ucwords($item->name));
                        $acronym = "";
                        foreach ($words as $w) {
                         $acronym .= $w[0];
                        }
                        $nama_singkat = explode(' ', $item->name);
                        
                        ?>
                        <tr class="row-ku" onclick="detail_click('{{$item->score_code}}')">
                            <td>
                                {{$loop->iteration }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-left align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar bg-light-<?php echo $state ;?> mr-1">
                                            <span class="avatar-content"><?php echo $acronym[0].@$acronym[1]; ?></span>
                                        </div>
                                        <span class="avatar-status-online"></span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a class="user_name text-truncate">
                                            <span class="font-weight-bold">
                                                <?php if(@empty($acronym[1])){ ?>
                                                <?php echo  $nama_singkat[0] ?>
                                                <?php }else{ ?>
                                                <?php echo $acronym[0];?>. {{$nama_singkat[1]}}
                                                <?php } ?>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php if(($item->tot_strokes - $tot_par)>0){ echo "+";}?>{{ ($item->tot_strokes -$tot_par)}}
                            </td>
                            <td>{{$item->gir}}%</td>
                            <td>{{$item->fwh}}%</td>
                            <td>{{$item->putts}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="6">
                                *if you not see any of your score,please contact admin.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('vendor-script')
{{-- vendor files --}}
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection
@section('page-script')
<script>
    function detail_click(score_code){
        document.location.href = '/user/score/detailed_player/'+score_code;
    }
</script>
{{-- Page js files --}}
<script>
    @if(Session::has('message'))
      var type = "{{ Session::get('alert-type', 'info') }}";
      switch(type){
          case 'info':
              toastr.info("{{ Session::get('message') }}");
              break;
          
          case 'warning':
              toastr.warning("{{ Session::get('message') }}");
              break;
  
          case 'success':
              toastr.success("{{ Session::get('message') }}");
              break;
  
          case 'error':
              toastr.error("{{ Session::get('message') }}");
              break;
      }
    @endif
</script>
@endsection