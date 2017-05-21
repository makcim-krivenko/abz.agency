<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{url('/home/')}}">adminKa</a>
    </div>
    <!-- /.navbar-header -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="{{url('/home/')}}"><i class="fa fa-dashboard fa-fw"></i> Home</a>
                </li>
                <li>
                    <a href="{{url('/employees/')}}"><i class="fa fa-files-o fa-fw"></i> Employees<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="/employees/">All Employees</a>
                        </li>
                        <li>
                            <a href="/employees/create/">Add New</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>