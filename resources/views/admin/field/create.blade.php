@extends('layouts/contentLayoutMaster')

@section('title', 'Field')

@section('content')

<!-- Basic File Browser start -->
<section id="input-file-browser">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Input Field</h4>
                </div>
                <div class="card-body">
                    <form method="POST" autocomplete="off" action="/admin/field" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="defaultInput">Field Name</label>
                                    <input id="defaultInput" class="form-control" name="field_name" type="text"
                                        placeholder="Insert Field Name" required />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="defaultInput">Address</label>
                                    <input id="defaultInput" class="form-control" name="address" type="text"
                                        placeholder="Insert Address" required />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="customFile">Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image"  id="imgInp" required />
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 text-center">
                                <div class="spinner-border" id="spinner-img" style="display: none"></div>
                                <img class="img-fluid rounded" id="img-upload" alt="Image Error" style="display: none" width="100%" />
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="input-file-browser">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Input Hole Detail</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @for ($i = 1; $i <= 18; $i++) <div class="col-lg-2 col-md-6 col-6 <?php if($i>9){ echo "par-18";} ?>">
                            <div class="form-group">
                                <label for="hole_{{$i}}">PAR Hole {{$i}}</label>
                                <input id="hole_{{$i}}" class="form-control" required
                                    name="hole_{{$i}}" type="number" placeholder="PAR Hole {{$i}}" />
                            </div>
                    </div>
                    @endfor
                </div>
                <div class="row" style="text-align: right;margin-top: 10px">
                    <div class="col-lg-12 col-md-12">
                        <button class="btn btn-primary pull-right" type="submit">Submit</button>
                    </div>
                </div>
                
                </form>
            </div>
        </div>
    </div>
    </div>
</section>

@endsection

@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/forms/form-tooltip-valid.js')) }}"></script>
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