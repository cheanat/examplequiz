<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SY MARK</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            {{-- <i class="fas fa-fw fa-tachometer-alt" style="font-size: 1.5em;font-style:italic"></i> --}}
            <span style="font-size: 1.5em;font-style:italic">Dashboard</span></a>
    </li>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('category.index') }}">
            {{-- <i class="fas fa-fw fa-tachometer-alt" style="font-size: 1.5em;font-style:italic"></i> --}}
            <span style="font-size: 1.5em;font-style:italic">Category</span></a>
    </li>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('quiz') }}">
            {{-- <i class="fas fa-fw fa-tachometer-alt" style="font-size: 1.5em;font-style:italic"></i> --}}
            <span style="font-size: 1.5em;font-style:italic">Quiz</span></a>
    </li>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" style="cursor: pointer">
            {{-- <i class="fas fa-fw fa-tachometer-alt" style="font-size: 1.5em;font-style:italic"></i> --}}
            <span style="font-size: 1.5em;font-style:italic">User</span></a>
    </li>
    <hr class="sidebar-divider my-0">












</ul>