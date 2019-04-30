<!-- top navbar-->
      <header class="topnavbar-wrapper">
         <!-- START Top Navbar-->
         <nav class="navbar topnavbar">
            <!-- START navbar header-->
            <div class="navbar-header"><a class="navbar-brand" href="#/">
                  <div class="brand-logo"><img class="img-fluid" src="{{ asset('assets/img/logo.png')}} " alt="App Logo"></div>
                  <div class="brand-logo-collapsed"><img class="img-fluid" src="{{ asset('assets/img/logo-single.png')}} " alt="App Logo"></div>
               </a></div><!-- END navbar header-->
            <!-- START Left navbar-->
            <ul class="navbar-nav mr-auto flex-row">
               <li class="nav-item">
                  <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops--><a class="nav-link d-none d-md-block d-lg-block d-xl-block" href="#" data-trigger-resize="" data-toggle-state="aside-collapsed"><em class="fas fa-bars"></em></a><!-- Button to show/hide the sidebar on mobile. Visible on mobile only.--><a class="nav-link sidebar-toggle d-md-none" href="#" data-toggle-state="aside-toggled" data-no-persist="true"><em class="fas fa-bars"></em></a></li>
            </ul><!-- END Left navbar-->
            <!-- START Right Navbar-->

            <ul class="navbar-nav flex-row">
               <li class="nav-item d-none d-md-block"><a class="nav-link" href="#" data-toggle-fullscreen=""><em class="fas fa-expand"></em></a></li>
               <!-- START Offsidebar button
               <li class="nav-item"><a class="nav-link" href="#" data-toggle-state="offsidebar-open" data-no-persist="true"><em class="icon-notebook"></em></a></li> END Offsidebar menu-->
            </ul>
            <ul class="nav navbar-top-links navbar-righ">
                <li class="dropdown">
                    <a class="dropdown-toggle textcolor" data-toggle="dropdown" href="#" style="text-decoration:none; margin-right:25px;">
                        <i class="fa fa-user fa-fw">&nbsp;</i> {{ @Auth::user()->name }} &nbsp;&nbsp;
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a style="text-decoration:none;"  href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
            <!-- END Right Navbar-->
         </nav>
         <!-- END Top Navbar-->
      </header><!-- sidebar-->

      <aside class="aside-container">
         <!-- START Sidebar (left)-->
         <div class="aside-inner">
            <nav class="sidebar" data-sidebar-anyclick-close="">
               <!-- START sidebar nav-->
               <ul class="sidebar-nav">
                  <!-- Iterates over all sidebar items-->
                  <li  class="@if(Route::current()->getName() == 'admin.home')) active @endif " >
                    <a href="{{ route('admin.home') }}"  title="Dashboard"><em class="far fa fa-rainbow"></em><span>Dashboard</span></a></li>
                  <li class="@if(((Request::segment('2')=='sections') && (Request::segment('1')=='admin') ) ||(Request::segment('2')=='campaigns') || ((Request::segment('1')=='admin') && (Request::segment('2')=='section'))) active @endif">
                    <a href="{{ route('admin.sections.index') }}" title="Campaigns"><em class="far fa fa-mask"></em><span>Campaigns</span></a>
                  </li>
                  <li class="@if((Request::segment('2')=='domains') || (Request::segment('2')=='domain')) active @endif">
                    <a href="{{ route('admin.domains.index') }}" title="Domains"><em class="far fa fa-list-ul"></em><span>Domains</span></a>
                  </li>
                  <li class=" @if(((Request::segment('2')=='users') && (Request::segment('1')=='admin') ) || ((Request::segment('2')=='usersetting') && (Request::segment('1')=='admin')) || ((Request::segment('2')=='userstatsUserId') && (Request::segment('1')=='admin')) ) active @endif"><a href="{{ route('admin.users.index') }}" title="Campaigns"><em class="far fa fa-users"></em><span>Users</span></a></li>
                  <li class="@if(((Request::segment('2')=='company') && (Request::segment('3')=='assignedsection'))) active @endif">
                    <a href="{{route('admin.company.assignedsection')}}" title="Ghost Shields"><em class="far fa fa-ghost"></em><span>Ghost Shields </span></a>
                  </li>
                  <li class="@if(((Request::segment('2')=='stats') && (Request::segment('1')=='admin')) || (Request::segment('2')=='companystats') && (Request::segment('1')=='admin'))) active @endif">
                    <a href="{{route('admin.stats.companystats')}}" title="Reports"><em class="far fa fa-chart-line"></em><span>Reports</span></a>
                  </li>
               </ul><!-- END sidebar nav-->
            </nav>
         </div><!-- END Sidebar (left)-->
      </aside><!-- offsidebar-->
