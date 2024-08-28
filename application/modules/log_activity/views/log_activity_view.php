<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper lyt-content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <h6>Log Activity</h6>
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
                                        <th>Activity ID</th>
                                        <th>Datetime</th>
                                        <th>User ID</th>
                                        <th>User</th>
                                        <th>IP Address</th>
                                        <th>Modul</th>
                                        <th>Activity</th>
                                        <th>Description</th>
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

<?php $this->load->view('log_activity_modal'); ?>
<?php $this->load->view('log_activity_js'); ?>