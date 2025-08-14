<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=route('dashboard')?>" class="brand-link">
        <img src="<?=assets('images/logo.svg')?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width: 40px;background-color: white;">
        <span class="brand-text font-weight-light">Profolio</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image d-flex">
                <img src="<?=assets(setting('image'),'images/default-150x150.png')?>" class="user-image img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?=setting('name')?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="<?= __("search") ?>" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'dashboard' ? 'active' : ''; ?>" href="/admin/dashboard">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            <?= __("dashboard") ?>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'projects' ? 'active' : ''; ?>" href="/admin/projects">
                        <i class="nav-icon fas fa-project-diagram"></i>
                        <p>
                            <?= __("projects") ?>
<!--                            <span class="right badge badge-danger">New</span>-->
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'skills' ? 'active' : ''; ?>" href="/admin/skills">
                        <i class="nav-icon fas fa-code"></i>
                        <p>
                            <?= __("skills") ?>
<!--                            <span class="right badge badge-danger">New</span>-->
                        </p>
                    </a>
                </li>
                <li class="nav-header"><div class="border-top"></div></li>

                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'profile' ? 'active' : ''; ?>" href="/admin/profile">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            <?= __("profile") ?>
                            <!--                            <span class="right badge badge-danger">New</span>-->
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'setting' ? 'active' : ''; ?>" href="<?=route('admin.settings')?>">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            <?= __("setting") ?>
                            <!--                            <span class="right badge badge-danger">New</span>-->
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'logout' ? 'active' : ''; ?>" href="/logout">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            <?= __("logout") ?>
                            <!--                            <span class="right badge badge-danger">New</span>-->
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>