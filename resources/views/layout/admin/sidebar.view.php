<?php
$current_page = basename($_SERVER['PHP_SELF']);
//dd([request()->path(),$current_page]);
?>

<style>
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        padding: 1rem;
        padding-top: 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        background: #343a40;
        transition: all 0.3s;
    }

    .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: 0.5rem;
        overflow-x: hidden;
        overflow-y: auto;
    }

    .sidebar .nav-link {
        font-weight: 500;
        color: #ffffff;
        padding: 1rem 1.5rem;
        transition: all 0.3s;
    }

    .sidebar .nav-link:hover {
        background: #2c3136;
        color: #fff;
        padding-left: 1.75rem;
    }

    .sidebar .nav-link.active {
        background: #0d6efd;
        color: #fff;
    }

    .sidebar .nav-link i {
        margin-right: 0.5rem;
        width: 20px;
        text-align: center;
    }

    .sidebar-heading {
        font-size: .75rem;
        text-transform: uppercase;
        color: #ffffff80;
        padding: 1rem 1.5rem;
        margin-bottom: 0;
    }

    .sidebar-logo {

        text-align: center;
    }

    .sidebar-logo img {
        max-width: 50px;
        height: auto;
    }

    .sidebar-divider {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin: 1rem 0;
    }
</style>

<nav class="col-md-3 col-lg-2 d-md-block sidebar">
    <div class="sidebar-sticky">
        <div class="sidebar-logo">
            <img src="../assets/images/logo.png" alt="Logo">
        </div>

        <div class="sidebar-divider"></div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'dashboard' ? 'active' : ''; ?>" href="/admin/dashboard">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center <?php echo ($current_page == 'projects' || $current_page == 'add-project') ? 'active' : ''; ?>"
                   data-bs-toggle="collapse"
                   href="#projectsCollapse"
                   role="button"
                   aria-expanded="<?php echo ($current_page == 'projects' || $current_page == 'add-project') ? 'true' : 'false'; ?>"
                   aria-controls="projectsCollapse">
                    <span>
                        <i class="fas fa-project-diagram"></i>
                        Projects
                    </span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse <?php echo ($current_page == 'projects') ? 'show' : ''; ?>" id="projectsCollapse">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'projects' ? 'active2' : ''; ?>" href="/admin/projects">
                                <i class="fas fa-project-diagram"></i>
                                All Projects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'add-project' ? 'active' : ''; ?>" href="/admin/add-project">
                                <i class="fas fa-plus-circle"></i>
                                Add Project
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
 
            <div class="sidebar-divider"></div>

            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'profile' ? 'active' : ''; ?>" href="/admin/profile">
                    <i class="fas fa-user"></i>
                    Profile
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'settings' ? 'active' : ''; ?>" href="/admin/settings">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
            </li>

            <div class="sidebar-divider"></div>

            <li class="nav-item">
                <a class="nav-link" href="admin/logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</nav>