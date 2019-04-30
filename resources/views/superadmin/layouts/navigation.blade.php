<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ route('superadmin.home') }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-link"></i> Links<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('admin.sections.index') }}">All Sections</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-globe"></i> Domains<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('admin.domains.index') }}">All Domains</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-shield-alt"></i> Firewall<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('admin.firewall.isps') }}">Blocked ISPs</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.firewall.ips') }}">Blocked IPs</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-layer-group"></i> Sections<span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li>
                        <a href="{{ route('superadmin.sections.index') }}">All Sections</a>
                    </li>
                    <li>
                        <a href="{{ route('superadmin.sections.new') }}">Add Section</a>
                    </li>
                </ul>
                <!-- /.nav-third-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-users-cog"></i> Users<span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li>
                        <a href="{{ route('superadmin.users.index') }}">All Users</a>
                    </li>
                    <li>
                        <a href="{{ route('superadmin.company.addNewUser') }}">Add New Users</a>
                    </li>
                </ul>
                <!-- /.nav-third-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-tachometer-alt" aria-hidden="true"></i> Reports<span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li>
                        <a href="{{ route('admin.stats.index') }}">Statistics</a>
                    </li>
                </ul>
                <!-- /.nav-third-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-shield-alt"></i> Companies<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                          <a href="{{ route('superadmin.company.index') }}">Companies</a>
                          <a href="{{ route('superadmin.company.create') }}">Add Company</a>
                    </li>

                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-shield-alt"></i> Company & Section Mapping<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                          <a href="{{ route('superadmin.company.section') }}">Companies Sections</a>
                    </li>

                </ul>
            </li>
        </ul>
    </div>
</div>
