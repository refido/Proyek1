@extends('layouts/contentLayoutMaster')

@section('title', 'Input Score')
@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')) }}">
@endsection
@section('content')
<style>
    .popup-skor:hover {
        background-color: aliceblue;
        cursor: pointer;
    }
</style>
<!-- Bordered table start -->
<div class="row" id="table-bordered">
    <div class="col-12">
        <div class="card text-center">
            <div class="card-header text-center" style="display: block;">
                <h2>Senayan Jakarta</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Hole</th>
                            <th>Par</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dari=1;
                        $sampai=18;
                        ?>
                        @for ($i = $dari; $i <= $sampai; $i++) <tr>
                            <td>
                                <h1 class="display-5">{{ $i }}</h1>
                            </td>
                            <td>
                                <h1 class="display-5">{{ $i }}</h1>
                            </td>
                            <td>

                            </td>
                            </tr>
                            @endfor
                    </tbody>
                    <input name="hole_type" id="hole_type2" value="" type="hidden">

                    <tfoot>
                        <form method="POST" id="formKu" autocomplete="off" action="" enctype="multipart/form-data">
                            @csrf

                            <tr>
                                <td colspan="3">
                                    <button class="btn btn-primary btn-block waves-effect" type="submit">Calculate My
                                        Score</button>
                                </td>
                            </tr>
                        </form>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')) }}"></script>
@endsection
@endsection
@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-number-input.js')) }}"></script>

@endsection