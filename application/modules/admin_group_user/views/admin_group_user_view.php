<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper lyt-content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <h6>Group User Application</h6>
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
                                <label for="filter">&nbsp;</label>
                                <a href="#" onclick="" class="btn btn-success btn-sm btn-block" id="filter"><i
                                        class="fa fa-search"></i>
                                    Filter</a>
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
                                    <th>Group User ID</th>
                                    <th>Group User Name</th>
                                    <th>Active</th>
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

<?php $this->load->view('admin_group_user_modal'); ?>
<?php $this->load->view('admin_group_user_js'); ?>