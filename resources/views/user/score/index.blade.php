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
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">The International</h4>
                    <h6 class="card-subtitle text-muted">Senayan Jakarta</h6>
                </div>
                <img style="height: 234px" class="img-fluid" src="{{ asset('storage/masterImages/golf-poster.jpg') }}"
                    alt="Card image cap" />
                <div class="card-body">
                    <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas, magnam quibusdam
                        repellat voluptas vero odit ut veniam voluptate ratione doloremque quod, facere commodi minus
                        sunt quisquam consequatur at a quos?</p>
                </div>
                <div class="card-footer text-center">

                    <a href="/user/score/2/edit" class="btn btn-success"><i data-feather='dribbble'></i> My Score</a>
                    <a href="#" class="btn btn-primary"><i data-feather='award'></i> Rankings</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">The International</h4>
                    <h6 class="card-subtitle text-muted">Senayan Jakarta</h6>
                </div>
                <img style="height: 234px" class="img-fluid" src="{{ asset('storage/masterImages/golf-poster.jpg') }}"
                    alt="Card image cap" />
                <div class="card-body">
                    <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas, magnam quibusdam
                        repellat voluptas vero odit ut veniam voluptate ratione doloremque quod, facere commodi minus
                        sunt quisquam consequatur at a quos?</p>
                </div>
                <div class="card-footer text-center">

                    <a href="/user/score/2/edit" class="btn btn-success"><i data-feather='dribbble'></i> My Score</a>
                    <a href="#" class="btn btn-primary"><i data-feather='award'></i> Rankings</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">The International</h4>
                    <h6 class="card-subtitle text-muted">Senayan Jakarta</h6>
                </div>
                <img style="height: 234px" class="img-fluid" src="{{ asset('storage/masterImages/golf-poster.jpg') }}"
                    alt="Card image cap" />
                <div class="card-body">
                    <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas, magnam quibusdam
                        repellat voluptas vero odit ut veniam voluptate ratione doloremque quod, facere commodi minus
                        sunt quisquam consequatur at a quos?</p>
                </div>
                <div class="card-footer text-center">

                    <a href="/user/score/2/edit" class="btn btn-success"><i data-feather='dribbble'></i> My Score</a>
                    <a href="#" class="btn btn-primary"><i data-feather='award'></i> Rankings</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">The International</h4>
                    <h6 class="card-subtitle text-muted">Senayan Jakarta</h6>
                </div>
                <img style="height: 234px" class="img-fluid" src="{{ asset('storage/masterImages/golf-poster.jpg') }}"
                    alt="Card image cap" />
                <div class="card-body">
                    <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas, magnam quibusdam
                        repellat voluptas vero odit ut veniam voluptate ratione doloremque quod, facere commodi minus
                        sunt quisquam consequatur at a quos?</p>
                </div>
                <div class="card-footer text-center">

                    <a href="/user/score/2/edit" class="btn btn-success"><i data-feather='dribbble'></i> My Score</a>
                    <a href="#" class="btn btn-primary"><i data-feather='award'></i> Rankings</a>
                </div>
            </div>
        </div>
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