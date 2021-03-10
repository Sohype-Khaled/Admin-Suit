@extends('admin-suit::layout.app')


@section('sidebar-header')
    <a href="index.html" class="site_title">
        <i class="fa fa-paw"></i> 
        <span>Gentelella Alela!</span>
    </a>
@endsection


@section('sidebar-user')

    <div class="profile clearfix">
        <div class="profile_pic">
        <img src="{!! asset('admin-suit/production/images/img.jpg') !!}" alt="..." class="img-circle profile_img">
        </div>
        <div class="profile_info">
        <span>Welcome,</span>
        <h2>John Doe</h2>
        </div>
    </div>
  
@endsection

@section('sidebar-menu')
  
@endsection


@section('sidebar-footer')
    <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="Settings">
          <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
          <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Lock">
          <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
          <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
    </div>
@endsection


@section('footer')
    <footer>
        <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
        </div>
        <div class="clearfix"></div>
    </footer>    
@endsection