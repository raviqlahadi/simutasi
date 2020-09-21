<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <div class="c-sidebar-brand-full">
            <h3>SI<span style="font-weight: 100;">TAMPAN</span></h3>
        </div>
        <div class="c-sidebar-brand-minimized">
            <h3>S</h3>
        </div>

    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-title">Menu</li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="<?php echo base_url('dashboard') ?>">
                <i class="fa fa-home c-sidebar-nav-icon"></i> Dashboard
            </a>
        </li>

        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="<?php echo base_url('asset') ?>">
                <i class="fa fa-archive c-sidebar-nav-icon"></i> Aset BMD
            </a>
        </li>
        <?php if ($this->session->level == 1) { ?>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="<?php echo base_url('agency') ?>">
                    <i class="fa fa-landmark c-sidebar-nav-icon"></i> Instansi
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="<?php echo base_url('officer') ?>">
                    <i class="fa fa-id-badge c-sidebar-nav-icon"></i> ASN
                </a>
            </li>
        <?php } else { ?>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="<?php echo base_url('asset/deletion') ?>">
                    <i class="fa fa-trash c-sidebar-nav-icon"></i> Pemusnahan Aset
                </a>
            </li>
        <?php } ?>
     
        <?php if ($this->session->level == 1) { ?>
            <li class="c-sidebar-nav-title">Setting</li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="<?php echo base_url('user') ?>">
                    <i class="fa fa-user c-sidebar-nav-icon"></i> User
                </a>
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="<?php echo base_url('group') ?>">
                    <i class="fa fa-users c-sidebar-nav-icon"></i> Group User
                </a>
            </li>
        <?PHP } ?>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>