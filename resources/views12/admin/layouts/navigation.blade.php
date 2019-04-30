<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ route('admin.home') }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
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
                <a href="#"><i class="fa fa-shield-alt"></i> Users<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                          <a href="{{ route('admin.users.index') }}">All Users</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.create') }}">Add User</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-shield-alt"></i> Sections<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                      <a href="{{ route('admin.company.assignedsection') }}">All Sections</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-tachometer-alt" aria-hidden="true"></i> Reports<span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li>
                        <a href="{{ route('admin.stats.companystats') }}">Statistics</a>
                    </li>
                </ul>
                <!-- /.nav-third-level -->
            </li>

        </ul>
    </div>
</div>
