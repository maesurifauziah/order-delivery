<div class="modal fade text-xs" id="modal-form-master_kendaraan" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title-form-master_kendaraan">Form Menu User</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('', array('id' => 'form-master_kendaraan', 'role' => 'form')); ?>
                    <input type="hidden" name="kendaraan_id" id="kendaraan_id" />
                    <input type="hidden" name="photo_name" id="photo_name" />
                    <input type="hidden" name="bensin_kendaraan" id="bensin_kendaraan" value="0"/>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group attachment">
                                <label for="photo" id="label_photo">Photo</label>
                                <br>
                                <input type="file" name="photo" id="photo" />
                                <span class="help-block-photo"></span>
                            </div>
                            <div class="form-group" id="photo-preview">
                                <div class="col-md-9">
                                    (No photo)
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                            </div>   
                            <div class="form-group">
                                <label for="nama_kendaraan">Nama Kendaraan</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="nama_kendaraan" id="nama_kendaraan" />
                                <span class="help-block-nama_kendaraan"></span>
                            </div>   
                            <div class="form-group">
                                <label for="merk_kendaraan">Merk Kendaraan</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="merk_kendaraan" id="merk_kendaraan" />
                                <span class="help-block-merk_kendaraan"></span>
                            </div>   
                            <div class="form-group">
                                <label for="deskripsi_kendaraan">Deskripsi Kendaraan</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="deskripsi_kendaraan" id="deskripsi_kendaraan" />
                                <span class="help-block-deskripsi_kendaraan"></span>
                            </div>   
                            <div class="form-group">
                                <label for="tahun_kendaraan">Tahun Kendaraan</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="tahun_kendaraan" id="tahun_kendaraan" />
                                <span class="help-block-tahun_kendaraan"></span>
                            </div>   
                            <div class="form-group">
                                <label for="kapasitas_kendaraan">Kapasitas Kendaraan</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="kapasitas_kendaraan" id="kapasitas_kendaraan" />
                                <span class="help-block-kapasitas_kendaraan"></span>
                            </div>   
                            <div class="form-group">
                                <label for="harga_kendaraan">Harga Sewa</label>
                                <input type="text" class="form-control form-control-sm text-xs number-separator" name="harga_kendaraan" id="harga_kendaraan" />
                                <span class="help-block-harga_kendaraan"></span>
                            </div>   
                            <div class="form-group">
                                <label for="warna_kendaraan">Warna</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="warna_kendaraan" id="warna_kendaraan" />
                                <span class="help-block-warna_kendaraan"></span>
                            </div>   
                            <div class="form-group">
                                <label for="no_polisi">Plat Nomer</label>
                                <input type="text" class="form-control form-control-sm text-xs" name="no_polisi" id="no_polisi" />
                                <span class="help-block-no_polisi"></span>
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

<div class="modal fade text-xs" id="modal-import-master_kendaraan">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h6 class="modal-title-import-master_kendaraan">Import Data</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <?php echo form_open('', array('id' => 'form-import-master_kendaraan', 'role' => 'form')); ?>
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

