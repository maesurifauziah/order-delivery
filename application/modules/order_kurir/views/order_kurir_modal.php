<div class="modal fade text-xs" id="modal-form-order_barang" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title-form-order_barang">Form Menu User</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="order_id" id="order_id">
                <div class="table-responsive" style="padding-top: 10px">
                    <table id="table2_view" class="table table-sm" width="100%">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;" class="text-center">No</th>
                                <th style="vertical-align: middle;" class="text-left">Nama Produk</th>
                                <th style="vertical-align: middle;" class="text-center">Satuan</th>
                                <th style="vertical-align: middle;" class="text-center">Qty</th>
                                <th style="vertical-align: middle;" class="text-center">Harga</th>
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



