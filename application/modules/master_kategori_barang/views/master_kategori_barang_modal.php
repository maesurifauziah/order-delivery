<div class="modal fade text-xs" id="modal-form-master_kategori_barang" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-xs">
            <div class="modal-header">
                <h6 class="modal-title-form-master_kategori_barang">Form Merk</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('', array('id' => 'form-master_kategori_barang', 'role' => 'form')); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <input type="hidden" name="kategori_id" id="kategori_id" />
                        <div class="form-group">
                            <label for="kategori_desc">Tipe Kendaraan</label>
                            <input type="text" class="form-control text-xs" name="kategori_desc" id="kategori_desc" />
                            <span class="help-block-kategori_desc"></span>
                        </div> 
                        <div class="form-group">
                            <label for="urutan">Urutan</label>
                            <input type="text" class="form-control text-xs" name="urutan" id="urutan" />
                            <span class="help-block-urutan"></span>
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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->