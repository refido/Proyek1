@extends('layouts/contentLayoutMaster')

@section('title', 'Score')
@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection
@section('content')
<!-- Examples -->
<section id="card-demo-example">
    <div class="row match-height">
        <?php 
            use Carbon\Carbon;
            if(@empty($check)){?>
        <div class="col-md-12 col-12 text-center">
            <p>You haven't join any event yet.</p>
        </div>
        <?php } ?>
        @foreach ($data as $item)
        <?php
        $url=null;
        if (@empty($item->poster)) {
            $url='storage/masterImages/golf-poster.jpg';
        }else{
            $url='storage/masterImages/'.$item->poster;
        }
            
        ?>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$item->event_name}}</h4>
                    <h6 class="card-subtitle text-muted">{{$item->field_name}}</h6>
                </div>
                <img style="height: 234px" class="img-fluid" src="{{ asset($url) }}" alt="Card image cap" />
                <div class="card-body">
                    <p class="card-text">{{$item->short_description}}</p>
                </div>
                <div class="card-footer text-center">
                    <?php if($item->status=='open'){ ?>
                    <h4 class="card-title">Event has not started yet</h4>
                    <?php }else if($item->status=='inprogress'){ ?>
                    <a href="/user/score/{{$item->score_code}}/edit" class="btn btn-success"><i data-feather='dribbble'></i> My Score</a>
                    <a href="/user/score/leaderboard/{{$item->event_code}}" class="btn btn-primary"><i data-feather='award'></i> Rankings</a>
                    {{-- <a href="/user/score/{{$item->score_id}}/edit" class="btn btn-primary">Leaderboard</a> --}}
                    <?php }else if($item->status=='finished'){ ?>
                    <a href="/user/score/leaderboard/{{$item->event_code}}" class="btn btn-primary"><i data-feather='award'></i> Rankings</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
<!-- Examples -->

<!--/ Card layout -->
@endsection

@section('vendor-script')
{{-- vendor files --}}
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
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