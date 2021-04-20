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
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="defaultInput">Field Name</label>
                                <input id="defaultInput" class="form-control" type="text" placeholder="Normal Input" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="defaultInput">Address</label>
                                <input id="defaultInput" class="form-control" type="text" placeholder="Normal Input" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="customFile">Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="imgInp" />
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 text-center">
                            <div class="spinner-border" id="spinner-img" style="display: none"></div>
                            <img class="img-fluid rounded" id="img-upload" width="100%" />
                        </div>
                    </div>
                    <div class="row" style="text-align: right;margin-top: 10px">
                        <div class="col-lg-12 col-md-12">
                            <button class="btn btn-primary pull-right" type="submit">Submit</button>
                        </div>
                    </div>
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
    $(document).ready(function() {
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
            $('#spinner-img').hide();
        }
        $("#imgInp").change(function() {
            $('#spinner-img').show();
            readURL(this);
        });
    });
</script>
@endsection