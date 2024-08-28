<div class="modal fade text-xs" id="modal-form-sewa_kendaraan_approver" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title-form-sewa_kendaraan_approver">Form Menu User</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="sewa_id" id="sewa_id">
                <div class="table-responsive" style="padding-top: 10px">
                    <table id="table2_view" class="table table-sm" width="100%">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;" class="text-center">No</th>
                                <th style="vertical-align: middle;" class="text-left">Nama Kendaraan</th>
                                <th style="vertical-align: middle;" class="text-center">Tipe Kendaraan</th>
                                <th style="vertical-align: middle;" class="text-center">Tanggal Pinjam</th>
                                <th style="vertical-align: middle;" class="text-center">Lama Pinjam</th>
                                <th style="vertical-align: middle;" class="text-center">Harga Per Hari</th>
                                <th style="vertical-align: middle;" class="text-center">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody id="item_detail2">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center" style="vertical-align: middle;"><label for="">TOTAL</label></td>
                                <td class="text-right" style="vertical-align: middle;">
                                    <!-- <input type="text" name="total2" id="total2" class="form-control form-control-sm text-xs text-right kanan" readonly> -->
                                    <label><span id="total2"></span></label>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade text-xs" id="modal-form-approve_pelunasan">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h6 class="modal-title-form-approve_pelunasan"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('', array('id' => 'form-approve_pelunasan', 'role' => 'form')); ?>
                <div class="form-group">
                    <label for="label_plat_nomer">Plat Nomer</label>
                    <input type="hidden" name="sewa_id_lns" id="sewa_id_lns" />
                    <input type="text" class="form-control text-xs" name="plat_nomer" id="plat_nomer"/>
                    <span class="help-block-plat_nomer"></span>
                </div>
                <div class="form-group">
                    <label for="label_nama_supir">Nama Supir</label>
                    <input type="text" class="form-control text-xs" name="nama_supir" id="nama_supir"/>
                    <span class="help-block-nama_supir"></span>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" onclick="save()" id="btnSetSave">OK</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
