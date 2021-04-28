@extends('layouts/contentLayoutMaster')

@section('title', 'Event')
@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/katex.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/monokai-sublime.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.snow.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/editors/quill/quill.bubble.css')) }}">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Inconsolata&family=Roboto+Slab&family=Slabo+27px&family=Sofia&family=Ubuntu+Mono&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">



@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-quill-editor.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection
@section('content')

<!-- Basic File Browser start -->
<section id="input-file-browser">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail Event</h4>
                </div>
                <div class="card-body">
                    <form method="POST" id="formKu" autocomplete="off" action="/admin/event/{{$data->id}}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="event_name">Event Name</label>
                                    <input readonly id="event_name" class="form-control" value="{{$data->event_name}}" name="event_name" type="text" placeholder="Insert Event Name" required />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="event_type">Event Type</label>
                                    <select disabled id="event_type" name="event_type" onchange="change_event()" class="form-control" required>
                                        <option value="">Select Event Type</option>
                                        <option <?php if ($data->event_type == 'tournament') {
                                                    echo "selected";
                                                } ?> value="tournament">Tournament</option>
                                        <option <?php if ($data->event_type == 'gameday') {
                                                    echo "selected";
                                                } ?> value="gameday">Game Day</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="teeing_ground">Teeing Ground</label>
                                    <select disabled id="teeing_ground" name="teeing_ground" class="form-control" required>
                                        <option value="">Select Teeing Ground</option>
                                        <option <?php if ($data->teeing_ground == 'black') {
                                                    echo "selected";
                                                } ?> value="black">Black</option>
                                        <option <?php if ($data->teeing_ground == 'blue') {
                                                    echo "selected";
                                                } ?> value="blue">Blue</option>
                                        <option <?php if ($data->teeing_ground == 'white') {
                                                    echo "selected";
                                                } ?> value="white">White</option>
                                        <option <?php if ($data->teeing_ground == 'red') {
                                                    echo "selected";
                                                } ?> value="red">
                                            Red</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="max_player">Max Player</label>
                                    <input readonly id="max_player" value="{{$data->max_player}}" class="form-control" name="max_player" type="number" placeholder="Insert Max Player" required />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="fp-date-time">Kick Off Time</label>
                                    <input type="text" value="{{$data->kick_off}}" disabled id="fp-date-time" name="kick_off" class="form-control" required placeholder="Select Kick Off Time" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="fp-date-time2">Deadline Register</label>
                                    <input type="text" value="{{$data->deadline_register}}" disabled id="fp-date-time2" required name="deadline_register" class="form-control" placeholder="Select Deadline Registration For The Tournament" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="field">Field</label>
                                    <select disabled id="field" name="field_id" required class="form-control">
                                        <option value="">Select Field</option>
                                        @foreach ($field as $item)
                                        <option <?php if ($data->field_id == $item->id) {
                                                    echo "selected";
                                                } ?> value="{{$item->id}}">{{$item->field_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="custom-control custom-switch custom-switch custom-switch-success">
                                    <p class="mb-50">Calculate Drive</p>
                                    <input disabled type="checkbox" onchange="change_calculate()" name="calculate_ld" class="custom-control-input" id="calculate_ld" <?php if ($data->calculate_ld == 1) {
                                                                                                                                                                            echo "checked";
                                                                                                                                                                        } ?> />
                                    <label class="custom-control-label" for="calculate_ld">
                                        <span class="switch-icon-left"><i data-feather="check"></i></span>
                                        <span class="switch-icon-right"><i data-feather="x"></i></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="wewa">Created by</label>
                                    <input readonly type="text" class="form-control " name="image" id="wewa" value="Daffavcd" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="hole_type">Hole Type</label>
                                    <select disabled id="hole_type" onchange="check_hole()" name="hole_type" class="form-control" required>
                                        <option value="">Select Hole Type</option>
                                        <option <?php if ($data->hole_type == '19') {
                                                    echo "selected";
                                                } ?> value="19">1 - 9
                                            Hole</option>
                                        <option <?php if ($data->hole_type == '1018') {
                                                    echo "selected";
                                                } ?> value="1018">10
                                            - 18 Hole</option>
                                        <option <?php if ($data->hole_type == '18') {
                                                    echo "selected";
                                                } ?> value="18">18
                                            Hole</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 text-center">
                                <div class="spinner-border" id="spinner-img" style="display: none"></div>
                                <img class="img-fluid rounded" id="img-upload" alt="No poster Image" src="{{asset("storage/masterImages/".$data->poster) }}" width="100%" /><br><br>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea readonly id="short_description" name="short_description" class="form-control" required placeholder="Type event short decription for front view purpose..." />{{$data->short_description}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <label>Type the event description bellow.</label>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div id="snow-wrapper">
                                                        <div id="snow-container-ku">
                                                            <div class="quill-toolbar">
                                                                <span class="ql-formats">
                                                                    <select class="ql-header">
                                                                        <option value="1">Heading</option>
                                                                        <option value="2">Subheading</option>
                                                                        <option selected>Normal</option>
                                                                    </select>
                                                                    <select class="ql-font">
                                                                        <option selected>Sailec Light</option>
                                                                        <option value="sofia">Sofia Pro</option>
                                                                        <option value="slabo">Slabo 27px</option>
                                                                        <option value="roboto">Roboto Slab</option>
                                                                        <option value="inconsolata">Inconsolata
                                                                        </option>
                                                                        <option value="ubuntu">Ubuntu Mono</option>
                                                                    </select>
                                                                </span>
                                                                <span class="ql-formats">
                                                                    <button class="ql-bold"></button>
                                                                    <button class="ql-italic"></button>
                                                                    <button class="ql-underline"></button>
                                                                </span>
                                                                <span class="ql-formats">
                                                                    <button class="ql-list" value="ordered"></button>
                                                                    <button class="ql-list" value="bullet"></button>
                                                                </span>
                                                                <span class="ql-formats">
                                                                    <button class="ql-link"></button>
                                                                    <button class="ql-image"></button>
                                                                    <button class="ql-video"></button>
                                                                </span>
                                                                <span class="ql-formats">
                                                                    <button class="ql-formula"></button>
                                                                    <button class="ql-code-block"></button>
                                                                </span>
                                                                <span class="ql-formats">
                                                                    <button class="ql-clean"></button>
                                                                </span>
                                                            </div>
                                                            <div class="editor">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                    <h4 class="card-title">Detail Event Configuration</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-6">
                            <div class="form-group">
                                <label for="avg_drive">Average Drive</label>
                                <input id="avg_drive" class="form-control drive_cal" disabled value="{{$data->avg_drive}}" name="avg_drive" type="text" placeholder="Insert Average Drive" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-6">
                            <div class="form-group">
                                <label for="long_drive">Long Drive</label>
                                <input id="long_drive" class="form-control drive_cal" disabled value="{{$data->long_drive}}" name="long_drive" type="text" placeholder="Insert Long Drive" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-12">
                            <div class="form-group">
                                <label for="status">Status Event</label>
                                <select id="status" class="form-control" disabled name="status" required />
                                <option value="">Select Event Status</option>
                                <option <?php if ($data->status == 'open') {
                                            echo "selected";
                                        } ?> value="open">Open</option>
                                <option <?php if ($data->status == 'inprogress') {
                                            echo "selected";
                                        } ?> value="inprogress">
                                    Inprogress</option>
                                <option <?php if ($data->status == 'closed') {
                                            echo "selected";
                                        } ?> value="closed">Closed
                                </option>
                                <option <?php if ($data->status == 'finished') {
                                            echo "selected";
                                        } ?> value="finished">
                                    Finished</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/editors/quill/katex.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/highlight.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/editors/quill/quill.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/forms/form-tooltip-valid.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
<script>
    var form = document.getElementById('formKu');
    form.onsubmit = function() {
        // Populate hidden form on submit
        var wew = document.querySelector('input[name=quilltext]');
        wew.value = JSON.stringify(snowEditorku.getContents());
        $("#hole_type2").val($("#hole_type").val());
        return true;
    };
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
    var Font = Quill.import('formats/font');
    Font.whitelist = ['sofia', 'slabo', 'roboto', 'inconsolata', 'ubuntu'];
    Quill.register(Font, true);
    var snowEditorku = new Quill('#snow-container-ku .editor', {
        bounds: '#snow-container-ku .editor',
        modules: {
            formula: true,
            syntax: true,
            toolbar: '#snow-container-ku .quill-toolbar'
        },
        readOnly: true,
        placeholder: 'Write everything on your mind right here...',
        theme: 'snow'
    });
    $(document).ready(function() {
        change_calculate();
    });
    <?php if ($data->event_type == 'tournament') { ?>
        change_event();
    <?php } ?>
    snowEditorku.setContents({
        !!$data - > description!!
    });

    function change_event() {
        var check = $('#event_type').val();
        if (check == 'tournament') {
            $("#hole_type").val('18');
            $("#hole_type").prop('disabled', true);
        } else {
            $("#hole_type").val('');
            $("#hole_type").prop('disabled', false);
        }
    }

    function change_calculate() {
        if ($('#calculate_ld').prop('checked') == true) {
            $('.drive_cal').attr('readonly', false);
        } else {
            $('.drive_cal').attr('readonly', true);
            $('.drive_cal').val('');
        }
    }
</script>
@endsection