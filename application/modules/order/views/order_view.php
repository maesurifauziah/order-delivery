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
.active-filter {
    color: #fff !important;
    background-color: #dc3545;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper lyt-content">
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
      <div class="card card-solid">
        <div class="card-header d-flex p-0">
            <ul class="nav nav-pills p-2">
                <li class="nav-item mr-2">
                    <a href="#" onclick="cart()" class="btn btn-default btn-sm" id="cart">
                        <i class="fa fa-shopping-cart"></i> Keranjang 
                        <!-- <span class="badge badge-danger navbar-badge">3</span> -->
                        <span class="right badge badge-danger" id="length_list2"><?php echo $count_list_order; ?> </span>
                    </a> 
                    <a href="#" onclick="proses_order()" class="btn btn-default btn-sm" id="proses_order">
                        <i class="fa fa-list-alt"></i> Proses Order
                    </a> 
                    <a href="#" onclick="history_order()" class="btn btn-default btn-sm" id="history_order">
                        <i class="fa fa-list-alt"></i> Riwayat Order
                    </a> 
                    <input type="hidden" id="filter_kategori">
                </li>
            </ul>
        </div>
        <div class="content-wrapper" style="margin-left: 0rem; margin-top: 0rem;">
            <div class="card-body pb-0">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="search">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
                <div class="row" style="font-size: 13px; padding: 8px;">
                    <ul class="nav nav-pills nav-fill item-kategori">
                    </ul>
                </div>
                <div class="row d-flex align-items-stretch product" style="overflow-y: auto; max-height: 700px;">
                   
                </div>
            </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php $this->load->view('order_modal'); ?>
<?php $this->load->view('order_js'); ?>