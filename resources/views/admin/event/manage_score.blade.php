@extends('layouts/contentLayoutMaster')

@section('title', 'Review Score')
@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')) }}">
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
                <h4 class="card-title">Score of {{$data->event_name}}</h4>
            </div>
            <div class="card-datatable">
                <table class="datatables-basic table" id="myTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Player</th>
                            <th>To Par</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $collection = \App\Score::where('scores.event_code',$data->event_code)
                            // ->where('leaderboards.status','accepted')
                            ->Join('leaderboards', 'leaderboards.score_code', '=', 'scores.score_code')
                            ->Join('users', 'users.id', '=', 'scores.user_id')
                            ->orderBy('score_status', 'asc')
                            ->get();
                            
                        ?>
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
                        <tr>
                            <td>
                                {{$item->score_code}}
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
                            <td>

                                <?php if($item->score_status=='waiting'){ ?>
                                <div class="badge badge-warning">Waiting</div>
                                <?php }elseif($item->score_status=='correct'){?>
                                <div class="badge badge-primary">Correct</div>
                                <?php }elseif($item->score_status=='false'){?>
                                <div class="badge badge-danger">False</div>
                                <?php } ?>
                            </td>
                            <td><a href="/admin/event/{{$item->score_code}}/detail_score" class="btn btn-success"><i
                                        data-feather='eye'></i> Detail</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right all"><button onclick="save_data('false')"
                                    class="btn btn-danger pull-right" style="margin-right: 10px">False</button><button
                                    onclick="save_data('correct')" class="btn btn-primary pull-right">Correct</button>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('vendor-script')
{{-- vendor files --}}
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
@endsection
@section('page-script')
<script src="{{ asset(mix('js/scripts/tables/table-datatables-advanced.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/form-tooltip-valid.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
<script>
    function save_data(key){
      var check_list = new Array();
      
        $("input[name='check_list[]']:checked").each(function() {
          check_list.push($(this).val());
        });
        var isChecked = $("input[name='check_list[]']").is(":checked");
        if(isChecked==true){
      $.ajax({
            url: "/admin/event/update_score",
            type:"POST",
            data:{
              score_status:key,
              check_list:check_list,
              _token: '{{ csrf_token() }}'
            },
            success:function(response){},
            complete: function() {
                location.reload();
            },
          });
        }else{
          alert('You need to at least choose 1 participant!')
        }
      }
</script>
<script>
    feather.replace();
     $(document).ready(function (){
    $('#myTable').DataTable( {
        columns: [
          { data: 'score_code' },
          { data: 'name' },
          { data: 'to_par' },
          { data: 'score_status' },
          { data: 'action' }
        ],
        columnDefs: [
        {
          // For Checkboxes
          targets: 0,
          orderable: false,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            return (
              '<div class="custom-control custom-checkbox"> <input class="custom-control-input dt-checkboxes" name="check_list[]" type="checkbox" value="' + data + '" id="check_list" /><label class="custom-control-label" for="checkbox' +
              data +
              '"></label></div>'
            );
          },
          checkboxes: {
            selectAllRender:
              '<div class="custom-control custom-checkbox"> <input class="custom-control-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="custom-control-label" for="checkboxSelectAll"></label></div>'
          }
        }
        ],
        dom:
          '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        orderCellsTop: true,
        language: {
          paginate: {
            // remove previous & next text from pagination
            previous: '&nbsp;',
            next: '&nbsp;'
          }
        }
      } );
    });
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