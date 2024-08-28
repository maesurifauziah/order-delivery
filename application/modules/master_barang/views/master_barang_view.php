<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper lyt-content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <h6>Master Barang</h6>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <!-- Custom Tabs -->
                <div class="card">
                    <div class="row p-3">
                        <div class="col-sm-2 mb-2">
                            <div class="form-group">
                                <label for="filter_status">Status</label>
                                <select class="form-control text-xs select2" name="filter_status" id="filter_status"
                                    width="100%" title="Status">
                                    <option value="y">Active</option>
                                    <option value="n">Non Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2">
                            <div class="form-group">
                                <label for="filter_kategori_id">Kategori</label>
                                <select class="form-control text-xs select2" name="filter_kategori_id" id="filter_kategori_id" width="100%" title="Kategori">
                                    <option value="all" selected>All</option>
                                    <?php
                                        $data = '';
                                        foreach ($kategori as $list) {
                                            $data .='<option value="'.$list->kategori_id.'">'.$list->kategori_desc.'</option>';
                                        }
                                    echo $data;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2">
                            <div class="form-group">
                                <label for="filter">&nbsp;</label>
                                <a href="#" onclick="" class="btn btn-success btn-sm btn-block" id="filter"><i
                                        class="fa fa-search"></i>
                                    Filter</a>
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2">
                           <div class="form-group">
                               <label for="import">&nbsp;</label>
                               <div class="input-group-prepend">
                                   <button type="button" class="btn btn-default dropdown-toggle btn-block" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-file"></i> Action
                                   </button>
                                   <div class="dropdown-menu" style="">
                                       <a class="dropdown-item" href="javascript:void(0);" onclick="generate_template()">Generate Template</a>
                                       <a class="dropdown-item" href="javascript:void(0);" onclick="import_template()">Import Data</a>
                                   </div>
                               </div>
                           </div>
                       </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <ul class="nav nav-pills p-2">
                            <li class="nav-item mr-2">
                                <a href="#" onclick="add_form()" class="btn btn-primary btn-sm" id="add_app"><i
                                        class="fa fa-plus"></i>
                                    Add</a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="table1" class="table table-sm table-striped text-nowrap">
                                <thead>
                                    <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Kategori</th>
                                    <th>Photo</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Satuan</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.card-body -->
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

<?php $this->load->view('master_barang_modal'); ?>
<?php $this->load->view('master_barang_js'); ?>