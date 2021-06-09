@extends('layouts/contentLayoutMaster')

@section('title', 'Field')

@section('content')

<!-- Basic File Browser start -->
<section id="input-file-browser">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Field Detail</h4>
                </div>
                <div class="card-body">
                    <form method="POST" autocomplete="off" action="/admin/field/{{$data->id}}"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="defaultInput">Field Name</label>
                                    <input type="hidden"  name="field_code" value="{{$data->field_code}}">
                                    <input id="defaultInput" readonly class="form-control" name="field_name" type="text"
                                        placeholder="Insert Field Name" value="{{$data->field_name}}" required />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="defaultInput">Address</label>
                                    <input id="defaultInput" readonly class="form-control" name="address" type="text"
                                        placeholder="Insert Address" value="{{$data->address}}" required />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="customFile">Image</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 text-center">
                                <div class="spinner-border" id="spinner-img" style="display: none"></div>
                                <img class="img-fluid rounded clicked image-show"
                                    src="{{asset('storage/masterImages/'.$data->image)}}" id="img-upload"
                                    alt="Image Error" width="100%" />
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$get_par = \App\Par::where('field_code',$data->field_code)->first();
?>
<section id="input-file-browser">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Hole Detail</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @for ($i = 1; $i <= 18; $i++) <div
                            class="col-lg-2 col-md-6 col-6 <?php if($i>9){ echo "par-18";} ?>">
                            <div class="form-group">
                                <label for="hole_{{$i}}">PAR Hole {{$i}}</label>
                                <input id="hole_{{$i}}" readonly class="form-control" required name="hole_{{$i}}" value="{{ $get_par->{"hole_$i"} }}" type="number"
                                    placeholder="PAR Hole {{$i}}" />
                            </div>
                    </div>
                    @endfor
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</section>
<div id="modalku" class="zoom-modal">
    <i data-feather='x' class="zoom-close font-large-1 mr-50" onclick="closezoom()"></i>
    <img class="zoom-modal-content" id="img01">
    <div id="caption"></div>
</div>


@endsection

@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/forms/form-tooltip-valid.js')) }}"></script>
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
		        
		        reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                    $('#img-upload').fadeIn("slow");
                    $('#spinner-img').hide();
                }
                reader.readAsDataURL(input.files[0]);
            }
            }
		}
		$("#imgInp").change(function(){
            $('#img-upload').hide();
            readURL(this);
		}); 
</script>
@endsection