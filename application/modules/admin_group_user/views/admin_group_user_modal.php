<div class="modal fade text-xs" id="modal-form-admin_group_user" role="dialog">
    <div class="modal-dialog modal-xl" style="max-width: 95%; " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title-form-admin_group_user">Form Menu User</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('', array('id' => 'form-admin_group_user', 'role' => 'form')); ?>
                    <input type="hidden" name="user_group" id="user_group" />
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="group_name">Group Name</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="group_name" id="group_name" placeholder="Group Name" />
                                <span class="help-block-group_name"></span>
                            </div> 
                        </div>
                    </div>
                
                <input type="hidden" name="jumlah_data" id="jumlah_data" value="" width="4" size="4" readonly>
                <!-- <div class="table-responsive">
                    <table id="table1_user_group_add" class="table table-sm table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;" class="text-center">
                                    Pilih Menu<br>
                                    <button type="button" class="btn btn-xs bg-success check" id="checkall" onclick="checkAll()" ><i class="fas fa-check"></i></i></button>
                                    <button type="button" class="btn btn-xs bg-red check" id="uncheckall" onclick=" unCheckAll()" ><i class="fas fa-times"></i></i></button>
                                </th>
                                <th style="vertical-align: middle;" class="text-center" width="10%">Nama Aplikasi</th>
                                <th style="vertical-align: middle;" class="text-center" width="30%">Menu</th>
                                <th style="vertical-align: middle;" class="text-center" width="20%">Level</th>
                                <th style="vertical-align: middle;" class="text-center" width="30%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_user_group_add">
                        </tbody>
                    </table>
                </div> -->
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" onclick="save()" id="btnSaveApp">Save</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-xs" id="modal-form-admin_group_user_edit" role="dialog">
    <div class="modal-dialog modal-xl" style="max-width: 95%; " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title-form-admin_group_user_edit">Form Menu User</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('', array('id' => 'form-admin_group_user_edit', 'role' => 'form')); ?>
                    <input type="hidden" name="user_group_edit" id="user_group_edit" />
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="group_name_edit">Group Name</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="group_name_edit" id="group_name_edit" placeholder="Group Name" />
                                <span class="help-block-group_name_edit"></span>
                            </div> 
                        </div>
                    </div>
                
                <input type="hidden" name="jumlah_data_edit" id="jumlah_data_edit" value="" width="4" size="4" readonly>
                <!-- <div class="table-responsive">
                    <table id="table1_user_group_edit" class="table table-sm table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;" class="text-center" width="10%">
                                    Pilih Menu<br>
                                    <button type="button" class="btn btn-xs bg-success check" id="checkalledit" onclick="checkAllEdit()" ><i class="fas fa-check"></i></i></button>
                                        <button type="button" class="btn btn-xs bg-red check" id="uncheckalledit" onclick=" unCheckAllEdit()" ><i class="fas fa-times"></i></i></button>
                                </th>
                                <th style="vertical-align: middle;" class="text-center" width="10%">Nama Aplikasi</th>
                                <th style="vertical-align: middle;" class="text-center" width="30%">Menu</th>
                                <th style="vertical-align: middle;" class="text-center" width="20%">Level</th>
                                <th style="vertical-align: middle;" class="text-center" width="30%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_user_group_edit">
                        </tbody>
                    </table>
                </div> -->
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" onclick="save()" id="btnSaveApp">Save</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade text-xs" id="modal-form-admin_group_user_view" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title-form-admin_group_user_view">Form Menu User</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('', array('id' => 'form-admin_group_user_view', 'role' => 'form')); ?>
                    <input type="hidden" name="user_group_view" id="user_group_view" />
                    <div class="row">
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="group_name_view">Group Name</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="group_name_view" id="group_name_view" placeholder="Title" />
                                <span class="help-block-group_name_view"></span>
                            </div>  
                        </div>
                    </div>
                <?php echo form_close(); ?>
                <!-- <div class="table-responsive">
                    <table id="table1_user_group_view" class="table table-sm table-striped text-nowrap">
                        <thead>
                            <tr>
                                <th>Default</th>
                                <th>Application</th>
                                <th>Level</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_user_group_view">
                        </tbody>
                    </table>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>



