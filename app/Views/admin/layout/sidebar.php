<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center " href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SMAP</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php if ($head == 'Dashboard') echo 'active'; ?>">
        <a class="nav-link" href="<?= base_url('Dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="">
            <i class=" fas fa-fw fa-globe"></i>
            <span>Visit Site</span></a>
    </li>

    <?php if (session()->get('role') == 3 or session()->get('role') == 1) : ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Administration
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item <?php if ($head == 'Pegawai') echo 'active'; ?>">
            <a class=" nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-id-card-alt"></i>
                <span>Pegawai</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('Jabatan'); ?>">Jabatan</a>
                    <a class="collapse-item" href="<?= base_url('Pegawai'); ?>">Daftar Pegawai</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-briefcase"></i>
                <span>Proyek</span></a>
        </li>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item <?php if ($head == 'Arsip Surat') echo 'active'; ?>">
            <a class=" nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSurat" aria-expanded="true" aria-controls="collapseSurat">
                <i class="fas fa-fw fa-file-word"></i>
                <span>Arsip Surat</span>
            </a>
            <div id="collapseSurat" class="collapse" aria-labelledby="headingSurat" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="<?= base_url('Jabatan'); ?>">Surat Masuk</a>
                    <a class="collapse-item" href="<?= base_url('Pegawai'); ?>">Surat Keluar</a>
                </div>
            </div>
        </li>
    <?php endif; ?>
    <?php if (session()->get('role') == 2 or session()->get('role') == 1) : ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Content Management
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-home"></i>
                <span>Home</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-video"></i>
                <span>Videos</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-paste"></i>
                <span>Portofolio</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-newspaper"></i>
                <span>News</span></a>
        </li>

    <?php endif; ?>
    <?php if (session()->get('role') == 1) : ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Web Configuration
        </div>

        <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Profiles</span></a>
        </li>

        <li class="nav-item <?php if ($head == 'User') echo 'active'; ?>"">
        <a class=" nav-link" href="<?= base_url('User'); ?>">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>User</span></a>
        </li>
    <?php endif; ?>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->