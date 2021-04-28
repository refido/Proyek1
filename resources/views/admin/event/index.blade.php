@extends('layouts/contentLayoutMaster')

@section('title', 'Events')

@section('vendor-style')
{{-- vendor css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" type="text/css" href="{{asset('css/base/plugins/forms/pickers/form-flat-pickr.css')}}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
<link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">

@endsection

@section('content')
<section id="advanced-search-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">List Records</h4>
                    <a href="/admin/event/create" class="btn create-new btn-primary">
                        <i data-feather="plus"></i>
                        Add Event
                    </a>
                </div>
                <div class="card-datatable">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Event Name</th>
                                <th>Event Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td></td>
                                <td>{{$item->event_name}}</td>
                                <td>{{ucwords($item->event_type)}}</td>
                                <td>{{ucwords($item->status)}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                                            <i data-feather='more-vertical' class="font-small-4"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="/admin/event/{{$item->event_code}}/manage_participant" class="dropdown-item"><i data-feather='users' class="font-small-4 mr-50"></i> Manage Participants</a>
                                            <a href="/admin/event/{{$item->event_code}}/manage_score" class="dropdown-item"><i data-feather='crosshair' class="font-small-4 mr-50"></i> Manage Scoreboard</a>
                                            <a href="/admin/event/{{$item->event_code}}" class="dropdown-item"><i data-feather='eye' class="font-small-4 mr-50"></i> Detail Event</a>
                                            <a href="/admin/event/{{$item->event_code}}/edit" class="dropdown-item"><i data-feather='archive' class="font-small-4 mr-50"></i> Edit Event</a>
                                            <a onclick="confirmDelete('{{$item->event_code}}')" id="delete-confirm" class="dropdown-item delete-record">
                                                <i data-feather='trash-2' class="font-small-4 mr-50"></i> Delete Event</a>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Event Name</th>
                                <th>Event Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('vendor-script')
{{-- vendor files --}}
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection

@section('page-script')
{{-- Page js files --}}

<script src="{{ asset(mix('js/scripts/tables/table-datatables-advanced.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/extensions/ext-component-toastr.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/extensions/ext-component-sweet-alerts.js')) }}"></script>
<script>
    var modal = document.getElementById("modalku");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    $(document).on("click", ".image-show", function(e) {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.title;
    });
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("zoom-close")[0];
    // When the user clicks on <span> (x), close the modal
    function closezoom() {
        modal.style.display = "none";
    }
</script>
<script>
    function confirmDelete(key) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ml-1'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: '/admin/event/' + key,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Your file has been deleted.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        }).then(function(result) {
                            location.reload();
                        });
                    }
                });
            }
        });
    }
</script>
<script>
    // agar icon menjadi svg jika <i> tidak keluar di popup
    feather.replace();
    $(document).ready(function() {
        $('#myTable').DataTable({
            columns: [{
                    data: 'responsive_id'
                },
                {
                    data: 'event_name'
                },
                {
                    data: 'event_type'
                },
                {
                    data: 'status'
                },
                {
                    data: 'actions'
                }
            ],
            columnDefs: [{
                // For Responsive
                className: 'control',
                orderable: false,
                responsivePriority: 30,
                targets: 0
            }, ],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            orderCellsTop: true,
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Details of ' + data['event_name'];
                        }
                    }),
                    type: 'column',
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table',
                        columnDefs: [{
                            targets: 1,
                            visible: false
                        }]
                    })
                }
            },
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            }
        });
    });
</script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
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