<style>
#wrapper {
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
  height: 60px;
  width: auto;
}
.block {
  flex: 1 0 50px;
  padding-bottom: 5px;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper lyt-content">
    <!-- Main content -->
    <section class="content">
        <div class="card card-danger">
            <div class="card-header">
                <div class="card-tools">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fa fa-ellipsis-v"></i>
                    </a>
                     <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <a href="#" class="dropdown-item text-dark" data-toggle="modal" data-target="#modal-change-password">
                            <i class="fas fa-edit mr-2"></i>Change Password
                        </a>
                        <!-- <div class="dropdown-divider"></div>
                        <a href="<?php echo base_url();?>login/lockscreen" class="dropdown-item text-dark">
                            <i class="fas fa-lock mr-2"></i> Lock Screen
                        </a> -->
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo base_url();?>login/logout" class="dropdown-item text-dark">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </div>
                <h5><?php echo $this->session->userdata('nama_lengkap');?></h5>
                <p style="margin-bottom: 0.3rem;"><?php echo $this->session->userdata('no_hp');?></p>
                <p style="margin-bottom: 0.3rem;"><?php echo $this->session->userdata('alamat');?></p>
            </div>
            <div class="card-body promo">
            </div>
        </div>
        <div class="content-wrapper" style="margin-left: 0rem; margin-top: 0rem;">
            <div class="card card-danger">
                <div class="card-header">
                    <h4>Hot Promo!! </h4>
                </div>
                <div class="card-body pb-0 h-100">
                    <div class="row d-flex align-items-stretch product" style="overflow-y: auto; max-height: 700px;">
                   
                   </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="main-footer text-sm">
        <div class="float-right d-none d-sm-block">
        <i class="fa fa-calendar"></i> &nbsp; <?php echo date('d M Y'); ?> <span id="time">7:17:33</span>&nbsp;
            <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2022 <a href="#">WBA On Mart Developer</a></strong>
    </footer>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $this->load->view('dashboard_js'); ?>
<?php $this->load->view('dashboard_modal'); ?>



