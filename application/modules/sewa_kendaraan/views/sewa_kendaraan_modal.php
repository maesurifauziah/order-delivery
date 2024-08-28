<div class="modal fade text-xs" id="modal-form-sewa" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php echo form_open('', array('id' => 'form-sewa', 'role' => 'form')); ?>
                    <input type="hidden" name="kendaraan_id" id="kendaraan_id" />
                    <input type="hidden" name="nama_kendaraan" id="nama_kendaraan" />
                    <input type="hidden" name="harga_kendaraan" id="harga_kendaraan" />
                    <input type="hidden" name="photo" id="photo" />
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="col-12 text-center photo-kendaraan"></div>
                            </div>   
                            <div class="row">
                                <div class="col-12">
                                    <h5 id="label_nama_kendaraan" style="color:black; font-weight: bold;"></h5>
                                </div>
                                <div class="col-6">
                                    <ul class="list-group list-group-flush">
                                        <!-- <li class="list-group-item" style="bsewa: none;font-size: 12px;padding: 0.25rem;"><b>Tahun</b> <br><p id="label_tahun_kendaraan"></p> </li> -->
                                        <li class="list-group-item" style="bsewa: none;font-size: 12px;padding: 0.25rem;"><b>Merk</b> <br><p id="label_merk_kendaraan"></p></li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" style="bsewa: none;font-size: 12px;padding: 0.25rem;"><b>Kapasitas</b> <br><p id="label_kapasitas_kendaraan"> Siet</p></li>
                                        <!-- <li class="list-group-item" style="bsewa: none;font-size: 12px;padding: 0.25rem;"><b>No Polisi</b> <br><p id="label_no_polisi"></p></li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="label_tgl_pinjam" id="label_tgl_pinjam">Tanggal Pinjam</label>
                                <input type="date" class="form-control form-control-sm text-xs" name="tgl_pinjam" id="tgl_pinjam"  value="<?php echo date('Y-m-d')?>">
                                <span class="help-block-tgl_pinjam"></span>
                            </div>   
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="label_tgl_kembali" id="label_tgl_kembali">Tanggal Kembali</label>
                                <input type="date" class="form-control form-control-sm text-xs" name="tgl_kembali" id="tgl_kembali" >
                                <span class="help-block-tgl_kembali"></span>
                            </div>   
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" onclick="save()" id="btnSaveApp"><i class="fas fa-cart-plus"></i> Tambah</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-xs" id="modal-form-sewa_list" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" style="padding: 5px">
                <?php echo form_open('', array('id' => 'form-sewa_list', 'role' => 'form')); ?>
                <input type="hidden" name="jumlah_data" id="jumlah_data" value="" width="4" size="4" readonly>
                <span id="label_select_all"><input type="checkbox" name="select_all" id="select_all" value="n" /> Semua (<span id="length_list"></span>)</span>   
                <div class="table-responsive" style="padding-top: 10px; overflow-y: auto; max-height: 400px;">
                    <table id="table2" class="table table-sm" cellspacing="0"  width="100%">
                        <tbody id="item_detail"></tbody>
                    </table>
                </div>
                <div class="col-sm-12 p-2 border-bottom border-top">
                    <label class="text-sm" style="color:black; font-weight: bold; margin-bottom: 0rem;" id="label_total_pembayaran">TOTAL BAYAR</label> <br>
                    <input type="hidden" class="grand_total" name="grand_total" id="grand_total" value="0">
                    <input type="hidden" class="uang_muka" name="uang_muka" id="uang_muka" value="0">
                    <p class="text-sm" style="margin-bottom: 0.2rem;" class="grand_total2" id="grand_total2"></p>
                    <p class="text-sm" style="margin-bottom: 0.2rem;" class="uang_muka2" id="uang_muka2"></p>
                </div>
                <div class="col-sm-12 p-2">
                    <label for="bukti_pembayaran_uang_muka" id="label_bukti_pembayaran_uang_muka">Bukti Pembayaran</label>
                    <br>
                    <input type="file" name="bukti_pembayaran_uang_muka" id="bukti_pembayaran_uang_muka" />
                    <span class="help-block-bukti_pembayaran_uang_muka"></span>
                </div>
                <div class="col-sm-12 p-2">
                    <label for="titik_jemput" id="label_titik_jemput">Titik Jemput</label>
                    <br>
                    <textarea type="text" class="form-control form-control-sm text-xs" name="titik_jemput" id="titik_jemput" rows="2" />
                    <span class="help-block-titik_jemput"></span>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-success btn-xs" onclick="save()"><i class="fas fa-check"></i> Checkout</button>
                <button type="button" class="btn btn-xs" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-xs" id="modal-form-history_sewa" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title-form-history_sewa">Form Barang</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 5px">
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

<div class="modal fade text-xs" id="modal-form-bayar_lunas" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title-form-bayar_lunas">Form Barang</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('', array('id' => 'form-bayar_lunas', 'role' => 'form')); ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" name="sewa_id_pelunasan" id="sewa_id_pelunasan">
                            <label for="bukti_pembayaran_pelunasan" id="label_bukti_pembayaran_pelunasan">Bukti Pembayaran Lunas</label>
                            <br>
                            <input type="file" name="bukti_pembayaran_pelunasan" id="bukti_pembayaran_pelunasan" />
                            <span class="help-block-bukti_pembayaran_pelunasan"></span>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-xs" onclick="save()"><i class="fas fa-save"></i> Save</button>
                <button type="button" class="btn btn-xs" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>