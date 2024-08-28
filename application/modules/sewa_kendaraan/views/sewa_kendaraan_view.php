<style>
.notify-badge{
    background: rgb(220, 53, 69);
    height: 2rem;
    top: 2rem;
    left: 1.5rem;
    width: auto;
    text-align: center;
    line-height: 2rem;
    font-size: 1rem;
    color: white;
}
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
        <div class="row">
            <div class="col-12">
                <!-- Custom Tabs -->
                <!-- <div class="card">
                    <div class="row p-3">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <select class="form-control text-xs select2" name="filter_tipe_kendaraan" id="filter_tipe_kendaraan" width="100%">
                                    <option value="all" selected="">--ALL--</option>
                                    <?php
                                        $data = '';
                                        foreach ($tipe_kendaraan as $list) {
                                            $data .='<option value="'.$list->tipe_id.'">'.$list->tipe_desc.'</option>';
                                        }
                                    echo $data;?>
                                </select>

                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                
                                <a href="#" onclick="" class="btn btn-success btn-sm btn-block" id="filter"><i
                                        class="fa fa-filter"></i>
                                    Filter</a>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="card">
                    <input type="hidden" name="filter_tipe_kendaraan" name="filter_tipe_kendaraan">
                    <div class="card-header d-flex p-0">
                            <ul class="nav nav-pills p-2">
                                <li class="nav-item mr-2">
                                    <a href="#" onclick="cart()" class="btn btn-default btn-sm" id="cart">
                                        <i class="fa fa-shopping-cart"></i> Keranjang 
                                        <span class="right badge badge-danger" id="length_list2"><?php echo $count_list_sewa; ?> </span>
                                        <!-- <span class="right badge badge-danger" id="length_list2"> </span> -->
                                    </a> 
                                    <a href="#" onclick="history_sewa()" class="btn btn-default btn-sm" id="history_sewa">
                                        <i class="fa fa-list-alt"></i> Riwayat Sewa
                                    </a> 
                                </li>
                            </ul>
                        </div>
                    <div class="card-body pb-0">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-sm" id="search">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                        <div class="row d-flex align-items-stretch kendaraan" style="overflow-y: auto; max-height: 700px;">
                        
                        </div>
                    </div>
                </div>
                <!-- ./card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php $this->load->view('sewa_kendaraan_modal'); ?>
<?php $this->load->view('sewa_kendaraan_js'); ?>