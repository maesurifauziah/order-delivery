
<footer class=" text-sm" style="position: fixed;right: 0;bottom: 0;left: 0;z-index: 9999;">
    <nav class="navbar navbar-light bg-light border-top navbar-expand d-md-none d-lg-none d-xl-none fixed-bottom">
        <ul class="navbar-nav nav-justified w-100">
            <li class="nav-item">
                <a href="<?php echo base_url();?>" class="nav-link">
                    <i class="nav-icon fas fa-home" style="font-size: 1.3rem;"></i>
                    <span class="small d-block">Home</span>
                </a>
            </li>
            <?php if ($this->session->userdata('user_group') == '0001') {?>
            <li class="nav-item dropup">
                <a href="#" class="nav-link text-center" role="button" id="dropdownMenuAdmin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                    <i class="nav-icon fas fa-cog" style="font-size: 1.3rem;"></i>
                    <span class="small d-block">Admin</span>
                </a>
                <!-- Dropup menu for profile -->
                <div class="dropdown-menu" aria-labelledby="dropdownMenuAdmin">
                    <label class="dropdown-item" style="padding-top: 0.1rem;">Admin</label>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#admin_group_user" onClick="loadPage('admin_group_user')">Group User</a>
                    <a class="dropdown-item" href="#admin_user_apps" onClick="loadPage('admin_user_apps')">User</a>
                </div>
            </li>
            <?php };?>
            <?php if ($this->session->userdata('user_group') != '0004') {?>
                <!-- <li class="nav-item">
                    <a href="#order" class="nav-link" onClick="loadPage('order')">
                        <i class="nav-icon fas fa-shopping-cart" style="font-size: 1.3rem;"></i>
                    </a>
                </li> -->
                <li class="nav-item dropup">
                    <a href="#" class="nav-link text-center" role="button" id="dropdownMenuOrder" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        <i class="nav-icon fas fa-shopping-cart" style="font-size: 1.3rem;"></i>
                        <span class="small d-block">Order</span>
                    </a>
                    <!-- Dropup menu for profile -->
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOrder">
                        <label class="dropdown-item" style="padding-top: 0.1rem;">Order</label>
                        <div class="dropdown-divider"></div>
                        <?php if ($this->session->userdata('user_group') == '0001') {?>
                            <a href="#master_barang" class="nav-link" onClick="loadPage('master_barang')">Master Barang</a>
                            <a href="#master_kategori_barang" class="nav-link" onClick="loadPage('master_kategori_barang')">Master Kategori Barang</a>
                        <?php };?>
                        <?php if ($this->session->userdata('user_group') == '0001' || $this->session->userdata('user_group') == '0002') {?>
                            <a href="#order" class="nav-link" onClick="loadPage('order')">Order</a>
                        <?php };?>
                        <?php if ($this->session->userdata('user_group') == '0001' || $this->session->userdata('user_group') == '0003') {?>
                                <a href="#order_kurir" class="nav-link" onClick="loadPage('order_kurir')">Order (Kurir)</a>
                        <?php };?>
                    </div>
                </li>
            <?php };?>
            <?php if ($this->session->userdata('user_group') != '0003') {?>
                <!-- <li class="nav-item">
                    <a href="#sewa_kendaraan" class="nav-link" onClick="loadPage('sewa_kendaraan')">
                        <i class="nav-icon fas fa-car" style="font-size: 1.3rem;"></i>
                    </a>
                </li> -->
                <li class="nav-item dropup">
                    <a href="#" class="nav-link text-center" role="button" id="dropdownMenuSewa" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        <i class="nav-icon fas fa-car" style="font-size: 1.3rem;"></i>
                        <span class="small d-block">Sewa</span>
                    </a>
                    <!-- Dropup menu for profile -->
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSewa">
                        <label class="dropdown-item" style="padding-top: 0.1rem;">Sewa</label>
                        <div class="dropdown-divider"></div>
                        <?php if ($this->session->userdata('user_group') == '0001') {?>
                            <a href="#master_kendaraan" class="nav-link" onClick="loadPage('master_kendaraan')">Master Kendaraan</a>
                        <?php };?>
                        <?php if ($this->session->userdata('user_group') == '0001' || $this->session->userdata('user_group') == '0002') {?>
                            <a href="#sewa_kendaraan" class="nav-link" onClick="loadPage('sewa_kendaraan')">Sewa Kendaraan</a>
                        <?php };?>
                        <?php if ($this->session->userdata('user_group') == '0001' || $this->session->userdata('user_group') == '0004') {?>
                                <a href="#sewa_kendaraan_approver" class="nav-link" onClick="loadPage('sewa_kendaraan_approver')">Sewa Kendaraan (Approver)</a>
                        <?php };?>
                    </div>
                </li>
            <?php };?>
            <?php if ($this->session->userdata('user_group') == '0001') {?>
            <li class="nav-item">
                <a href="#log_activity" class="nav-link" onClick="loadPage('log_activity')">
                    <i class="nav-icon fas fa-tachometer-alt" style="font-size: 1.3rem;"></i>
                    <span class="small d-block">Log</span>
                </a>
            </li>
            <?php };?>
        </ul>
    </nav>
</footer>
<!-- <footer class="main-footer text-sm">
    <div class="float-right d-none d-sm-block">
    <i class="fa fa-calendar"></i> &nbsp; <?php echo date('d M Y'); ?> <span id="time">7:17:33</span>&nbsp;
        <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2022 <a href="#">WBA On Mart Developer</a></strong>
</footer> -->