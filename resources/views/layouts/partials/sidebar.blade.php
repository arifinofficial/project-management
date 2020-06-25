<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="javascript:void(0)">
                <img src="{{ asset('images/logo.png') }}" class="navbar-brand-img" alt="...">
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.html">
                            <i class="ni ni-tv-2 text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                </ul>
                <!-- Divider -->
                <hr class="my-2">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#collapseTask" role="button"
                            aria-expanded="false" aria-controls="collapseTask">
                            <i class="ni ni-archive-2 text-orange"></i>
                            <span class="nav-link-text">Data Pekerjaan</span>
                        </a>
                        <ul class="collapse" id="collapseTask">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('job.index') }}">
                                    Pekerjaan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('category.index') }}">
                                    Kategori
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user-management.index') }}">
                            <i class="ni ni-single-02 text-yellow"></i>
                            <span class="nav-link-text">Manajemen User</span>
                        </a>
                    </li>
                    @role('super admin')
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#collapseSetting" role="button"
                        aria-expanded="false" aria-controls="collapseSetting">
                            <i class="ni ni-settings-gear-65 text-default"></i>
                            <span class="nav-link-text">Konfigurasi</span>
                        </a>
                        <ul class="collapse" id="collapseSetting">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('role.index') }}">
                                    Role
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endrole
                </ul>
            </div>
        </div>
    </div>
</nav>