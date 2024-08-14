<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="d-flex justify-content-lg-center p-4">
            <!-- Logo -->
            <div>
                <img src="/images/logo.png" width="140px">
            </div>
            <!-- END Logo -->
        </div>
        <!-- END Side Header -->

        <!-- Sidebar Scrolling -->
        <div class="js-sidebar-scroll">
            <!-- Side Navigation -->
            <div class="content-side content-side-full">
                <ul class="nav-main">
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('admin/beranda') ? ' active' : '' }}" href="{{ route('admin.beranda') }}">
                            <i class="nav-main-link-icon fa fa-house-user"></i>
                            <span class="nav-main-link-name">Beranda</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('admin/mahasiswa') ? ' active' : '' }}" href="{{ route('admin.user.index') }}">
                            <i class="nav-main-link-icon fa fa-users"></i>
                            <span class="nav-main-link-name">Mahasiswa</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('admin/program') ? ' active' : '' }}" href="{{ route('admin.program.index') }}">
                            <i class="nav-main-link-icon fa fa-book"></i>
                            <span class="nav-main-link-name">Program</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('admin/matkul') ? ' active' : '' }}" href="{{ route('admin.matkul.index') }}">
                            <i class="nav-main-link-icon fa fa-book"></i>
                            <span class="nav-main-link-name">Mata Kuliah</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('admin/kategori') ? ' active' : '' }}" href="{{ route('admin.kategori.index') }}">
                            <i class="nav-main-link-icon fa fa-archive"></i>
                            <span class="nav-main-link-name">Kategori</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('admin/pendaftaran') ? ' active' : '' }}" href="{{ route('admin.register.index') }}">
                            <i class="nav-main-link-icon fa fa-wallet"></i>
                            <span class="nav-main-link-name">Pendaftaran</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('admin/konversi') ? ' active' : '' }}" href="{{ route('admin.konversi.index') }}">
                            <i class="nav-main-link-icon fa fa-wallet"></i>
                            <span class="nav-main-link-name">Konversi</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- END Side Navigation -->
        </div>
        <!-- END Sidebar Scrolling -->
    </div>
    <!-- Sidebar Content -->
</nav>