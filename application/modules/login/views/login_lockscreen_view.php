<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OD | Lockscreen</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
<div class="lockscreen-logo mb-0">
    <h3>ORDER DELIVERY (OD)</h3>
  </div>
  <?php if ($this->session->flashdata('msg')) {?>
        <div class="alert alert-<?php echo $this->session->flashdata('msg_status');?> alert-dismissible text-sm">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $this->session->flashdata('msg');?>
        </div>
        <?php };?>
  <!-- User name -->
  <div class="lockscreen-name"><?php echo $this->session->userdata('nama_lengkap');?></div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="<?php echo base_url();?>assets/dist/img/user1-128x128.jpg" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials" action="<?php echo base_url();?>login/authback" method="post">
      <div class="input-group">
      <input type="hidden" name="user_name" value="<?php echo $this->session->userdata('user_name');?>">
        <input type="password" class="form-control" placeholder="password">

        <div class="input-group-append">
          <button type="button" class="btn"><i class="fas fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="text-center">
            <a href="<?php echo base_url();?>login/backlogin"><i class="fas fa-arrow-left"></i> Back to Login</a>
        </div>
  <div class="lockscreen-footer text-center">
    Copyright &copy; 2022 <b><a href="#" class="text-black">ORDER DELIVERY (OD)</a></b><br>
    DEVELOPER
  </div>
</div>
<!-- /.center -->

<!-- jQuery -->
<script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
