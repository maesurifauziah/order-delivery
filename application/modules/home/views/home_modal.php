<div class="modal fade" id="modal-change-password">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('', array('id' => 'form-change-password', 'role' => 'form')); ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="userid" id="userid" value="<?php echo $this->session->userdata('userid');?>" />
                    <label for="password1">Password old</label>
                    <input type="password" class="form-control" name="password1" id="password1"
                        placeholder="Password old" required />
                </div>
                <div class="form-group">
                    <label for="password2">Password new</label>
                    <input type="password" class="form-control" name="password2" id="password2"
                        placeholder="Password new" required />
                </div>
                <div class="form-group">
                    <label for="password3">Retype password new</label>
                    <input type="password" class="form-control" name="password3" id="password3"
                        placeholder="Retype password new" required />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" onclick="savePassword()"
                    id="btnSavePass">Save</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->