@php
$configData = Helper::applClasses();
@endphp
<div
  class="main-menu menu-fixed {{($configData['theme'] === 'dark') ? 'menu-dark' : 'menu-light'}} menu-accordion menu-shadow"
  data-scroll-to-active="true">
  <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item mr-auto">
        <a class="navbar-brand" href="{{url('/')}}">
          <span class="brand-logo">
           <img src="{{asset('storage/coreImages/logoflat.png')}}" alt="">
          </span>
          <h2 class="brand-text">J-Golf</h2>
        </a>
      </li>
      <li class="nav-item nav-toggle">
        <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
          <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
          <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
            data-ticon="disc"></i>
        </a>
      </li>
    </ul>
  </div>
  <?php $cek= Request::segment(1); ?>
  <?php $url= Request::segment(2); ?>
  <?php
    $isadmin;
    if(Auth::guard('admin')->check() && $cek=='admin'){
      $isadmin=true;
    } else {
      $isadmin=false;
    }
  ?>
  <div class="shadow-bottom"></div>
  <?php if($isadmin==true){ ?>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      {{-- Foreach menu item starts --}}
      <li class="nav-item  <?php if(empty($url)){echo "active";} ?>">
        <a href="/admin/" class="d-flex align-items-center" target="_self">
          <i data-feather='home'></i>
          <span class="menu-title text-truncate">Home</span>
        </a>
      </li>
      <li class="nav-item  <?php if($url=='event'){echo "active";} ?>">
        <a href="/admin/event" class="d-flex align-items-center" target="_self">
          <i data-feather='tv'></i>
          <span class="menu-title text-truncate">Manage Event</span>
        </a>
      </li>
      <li class="nav-item <?php if($url=='field'){echo "active";} ?>">
        <a href="/admin/field" class="d-flex align-items-center" target="_self">
          <i data-feather='inbox'></i>
          <span class="menu-title text-truncate">Manage field</span>
        </a>
      </li>
      <br>
      {{-- Foreach menu item ends --}}
    </ul>
  </div>
  <?php }else if($isadmin==false){ ?>
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
      {{-- Foreach menu item starts --}}
      <li class="nav-item  <?php if(empty($url)){echo "active";} ?>">
        <a href="/" class="d-flex align-items-center" target="_self">
          <i data-feather='home'></i>
          <span class="menu-title text-truncate">Home</span>
        </a>
      </li>
      <li class="nav-item  <?php if($url=='score'){echo "active";} ?>">
        <a href="/user/score" class="d-flex align-items-center" target="_self">
          <i data-feather='crosshair'></i>
          <span class="menu-title text-truncate">My Score</span>
        </a>
      </li>
      <li class="nav-item <?php if($url=='event'){echo "active";} ?>">
        <a href="/user/event" class="d-flex align-items-center" target="_self">
          <i data-feather='tv'></i>
          <span class="menu-title text-truncate">All Event</span>
        </a>
      </li>
      <br>
      {{-- Foreach menu item ends --}}
    </ul>
  </div>
  <?php } ?>
</div>
<!-- END: Main Menu-->