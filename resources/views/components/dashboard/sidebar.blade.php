<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <li class="nav-item sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-text mx-3">Volunteers System</div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Dashboard Link -->
    <li class="nav-item">
        <a class="nav-link text-light bg-dark {{ request()->routeIs('dashboard') ? 'border border-light' : '' }}"
            href="{{ route('dashboard') }}">
            <i class="fas fa-tachometer-alt text-light"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link text-light bg-dark {{ request()->routeIs('assignment.index') ? 'border border-light' : '' }}"
            href="{{ route('assignment.index') }}">
            <i class="fas fa-file-signature text-light"></i>
            <span>Assignments</span>
        </a>

    </li>
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link text-light bg-dark {{ request()->routeIs('volunteers.index') ? 'border border-light' : '' }}"
            href="{{ route('volunteers.index') }}">
            <i class="fas fa-fw fa-male text-light"></i>
            <span>Volunteers</span>
        </a>


    </li>
    <hr class="sidebar-divider">


    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link text-light bg-dark {{ request()->routeIs('workplaces.index') ? 'border border-light' : '' }}"
            href="{{ route('workplaces.index') }}">
            <i class="fas fa-fw fa-home text-light"></i>
            <span>Workplaces</span>
        </a>

    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link text-light bg-dark {{ request()->routeIs('tasks.index') ? 'border border-light' : '' }}"
            href="{{ route('tasks.index') }}">
            <i class="fas fa-fw fa-tasks text-light"></i>
            <span>Tasks</span>
        </a>

    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-5">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
