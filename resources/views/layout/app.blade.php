<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="{!! asset('admin-suit/vendors/bootstrap/dist/css/bootstrap.min.css') !!}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{!! asset('admin-suit/vendors/font-awesome/css/font-awesome.min.css') !!}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{!! asset('admin-suit/vendors/nprogress/nprogress.css') !!}" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="{!! asset('admin-suit/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') !!}"
          rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="{!! asset('admin-suit/build/css/custom.min.css') !!}" rel="stylesheet">
    <link rel="stylesheet" href="{!! url('https://unpkg.com/@vueform/multiselect@1.3.4/themes/default.css') !!}">
    @stack('css')
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
    @include('admin-suit::layout.partials.sidebar')

    @include('admin-suit::layout.partials.header')

    <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>@yield('title')</h3>
                    </div>

                    <div class="title_right">
                        <div class="pull-right">
                            @yield('actions')
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                @yield('content')
            </div>
        </div>
        <!-- /page content -->
        <x-admin-suit::action-modal/>
        <!-- footer content -->
    @yield('footer')
    <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="{!! asset('admin-suit/vendors/jquery/dist/jquery.min.js') !!}"></script>
<!-- Bootstrap -->
<script src="{!! asset('admin-suit/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') !!}"></script>
<!-- FastClick -->
<script src="{!! asset('admin-suit/vendors/fastclick/lib/fastclick.js') !!}"></script>
<!-- NProgress -->
<script src="{!! asset('admin-suit/vendors/nprogress/nprogress.js') !!}"></script>
<!-- jQuery custom content scroller -->
<script src="{!! asset('admin-suit/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') !!}"></script>

<!-- Custom Theme Scripts -->
<script src="{!! asset('admin-suit/build/js/custom.min.js') !!}"></script>

<!-- Admin Suit Scripts -->
<script src="{!! url('https://unpkg.com/vue@next') !!}"></script>

<script src="{!! url('https://unpkg.com/axios/dist/axios.min.js') !!}"></script>

<script src="{!! url('https://unpkg.com/@vueform/multiselect@1.3.4/dist/multiselect.global.js') !!}"></script>

<script src="{!! asset('admin-suit/vendors/moment/min/moment.min.js') !!}"></script>


<script src="{!! asset('admin-suit/admin-suit/js/forms.js') !!}"></script>

<script src="{!! asset('admin-suit/admin-suit/js/actions.js') !!}"></script>

<script src="{!! asset('admin-suit/admin-suit/js/listing-view.js') !!}"></script>

<script src="{!! asset('admin-suit/admin-suit/js/apps.js') !!}"></script>

@stack('js')


</body>
</html>