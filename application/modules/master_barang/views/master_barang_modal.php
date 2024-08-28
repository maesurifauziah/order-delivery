<div class="modal fade text-xs" id="modal-form-master_barang" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title-form-master_barang">Form Menu User</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('', array('id' => 'form-master_barang', 'role' => 'form')); ?>
                    <input type="hidden" name="kode_barang" id="kode_barang" />
                    <input type="hidden" name="photo_name" id="photo_name" />

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="nama_barang" id="nama_barang" />
                                <span class="help-block-nama_barang"></span>
                            </div>   
                            <div class="form-group">
                                <label for="kategori_id">Kategori</label>
                                <select class="form-control form-control-sm text-xs" name="kategori_id" id="kategori_id" width="100%"title="Kategori"> 
                                    <option value="" selected>--Pilih Group User--</option>
                                    <?php
                                        $data = '';
                                        foreach ($kategori as $list) {
                                            $data .='<option value="'.$list->kategori_id.'">'.$list->kategori_desc.'</option>';
                                        }
                                    echo $data;?>
                                </select>
                                <span class="help-block-kategori_id"></span>
                            </div> 
                            <div class="col-sm-6">
                                <div class="form-group attachment">
                                    <label for="photo" id="label_photo">Photo</label>
                                    <br>
                                    <input type="file" name="photo" id="photo" />
                                   
                                    <span class="help-block-photo"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" id="photo-preview">
                                    <div class="col-md-9">
                                        (No photo)
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="harga_beli">Harga Beli</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="harga_beli" id="harga_beli" />
                                <span class="help-block-harga_beli"></span>
                            </div>   
                            <div class="form-group">
                                <label for="harga_jual">Harga Jual</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="harga_jual" id="harga_jual" />
                                <span class="help-block-harga_jual"></span>
                            </div>   
                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="satuan" id="satuan" />
                                <span class="help-block-sat"></span>
                            </div>   
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="keterangan" id="keterangan">            
                                <span class="help-block-keterangan"></span>
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

<div class="modal fade text-xs" id="modal-import-master_barang">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h6 class="modal-title-import-master_barang">Import Data</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo form_open('', array('id' => 'form-import-master_barang', 'role' => 'form')); ?>
                    <input type="file" name="file_excel" id="file_excel" />
                    <?php echo form_close(); ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" onclick="importUpload()"
                    id="btnImport">Import</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>




