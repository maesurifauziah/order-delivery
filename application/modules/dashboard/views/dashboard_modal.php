<div class="modal fade text-xs" id="modal-form-order" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php echo form_open('', array('id' => 'form-order', 'role' => 'form')); ?>
                    <input type="hidden" name="kode_barang" id="kode_barang" />
                    <input type="hidden" name="nama_barang" id="nama_barang" />
                    <input type="hidden" name="photo" id="photo" />
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-12 text-center photo-product">
                                </div>
                            </div>   
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <h5 id="label_nama_barang" style="color:black; font-weight: bold;"></h5>
                            </div>   
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <!-- <select class="form-control form-control-sm select2" name="satuan_jual" id="satuan_jual">
                                </select> -->
                                <input type="hidden" class="satuan_jual_id" name="satuan_jual_id" id="satuan_jual_id" >
                                <input type="hidden" class="harga_beli" name="harga_beli" id="harga_beli" >
                                <input type="hidden" class="harga_jual" name="harga_jual" id="harga_jual" >
                                <input type="hidden" class="harga_total" name="harga_total" id="harga_total" >
                                <input type="hidden" class="bonus" name="bonus" id="bonus" >
                                <span class="help-block-satuan_jual_id"></span>
                            </div>   
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-prepend">
                                        <button type="button" class="btn btn-secondary btn-flat quantity-left-minus"> - </button>
                                    </span>
                                    <input type="text" id="quantity" name="quantity" class="form-control input-number" value="0" min="0" max="100">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-secondary btn-flat quantity-right-plus"> + </button>
                                    </span>
                                </div>
                                <span class="help-block-quantity"></span>
                            </div>   
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea class="form-control form-control-sm text-xs" name="keterangan" id="keterangan" rows="2" placeholder="Keterangan" readonly></textarea>
                            </div>   
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group text-right">
                                <label id="label_total" style="color:black; font-weight: bold;">Rp. 0</label>
                            </div>   
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" onclick="save()" id="btnSaveApp"><i class="fas fa-cart-plus"></i> Tambah</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>