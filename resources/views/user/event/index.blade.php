@extends('layouts/contentLayoutMaster')

@section('title', 'Event')
@section('vendor-style')
<!-- vendor css files -->

@endsection
@section('page-style')
<!-- Page css files -->

@endsection
@section('content')
<!-- Examples -->
<section id="card-demo-example">

    <?php if(@empty($check)){ ?>
    <div class="col-md-12 col-12 text-center">
        <p>Currently no events available.</p>
    </div>
    <?php }else{ ?>
    {{-- <div class="row text-center " style="margin-bottom: 20px">
        <div class="col-md-4 col-12 ">
            <div class="blog-search">
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" placeholder="Search event..." />
                    <div class="input-group-append">
                        <span class="input-group-text cursor-pointer">
                            <i data-feather="search"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row match-height">
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
        <div class="col-md-4 col-12">
            <div class="card">
                <a href="/user/event/{{$item->id}}">
                    <img style="height: 234px" class="card-img-top img-fluid" src="{{ asset($url) }}"
                        alt="Image Not Found" />
                </a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="/user/event/{{$item->id}}" class="blog-title-truncate text-body-heading">
                            {{ $item->event_name}}</a>
                    </h4>
                    <div class="media">
                        <div class="avatar mr-50">
                            <img src="{{ asset('images/portrait/small/avatar-s-7.jpg') }}" alt="Avatar" width="24"
                                height="24" />
                        </div>
                        <div class="media-body">
                            <small class="text-muted mr-25">by</small>
                            <small><a href="#" class="text-body">J-Golf Indonesia</a></small>
                            <span class="text-muted ml-50 mr-25">|</span>
                            <small
                                class="text-muted">{{ Carbon\Carbon::parse($item->created_at)->isoFormat('LL') }}</small>
                        </div>
                    </div>
                    <div class="my-1 py-25">
                        <?php if($item->event_type=='tournament'){ ?>
                        <div class="badge badge-pill badge-warning mr-50">Tournament</div>
                        <?php }else{ ?>
                        <div class="badge badge-pill badge-info mr-50">Game Day</div>
                        <?php }?>
                        <?php if($item->status=='open'){ ?>
                        <div class="badge badge-pill badge-light-primary">Open</div>
                        <?php }else if($item->status=='inprogress'){ ?>
                        <div class="badge badge-pill badge-glow badge-success">In Progress</div>
                        <?php }else if($item->status=='closed'){ ?>
                        <div class="badge badge-pill badge-light-dark">Closed</div>
                        <?php }else if($item->status=='finished'){ ?>
                        <div class="badge badge-pill badge-light-secondary">Finished</div>
                        <?php }?>
                    </div>
                    {{-- <p class="card-text blog-content-truncate">
                            {{ $item->short_description}}
                    </p> --}}
                    <hr />
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="/user/event/{{$item->event_code}}" class="btn btn-primary btn-block">View Details</a>
                    </div>
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

@endsection

@section('page-script')
{{-- Page js files --}}

@endsection