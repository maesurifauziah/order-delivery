<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper lyt-content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <h6>Approve Sewa Kendaraan</h6>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <!-- Custom Tabs -->
                <div class="card p-3">
                    <div class="row">
                        <div class="col-sm-2 mb-2">
                            <div class="form-group">
                                <label for="filter_date_start">Date Start</label>
                                <input type="date" class="form-control form-control-sm text-xs" name="filter_date_start"
                                    id="filter_date_start" title="Date Start" value="<?php echo date('Y-m-01');?>" />
                            </div>
                        </div>
                        <div class="col-sm-2 mb-2">
                            <div class="form-group">
                                <label for="filter_date_end">Date End</label>
                                <input type="date" class="form-control form-control-sm text-xs" name="filter_date_end"
                                    id="filter_date_end" title="Date End" value="<?php echo date('Y-m-d');?>" />
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="filter_status_pembayaran">Status Sewa</label>
                                <select class="form-control form-control-sm text-xs" name="filter_status_pembayaran" id="filter_status_pembayaran" width="100%" title="Status Sewa">
                                    <option value="all" selected="">--ALL--</option>
                                    <option value="uang_muka">Uang Muka</option>
                                    <option value="pelunasan">Pelunasan</option>
                                    <option value="done">Selesai</option>
                                    <option value="cancel">Batal</option>
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
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table1" class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sewa ID / Tiket ID</th>
                                        <th>Customer</th>
                                        <th>Tanggal Checkout</th>
                                        <th>Uang Muka (30%)</th>
                                        <th>Bukti Uang Muka</th>
                                        <th>Grand Total</th>
                                        <th>Bukti Pelunasan</th>
                                        <th>Status Pembayaran</th>
                                        <th>Status Approve</th>
                                        <th>Approval</th>
                                        <th>Titik Jemput</th>
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

<?php $this->load->view('sewa_kendaraan_approver_modal'); ?>
<?php $this->load->view('sewa_kendaraan_approver_js'); ?>