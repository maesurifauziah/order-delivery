<div class="modal fade text-xs" id="modal-form-admin_user_apps" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title-form-admin_user_apps">Form Menu User</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('', array('id' => 'form-admin_user_apps', 'role' => 'form')); ?>
                    <input type="hidden" name="userid" id="userid" />
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="nama_lengkap">Nama</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="nama_lengkap" id="nama_lengkap" />
                                <span class="help-block-nama_lengkap"></span>
                            </div>   
                            <div class="form-group">
                                <label for="user_name">User Name</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="user_name" id="user_name" />
                                <span class="help-block-user_name"></span>
                            </div>   
                            <div class="form-group password">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm text-xs" name="password" id="password"/>
                                <span class="help-block-password"></span>
                            </div> 
                            <div class="form-group confirm_password">
                                <label for="confirm_password">Ulang Password</label>
                                <input type="password" class="form-control form-control-sm text-xs" name="confirm_password" id="confirm_password"/>
                                <span class="help-block-confirm_password"></span>
                            </div> 
                            <div class="form-group">
                                <label for="user_group">Group User</label>
                                <select class="form-control form-control-sm text-xs" name="user_group" id="user_group" width="100%"title="Group User"> 
                                    <option value="">--Pilih Group User--</option>
                                    <?php
                                        $data = '';
                                        foreach ($group_user as $list) {
                                            $data .='<option value="'.$list->user_group.'">'.$list->group_name.'</option>';
                                        }
                                    echo $data;?>
                                </select>
                                <span class="help-block-user_group"></span>
                            </div>  
                            <div class="form-group">
                                <label for="daerah">Daerah</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="daerah" id="daerah" />
                                <span class="help-block-daerah"></span>
                            </div> 
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea type="text" class="form-control form-control-sm text-xs" name="alamat" id="alamat" rows="2" />
                                <span class="help-block-alamat"></span>
                            </div>    
                            <div class="form-group">
                                <label for="no_hp">No Hp</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="no_hp" id="no_hp" />
                                <span class="help-block-no_hp"></span>
                            </div>   
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" onclick="save()" id="btnSaveApp">Save</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        
    </div>
    
</div>



