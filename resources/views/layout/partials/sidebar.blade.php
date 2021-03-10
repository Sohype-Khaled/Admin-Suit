<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            @yield('sidebar-header')
        </div>

        <div class="clearfix"></div>

        @yield('sidebar-user')

        <br />


        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            @yield('sidebar-menu')
        </div>

        
       @yield('sidebar-footer')
    </div>
</div>
