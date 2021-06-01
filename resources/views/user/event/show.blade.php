@extends('layouts/detachedLayoutMaster')

@section('title', 'Event Detail')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" type="text/css" href="{{ asset('css/base/pages/page-blog.css') }}" />
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
<link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
@endsection

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('content')
<?php 
use Carbon\Carbon;
$url=null;
if (@empty($data->poster)) {
    $url='storage/masterImages/golf-poster.jpg';
}else{
    $url='storage/masterImages/'.$data->poster;
}
    
?>
<!-- Blog Detail -->
<div class="blog-detail-wrapper">
    <div class="row">
        <!-- Blog -->
        <div class="col-12">
            <div class="card">
                <img src="{{ asset($url) }}" class="img-fluid card-img-top" alt="Blog Detail Pic" />
                <div class="card-body">
                    <h4 class="card-title">{{ $data->event_name}}</h4>
                    <div class="media">
                        <div class="avatar mr-50">
                            <img src="{{ asset('images/portrait/small/avatar-s-7.jpg') }}" alt="Avatar" width="24"
                                height="24" />
                        </div>
                        <div class="media-body">
                            <small class="text-muted mr-25">by</small>
                            <small><a href="javascript:void(0);" class="text-body">J-Golf Indonesia</a></small>
                            <span class="text-muted ml-50 mr-25">|</span>
                            <small class="text-muted">{{ Carbon::parse($data->created_at)->isoFormat('LLLL') }}</small>
                        </div>
                    </div>
                    <div class="my-1 py-25">
                        <?php if($data->event_type=='tournament'){ ?>
                        <div class="badge badge-pill badge-warning mr-50">Tournament</div>
                        <?php }else{ ?>
                        <div class="badge badge-pill badge-info mr-50">Game Day</div>
                        <?php }?>
                        <?php if($data->status=='open'){ ?>
                        <div class="badge badge-pill badge-light-success">Open</div>
                        <?php }else if($data->status=='inprogress'){ ?>
                        <div class="badge badge-pill badge-glow badge-warning">In Progress</div>
                        <?php }else if($data->status=='closed'){ ?>
                        <div class="badge badge-pill badge-light-danger">Closed</div>
                        <?php }else if($data->status=='finished'){ ?>
                        <div class="badge badge-pill badge-light-secondary">Finished</div>
                        <?php }?>
                    </div>
                    <div id="snow-container-ku">

                    </div>
                    {{-- <h4 class="mb-75">Deadline Register</h4>
                    <p class="card-text mb-0">
                        {{ Carbon::parse($data->deadline_register)->isoFormat('LLLL') }}
                    </p><br>
                    <h4 class="mb-75">Kick Off</h4>
                    <p class="card-text mb-0">
                        {{ Carbon::parse($data->kick_off)->isoFormat('LLLL') }}
                    </p> --}}
                    <hr class="my-2" />
                    <?php 
                            $collection = \App\Score::where('user_id',Auth::id())
                                    ->where('event_code',$data->event_code)
                                    ->first();
                                   
                    if(@empty($collection)){ ?>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex col-lg-12 col-12 align-items-center">
                            <a onclick="JoinEvent('{{$data->event_code}}')" class="btn btn-success btn-block">Join
                                Event</a>
                        </div>
                    </div>
                    <?php }else{ ?>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="col-lg-12 col-12 align-items-center text-center">
                               <h5>You already applied on this event !</h5>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!--/ Blog -->

        <!-- Blog Comment -->
        <!--/ Leave a Blog Comment -->
    </div>
</div>
<!--/ Blog Detail -->
@endsection
@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection

@section('page-script')
<script src="{{ asset(mix('js/scripts/extensions/ext-component-sweet-alerts.js')) }}"></script>
<script>
    function JoinEvent(key){
    Swal.fire({
        title: 'Confirmation!',
        text: "Do you aggred with the event term & conditions?",
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Yes, understood!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ml-1'
        },
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: '/user/event/join_event',
                data: {_token: "{{ csrf_token() }}",key:key},
                success: function (data) {
                  Swal.fire({
                   icon: 'success',
                   title: 'Success!',
                   text: 'Please wait for the system confirmation.',
                   customClass: {
                     confirmButton: 'btn btn-success'
                   }
                  }).then(function (result) {
                   location.reload();
                  });
                }         
            });
        }
      });
  }
</script>
<script>
    function readURL(input) {
    $('#spinner-img').show();
        const size = (input.files[0].size / 1024 / 1024).toFixed(2);
    if (size > 2) {
        alert('File must be less than 2 MB!');
        $('#imgInp').val(null);
        $('#spinner-img').hide();
    } else {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img-upload').attr('src', e.target.result);
            $('#img-upload').fadeIn("slow");
            $('#spinner-img').hide();
        }
        reader.readAsDataURL(input.files[0]);
        }
        }
    }
    $("#imgInp").change(function() {
        $('#img-upload').hide();
        readURL(this);
    });
</script>
<script>
    var snowEditorku = new Quill('#snow-container-ku', {
        bounds: '#snow-container-ku',
        modules: {
            toolbar: false,
        },
        readOnly: true,
        theme: 'bubble'
    });
    snowEditorku.setContents({!! $data->description !!}); 
        function change_event() {
        var check = $('#event_type').val();
            if(check=='tournament'){
                $("#hole_type").val('18');
                $("#hole_type").prop('disabled',true);
            }else{
                $("#hole_type").val('');
                $("#hole_type").prop('disabled',false);
            }
        }
    function change_calculate(){
        if ($('#calculate_ld').prop('checked') == true) {
            $('.drive_cal').attr('readonly', false);
        }else{
            $('.drive_cal').attr('readonly', true);
            $('.drive_cal').val('');
        }
    }
</script>
@endsection