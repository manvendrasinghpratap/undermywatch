<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ route('user.home') }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-link"></i> Links<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('user.sections.index') }}">All Sections</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-globe"></i> Domains<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('user.domains.index') }}">All Domains</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-tachometer-alt" aria-hidden="true"></i> Reports<span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li>
                        <a href="{{ route('user.stats.userstats') }}">Statistics</a>
                    </li>
                </ul>
                <!-- /.nav-third-level -->
            </li>
        </ul>
    </div>
</div>
