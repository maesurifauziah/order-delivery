<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-danger">
    <!-- Brand Logo -->
    <a href="<?php echo base_url();?>" class="brand-link navbar-danger">
    <!-- <a href="<?php echo base_url();?>" class="brand-link"> -->
      <img src="<?php echo base_url(); ?>assets/dist/img/logo-login.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light text-light">WBA V1.0</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
         <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-4 pb-3 mb-3 d-flex">
            <div class="image">
            <img src="<?php echo base_url(); ?>assets/dist/img/account-user-circle.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $this->session->userdata('nama_lengkap');?></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <?php if ($this->session->userdata('user_group') == '0001') {?>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Admin
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    User
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#admin_group_user" class="nav-link" onClick="loadPage('admin_group_user')">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Group User</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#admin_user_apps" class="nav-link" onClick="loadPage('admin_user_apps')">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>User</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <?php };?>
                <?php if ($this->session->userdata('user_group') != '0004') {?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Order
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if ($this->session->userdata('user_group') == '0001') {?>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Master
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#master_barang" class="nav-link" onClick="loadPage('master_barang')">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Master Barang</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#master_kategori_barang" class="nav-link" onClick="loadPage('master_kategori_barang')">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Master Kategori Barang</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php };?>
                        <?php if ($this->session->userdata('user_group') == '0001' || $this->session->userdata('user_group') == '0002') {?>
                        <li class="nav-item">
                            <a href="#order" class="nav-link" onClick="loadPage('order')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Order</p>
                            </a>
                        </li>
                        <?php };?>
                        <?php if ($this->session->userdata('user_group') == '0001' || $this->session->userdata('user_group') == '0003') {?>
                        <li class="nav-item">
                            <a href="#order_kurir" class="nav-link" onClick="loadPage('order_kurir')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Order (Kurir)</p>
                            </a>
                        </li>
                        <?php };?>
                    </ul>
                </li>
                <?php };?>
                <?php if ($this->session->userdata('user_group') != '0003') {?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-car"></i>
                        <p>
                            Sewa
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if ($this->session->userdata('user_group') == '0001') {?>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Master
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <!-- <li class="nav-item">
                                    <a href="#master_tipe_kendaraan" class="nav-link" onClick="loadPage('master_tipe_kendaraan')">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Master Tipe Kendaraan</p>
                                    </a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="#master_kendaraan" class="nav-link" onClick="loadPage('master_kendaraan')">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Master Kendaraan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php };?>
                        <?php if ($this->session->userdata('user_group') == '0001' || $this->session->userdata('user_group') == '0002') {?>
                        <li class="nav-item">
                            <a href="#sewa_kendaraan" class="nav-link" onClick="loadPage('sewa_kendaraan')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sewa Kendaraan</p>
                            </a>
                        </li>
                        <?php };?>
                        <?php if ($this->session->userdata('user_group') == '0001' || $this->session->userdata('user_group') == '0004') {?>
                        <li class="nav-item">
                            <a href="#sewa_kendaraan_approver" class="nav-link" onClick="loadPage('sewa_kendaraan_approver')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sewa Kendaraan (Approver)</p>
                            </a>
                        </li>
                        <?php };?>
                    </ul>
                </li>
                <?php };?>
                <?php if ($this->session->userdata('user_group') == '0001') {?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Log
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                        <a href="#log_activity" class="nav-link" onClick="loadPage('log_activity')">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Log Avtivity</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php };?>
            
            </ul>
        </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>