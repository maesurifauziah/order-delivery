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
                                <input type="hidden" class="bonus2" name="bonus2" id="bonus2" >
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

<div class="modal fade text-xs" id="modal-form-order_list" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" style="padding: 5px">
                <?php echo form_open('', array('id' => 'form-order_list', 'role' => 'form')); ?>
                    <input type="hidden" name="jumlah_data" id="jumlah_data" value="" width="4" size="4" readonly>
                    <span id="label_select_all"><input type="checkbox" name="select_all" id="select_all" value="n" /> Semua (<span id="length_list"></span>)</span>   
                    <div class="table-responsive" style="padding-top: 10px; overflow-y: auto; max-height: 400px;">
                        <table id="table2" class="table table-sm" cellspacing="0"  width="100%">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle;" class="text-left" colspan="4">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="item_detail"></tbody>
                        </table>
                    </div>
                    
                    <div class="col-sm-12 p-1">
                        <label for="tipe_pembayaran" id="label_tipe_pembayaran">Tipe Pembayaran</label>
                        <div class="row">
                            <input type="hidden" name="tipe_pembayaran_select" id="tipe_pembayaran_select" value="C">
                            <div class="col-sm-2">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="tipe_pembayaran2" name="tipe_pembayaran" value="C" checked onchange="getValue(this)">
                                    <label for="tipe_pembayaran2" class="custom-control-label">COD</label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="tipe_pembayaran1" name="tipe_pembayaran" value="T" onchange="getValue(this)">
                                    <label for="tipe_pembayaran1" class="custom-control-label">Transfer</label>
                                </div>
                            </div>
                        </div>
                        <span class="help-block-tipe_pembayaran"></span>
                    </div>
                    <div class="col-sm-12 p-1 bukti_pembayaran">
                        <label for="bukti_pembayaran" id="label_bukti_pembayaran">Bukti Pembayaran</label>
                        <br>
                        <!-- <input type="text" value="6765040004" id="norek"> -->
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" /><br>
                        <span class="text-info">BCA - <span id="norek">6765040004</span> <a href="javascript:void(0);" class="btn-secondary btn-xs" onclick="copy_norek('#norek')"><i class="fas fa-copy"></i></a><br>Atn. Agi Mulyadi</span>
                        <br>
                        <span class="help-block-bukti_pembayaran"></span>
                    </div>
                    <div class="col-sm-6 p-1 total_belanja">
                        <label for="total_belanja" id="label_total_belanja">Total Belanja</label>
                        
                        <input type="hidden" class="form-control form-control-sm text-xs" name="total_belanja" id="total_belanja" />
                        <span class="help-block-total_belanja"></span>
                    </div>
                    <div class="col-sm-6 p-1 ongkir">
                        <label for="ongkir" id="label_ongkir">Ongkir</label><br>                        
                        <input type="hidden" class="form-control form-control-sm text-xs" name="ongkir" id="ongkir" />
                        <span class="text-info">min. Belanja 300 ribu gratis ongkir</span><br>
                        <span class="help-block-ongkir"></span>
                    </div>
                    <div class="col-sm-6 p-1 bonus">
                        <label for="bonus" id="label_bonus">Diskon</label>
                        
                        <input type="hidden" class="form-control form-control-sm text-xs" name="bonus" id="bonus" />
                        <span class="help-block-bonus"></span>
                    </div>
                    <div class="col-sm-6 p-1 biaya_penanganan">
                        <label for="biaya_penanganan" id="label_biaya_penanganan">Biaya Penanganan</label>
                        
                        <input type="hidden" class="form-control form-control-sm text-xs" name="biaya_penanganan" id="biaya_penanganan" />
                        <span class="help-block-biaya_penanganan"></span>
                    </div>
                    <div class="col-sm-12 p-1">
                        <label for="alamat_kirim" id="label_alamat_kirim">Alamat Kirim</label>
                        <br>
                        <textarea type="text" class="form-control form-control-sm text-xs" name="alamat_kirim" id="alamat_kirim" rows="2" />
                        <span class="help-block-alamat_kirim"></span>
                    </div>
                    <input type="hidden" class="grand_total" name="grand_total" id="grand_total" value="0">
                    <?php echo form_close(); ?>
                </div>
                <div class="modal-footer">
                <label class="grand_total2" id="grand_total2" style="color:black; font-weight: bold;"></label>
                <button type="button" class="btn btn-success btn-xs" onclick="save()"><i class="fas fa-check"></i> Checkout</button>
                <button type="button" class="btn btn-xs" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-xs" id="modal-form-proses_order" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title-form-proses_order">Form Barang</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px; overflow-y: auto; max-height: 400px;">
                <div id="accordion">
                    <div class="card" id="item-list">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-xs" id="modal-form-history_order" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title-form-history_order">Form Barang</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px; overflow-y: auto; max-height: 400px;">
                <div id="accordion">
                    <div class="card" id="item-list-history">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



