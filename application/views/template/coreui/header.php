<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <i class="fa fa-bars"></i>
    </button>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="c-header-nav d-md-down-none">
        <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="<?php echo site_url('/profile') ?>">Profile</a></li>
        <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="<?php echo site_url('/setting') ?>">Settings</a></li>
    </ul>
    <ul class="c-header-nav ml-auto mr-4">
        <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class=""><?php echo ucwords($this->session->username) ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-2">
                <a class="dropdown-item" href="<?php echo site_url('auth/logout') ?>">
                    <i class="fa fa-sign-out-alt c-icon mr-2"></i> Logout
                </a>
            </div>
        </li>
    </ul>
    <!-- Breadcrumb-->
    <?php
    if (isset($breadcrumbs)) {
        echo '
                 <div class="c-subheader px-3">
                    ' . $breadcrumbs . '
                </div>
            ';
    }
    ?>
    <!-- Breadcrumb Menu-->
</header>