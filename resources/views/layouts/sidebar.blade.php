<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('index') }}" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span>Dashboard</span>
                    </a>
                  
                </li> <!-- end Dashboard Menu -->


              

                <li class="menu-title"><i class="ri-more-fill"></i> <span>@lang('translation.pages')</span></li>

            

                 <li class="nav-item">
    <a class="nav-link menu-link
        @if (request()->routeIs('categories.*') || request()->routeIs('tags.*'))
            active
        @endif"
        href="#sidebarMasters"
        data-bs-toggle="collapse"
        role="button"
        aria-expanded="
            {{ request()->routeIs('categories.*') || request()->routeIs('tags.*')  ? 'true' : 'false' }}"
        aria-controls="sidebarMasters">

        <i class="ri-dashboard-2-line"></i>
        <span>Masters</span>
    </a>

    <div class="collapse menu-dropdown 
        @if (request()->routeIs('categories.*') || request()->routeIs('tags.*'))
            show
        @endif"
        id="sidebarMasters">

        <ul class="nav nav-sm flex-column">

            <li class="nav-item">
                <a href="{{ route('categories.index') }}"
                   class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    Category
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('tags.index') }}"
                   class="nav-link {{ request()->routeIs('tags.*') ? 'active' : '' }}">
                    Tags
                </a>
            </li>

            <!-- <li class="nav-item">
                <a href="{{ route('documents.index') }}"
                   class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                    Documents
                </a>
            </li> -->

        </ul>



          <li class="nav-item">
                    <a href="{{ route('documents.index') }}"
                   class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                        <i class="ri-dashboard-2-line"></i> <span>Documents</span>
                    </a>
                  
                </li> <!-- end Dashboard Menu -->

    </div>
</li>


              
              

              

               


             

                    

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
