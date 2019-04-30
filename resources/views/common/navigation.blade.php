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
                        <li><a  style="text-decoration:none;" href="{{ route('logout') }}"
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
                  <li class="nav-heading "><span>Navigation</span></li>
                  <li  class="@if(Route::current()->getName() == 'superadmin.home')) active @endif " >
                    <a href="{{route('superadmin.home')}}" title="Dashboard"><em class="far fa fa-rainbow"></em><span>Dashboard</span></a></li>
                  <li class="@if(Route::current()->getName() =='superadmin.campaign.index') active @endif"><a href="{{route('superadmin.campaign.index')}}" title="Campaigns"><em class="far fa fa-mask"></em><span>Campaigns</span></a></li>
                  <li class="@if(Route::current()->getName()=='admin.domains.index') active @endif"><a href="{{ route('admin.domains.index') }}" title="Domains"><em class="far fa fa-list-ul"></em><span>Domains</span></a></li>
                    <li  class="@if(Route::current()->getName() == 'admin.stats.index')) active @endif " >
                    <a href="{{route('admin.stats.index')}}" title="Reports"><em class="far fa fa-chart-line"></em><span>Reports</span></a>
                  </li>
                  <li class="@if((Request::segment('3')=='firewall')) active @endif">
                    <a href="#superwall" title="Superwall" data-toggle="collapse"><em class="far fa fa-shield-alt"></em><span>Firewall</span></a>
                     <ul class="sidebar-nav sidebar-subnav collapse" id="superwall">
                          <li  class="@if(Route::current()->getName() == 'superadmin.sections.index')) active @endif " >
                          <a href="{{route('superadmin.sections.index')}}" title="Ghost Shields"><em class="far fa fa-ghost"></em><span>Ghost Shields </span></a></li>
                        <li  class="@if(Route::current()->getName() == 'admin.firewall.whiteisps')) active @endif " >
                          <a href="{{route('admin.firewall.whiteisps')}}" title="Google Range"><em class="far fa fa-skull"></em><span>Google Range</span></a></li>

                          <li  class="@if(Route::current()->getName() == 'admin.firewall.whiteisps')) active @endif " >
                          <a href="{{route('admin.firewall.whiteisps')}}" title="Whitelist ISPs"><em class="far fa fa-praying-hands"></em><span>Whitelist ISPs</span></a>
                        </li>

                        <li  class="@if(Route::current()->getName() == 'admin.firewall.isps')) active @endif " >
                          <a href="{{route('admin.firewall.isps')}}" title="Blacklist ISPs"><em class="far fa fa-ban"></em><span>Blacklist ISPs</span></a>
                        </li>

                        <li  class="@if(Route::current()->getName() == 'admin.firewall.ips')) active @endif " >
                          <a href="{{route('admin.firewall.ips')}}?type=review" title="Blacklist IPs"><em class="far fa fa-stop-circle"></em><span>Blacklist IPs</span></a>
                        </li>
                        <li  class="@if(Route::current()->getName() == 'admin.firewall.whiteisps')) active @endif " >
                          <a href="{{route('admin.firewall.whiteisps')}}" title="Referral Log"><em class="far fa fa-registered"></em><span>Referral Log</span></a></li>
                        <li  class="@if(Route::current()->getName() == 'admin.firewall.whiteisps')) active @endif " >
                          <a href="{{route('admin.firewall.whiteisps')}}" title="UA Log"><em class="far fa fa-asterisk"></em><span>UA Log</span></a></li>
                     </ul>
                  </li>
                  <li class=" "><a href="#pubs" title="Users" data-toggle="collapse"><em class="far fa fa-users"></em><span>Users</span></a>
                     <ul class="sidebar-nav sidebar-subnav collapse" id="pubs">
                        <li  class="@if(Route::current()->getName() == 'superadmin.users.index')) active @endif " >
                          <a href="{{ route('superadmin.users.index') }}" title="Users"><em class="far fa fa-users"></em><span>Users</span></a></li>
                          <li  class="@if(Route::current()->getName() == 'superadmin.company.index') active @endif " >
                          <a href="{{ route('superadmin.company.index') }}" title="Company"><em class="far fa fa-building"></em><span>Companies</span></a></li>
                          <li  class="@if(Route::current()->getName() == 'superadmin.affiliates.index')) active @endif " >
                          <a href="{{route('superadmin.affiliates.index')}}" title="Affiliates"><em class="far fa fa-user-secret"></em><span>Affiliates</span></a></li>
                     </ul>
                  </li>
                  <li  class="@if(Route::current()->getName() == 'superadmin.support.index')) active @endif " ><a href="{{ route('superadmin.support.index') }}" title="Supports"><em class="far fa fa-briefcase-medical"></em><span>Support</span></a></li>
                  <li  class="@if(Route::current()->getName() == 'superadmin.guide.index')) active @endif " ><a href="{{ route('superadmin.guide.index') }}" title="Guides"><em class="far fa fa-book"></em><span>Guide</span></a></li>
               </ul><!-- END sidebar nav-->
            </nav>
         </div><!-- END Sidebar (left)-->
      </aside><!-- offsidebar-->
