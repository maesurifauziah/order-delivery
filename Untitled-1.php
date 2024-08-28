<script>
var save_method;
var table_order;
var count = 0;
var quantitiyOrder=0;
var bonus=0;
var total_belanja = 0;
var ongkir = 5000;

var base_url = "<?php echo base_url();?>";

$(document).ready(function() {
    get_list_master_kategori_barang_active();
    $('#filter_kategori').val('');
    get_list_barang($('#filter_kategori').val(),'');

    var quantitiy=0;
    $('.quantity-right-plus').click(function(e){
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        $('#quantity').val(quantity + 1);

        if ($('#satuan_jual').val('')) {
            $("#label_total").text("Rp. 0");
        }
        if (isNaN($("#quantity").val())){
            $("#quantity").val(0);
        }

        $('#harga_total').val(parseInt($('#quantity').val()) * parseInt($('#harga_jual').val()));
        $('#label_total').text(formatRupiah($('#harga_total').val(),'Rp.'));

        
        // if (parseInt($('#quantity').val()) >= 20) {
        //     bonus = parseInt($('#harga_total').val()) / 100;
        // } else {
        //     bonus = 0;
        // }
        // if (parseInt($('#harga_total').val()) >= 300000) {
        //     bonus = parseInt($('#harga_total').val()) / 100;
        // } else {
        //     bonus = 0;
        // }
        // $('#bonus').val(bonus)
    });

    $('.quantity-left-minus').click(function(e){
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        if(quantity>0){
            $('#quantity').val(quantity - 1);

            if ($('#satuan_jual').val('')) {
                $("#label_total").text("Rp. 0");
            }
            if (isNaN($("#quantity").val())){
                $("#quantity").val(0);
            }

            $('#harga_total').val(parseInt($('#quantity').val()) * parseInt($('#harga_jual').val()));
            $('#label_total').text(formatRupiah($('#harga_total').val(),'Rp.'));

            // if (parseInt($('#quantity').val()) >= 20) {
            //     bonus = parseInt($('#harga_total').val()) / 100;
            // } else {
            //     bonus = 0;
            // }
            if (parseInt($('#harga_total').val()) >= 300000) {
                bonus = parseInt($('#harga_total').val()) / 100;
            } else {
                bonus = 0;
            }
            // $('#bonus').val(bonus)
        }
    });

    $("#inputSmall").inputSpinner();

    $('.qty-left-minus').click(function(e){
        e.preventDefault();
        alert(tes);
    });

    let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
    if (isMobile) {
        $('.lyt-content').removeClass('content-wrapper');
    } else {
        $('.lyt-content').addClass('content-wrapper');
    }

});

$("#search").keyup(function(){
    get_list_barang($('#filter_kategori').val(),$(this).val())
});

function getValue(radio) {
    let vals = radio.value;  
    // $('.card-giro').hide();

    if (vals == 'C'){
        $('.bukti_pembayaran').hide();
        $('.biaya_penanganan').show();

        $('#biaya_penanganan').val(bonus);
        $('#label_biaya_penanganan').text('Biaya Penanganan = Rp. '+formatRupiah($('#biaya_penanganan').val()));
    }
    if (vals == 'T'){
        $('.bukti_pembayaran').show();
        $('.biaya_penanganan').hide();
        $('#biaya_penanganan').val(0);
        $('#label_biaya_penanganan').text('Biaya Penanganan = Rp. '+formatRupiah($('#biaya_penanganan').val()));
    }
   
}

function get_list_barang(typeTerm, searchTerm) {
    $.ajax({
        url: "<?php echo site_url('order/get_list_barang?typeTerm='); ?>"+typeTerm+"&searchTerm="+searchTerm,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('.product').html(data.html);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error show data');
        }
    });
}

function get_list_order_summary() {
    $('#total_belanja').val(0);
    $('#label_total_belanja').text('Total Belanja = Rp. 0');
    Swal.fire({
        title: '',
        html: '<div class="spinner-grow text-dark text-center" style="width: 3rem; height: 3rem;" role="status"> <span class="sr-only">Loading...</span> </div> <br> Loading...',
        showCancelButton: false,
        showConfirmButton: false,
    });
    Swal.close();
    $.ajax({
        url: "<?php echo site_url('order/get_list_order_summary'); ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#item_detail').empty();
            $('#jumlah_data').val(data.length);
            if (data.length == null) {
                $('#jumlah_data').val(0);
            }
            for (var i = 0; i < data.length; i++) {
                var no = i;
                var bonus_input = '';

                // if (data[i].bonus == 0 || data[i].bonus == null || data[i].bonus == '0') {
                //     bonus_input = '<label class="order_list_label_bonus" id="order_list_label_bonus" style="color:red; font-weight: bold;"></label>';
                // } else {
                //     bonus_input = '<label class="order_list_label_bonus" id="order_list_label_bonus" style="color:red; font-weight: bold;">- '+formatRupiah(data[i].bonus, 'Rp. ')+'</label>';
                // }
                
                    $('#item_detail').append(
                    '<tr>'+
                        '<td style="vertical-align: middle;" class="text-center" width="10%">'+
                            '<input type="checkbox" class="data_ceklis" name="data_ceklis['+i+']" id="data_ceklis'+i+'" onclick="CheckMyValue('+i+')">'+
                            // '<input type="checkbox" class="data_ceklis" name="data_ceklis['+i+']" id="data_ceklis'+i+'" >'+
                        '</td>'+
                        '<td width="25%">' +
                            '<img src="'+base_url+'/upload/master_barang/'+data[i].photo+'" class="img-responsive" style="width: 100%; max-width: 100px; height: auto;" />'+
                        '</td>'+
                        '<td width="55%">' +
                            '<div class="row">'+
                                '<div class="col-sm-12">'+
                                    '<h6 style="color:black; font-weight: bold;">'+data[i].nama_barang+'</h6>'+
                                '</div>'+
                                '<div class="col-sm-12">'+
                                        '<div class="input-group input-group-sm">'+
                                            '<span class="input-group-prepend">'+
                                                '<button type="button" class="btn btn-secondary btn-flat quantity-left-minus-list" id="quantity-left-minus-list'+i+'"> - </button>'+
                                            '</span>'+
                                            '<input type="text" class="form-control form-control-sm input-number order_list_quantity" name="order_list_quantity['+i+']" id="order_list_quantity'+i+'" value="'+data[i].quantity+'" min="0" max="100">'+
                                            '<span class="input-group-append">'+
                                                '<button type="button" class="btn btn-secondary btn-flat quantity-right-plus-list" id="quantity-right-plus-list'+i+'"> + </button>'+
                                            '</span>'+
                                        '</div>'+
                                        '<input type="hidden" class="order_list_tgl_order" name="order_list_tgl_order['+i+']" id="order_list_tgl_order'+i+'" value="'+data[i].tgl_order+'" />'+
                                        '<input type="hidden" class="order_list_kode_barang" name="order_list_kode_barang['+i+']" id="order_list_kode_barang'+i+'" value="'+data[i].kode_barang+'" />'+
                                        '<input type="hidden" class="order_list_userid" name="order_list_userid['+i+']" id="order_list_userid'+i+'" value="'+data[i].userid+'" />'+
                                        '<input type="hidden" class="order_list_detailid" name="order_list_detailid['+i+']" id="order_list_detailid'+i+'" value="'+data[i].detailid+'" />'+
                                        '<input type="hidden" class="order_list_nama_barang" name="order_list_nama_barang['+i+']" id="order_list_nama_barang'+i+'" value="'+data[i].nama_barang+'" />'+
                                        '<input type="hidden" class="order_list_photo" name="order_list_photo['+i+']" id="order_list_photo'+i+'" value="'+data[i].photo+'" />'+
                                        '<input type="hidden" class="order_list_keterangan" name="order_list_keterangan['+i+']" id="order_list_keterangan'+i+'" value="'+data[i].keterangan+'" />'+
                                        '<input type="hidden" class="order_list_status_order" name="order_list_status_order['+i+']" id="order_list_status_order'+i+'" value="'+data[i].status_order+'" />'+
                                        '<input type="hidden" class="order_list_status" name="order_list_status['+i+']" id="order_list_status'+i+'" value="'+data[i].status+'" />'+
                                '</div>'+
                                '<div class="col-sm-12">'+
                                        '<select class="form-control form-control-sm select2" name="order_list_satuan_jual['+i+']" id="order_list_satuan_jual'+i+'">'+
                                            '<option value="'+data[i].satuan_jual+'-'+data[i].harga_total+'" selected>'+data[i].satuan_jual+' ['+formatRupiah(data[i].harga_jual, 'Rp. ')+']</option>'+
                                        '</select>'+
                                        '<input type="hidden" class="order_list_satuan_jual2" name="order_list_satuan_jual2['+i+']" id="order_list_satuan_jual2'+i+'" value="'+data[i].satuan_jual+'" >'+
                                        '<input type="hidden" class="order_list_harga_jual" name="order_list_harga_jual['+i+']" id="order_list_harga_jual'+i+'" value="'+data[i].harga_jual+'" >'+
                                        '<input type="hidden" class="order_list_harga_total" name="order_list_harga_total['+i+']" id="order_list_harga_total'+i+'" value="'+data[i].harga_total+'" >'+
                                        '<input type="hidden" class="order_list_bonus" name="order_list_bonus['+i+']" id="order_list_bonus'+i+'" value="'+data[i].bonus+'" >'+
                                '</div>'+
                                '<div class="col-sm-12 text-right">'+
                                        '<label class="order_list_label_total" id="order_list_label_total" style="color:black; font-weight: bold;">'+formatRupiah(data[i].harga_total, 'Rp. ')+'</label><br>'+
                                        bonus_input+
                                '</div>'+
                            '</div>'+
                        '</td>'+
                        '<td style="vertical-align: middle;" class="text-center" width="10%">'+
                            '<a href="#" class="delete_row btn-danger btn-xs" id="delete_row'+i+'" ><i class="fas fa-trash"></i></a>'+
                        '</td>'+
                    '</tr>'
                );
                var quantitiys=0;
           
                $('#order_list_satuan_jual'+no).attr('readonly', true);
            }
            
            $('#length_list').text($('#jumlah_data').val());
            $('#length_list2').text($('#jumlah_data').val());
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error show data');
        }
    });
}

function get_list_master_kategori_barang_active() {
    $.ajax({
        url: "<?php echo site_url('order/get_list_master_kategori_barang_active'); ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('.item-kategori').empty();
            for (var i = 0; i < data.length; i++) {
                var active_filter = '';
                var kategori_id = "'"+data[i].kategori_id+"'";
                if (data[i].kategori_id == 'KT001') {
                    active_filter = 'active-filter'
                }
                $('.item-kategori').append(
                    '<li class="">'+
                        '<a class="nav-link fltr '+active_filter+'" id="filter_'+data[i].kategori_id+'" style="padding: 0.4rem;" onclick="clickMyValue('+kategori_id+')">'+data[i].kategori_desc+'</a>'+
                    '</li>'
                );         
           }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error show data');
        }
    });
}

function clickMyValue(kategori_id) {
    var value_kategori = kategori_id;
    if (kategori_id == 'KT001') {
        value_kategori = '';
    }
    $('.fltr').removeClass('active-filter');
    $('#filter_'+kategori_id).addClass('active-filter');
    $('#filter_kategori').val(value_kategori);
    $("#search").val('');
    get_list_barang($('#filter_kategori').val(), '')
    $("#search").keyup(function(){
        get_list_barang($('#filter_kategori').val(), $(this).val())
    });
}

function get_list_order_header_proses() {
    Swal.fire({
        title: '',
        html: '<div class="spinner-grow text-dark text-center" style="width: 3rem; height: 3rem;" role="status"> <span class="sr-only">Loading...</span> </div> <br> Loading...',
        showCancelButton: false,
        showConfirmButton: false,
    });
    Swal.close();
    $.ajax({
        url: "<?php echo site_url('order/get_list_order_header_proses'); ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#item-list').empty();
            var lunas_page = '';
            var dikemas_page = '';
            var dikirim_page = '';
            var selesai_page = '';
            var status_pelunasan = '';
            var background = '';
            for (var i = 0; i < data.length; i++) {
                var no = i;

                var createdDateLunas = data[i].createdDateLunas;
                var createdDatePacking = data[i].createdDatePacking;
                var createdDatePengiriman = data[i].createdDatePengiriman;
                var createdDateDone = data[i].createdDateDone;
                if (data[i].createdDateLunas == "0000-00-00 00:00:00") {
                    createdDateLunas = "";
                }
                if (data[i].createdDatePacking == "0000-00-00 00:00:00") {
                    createdDatePacking = "";
                }
                if (data[i].createdDatePengiriman == "0000-00-00 00:00:00") {
                    createdDatePengiriman = "";
                }
                if (data[i].createdDateDone == "0000-00-00 00:00:00") {
                    createdDateDone = "";
                }
                if (data[i].tipe_pembayaran == 'C') {
                    var tipe_pembayaran = "COD";
                    lunas_page = '';
                } else {
                    var tipe_pembayaran = "Transfer";
                    lunas_page = '<div id="lunas_page'+data[i].order_id+'">'+
                                        '<i class="fas fa-money-check-alt bg-red" id="lunas_icon'+data[i].order_id+'"></i>'+
                                        '<div class="timeline-item">'+
                                            '<span class="time"><i class="fas fa-clock"></i> <span id="lunas_time'+data[i].order_id+'" />'+createdDateLunas+'</span>'+
                                            '<h3 class="timeline-header"><a href="#" class="text-red" id="lunas_header'+data[i].order_id+'">Verifikasi Pembayaran</a>'+
                                                '<span id="lunas_nama'+data[i].order_id+'" />'+
                                            '</h3>'+
                                        '</div>'+
                                    '</div>';
                }

                dikemas_page = '<div id="dikemas_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-box bg-red" id="dikemas_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="dikemas_time'+data[i].order_id+'" />'+createdDatePacking+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-red" id="dikemas_header'+data[i].order_id+'">Dikemas</a>'+
                                            '<span id="dikemas_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';
                dikirim_page = '<div id="dikirim_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-truck bg-red" id="dikirim_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="dikirim_time'+data[i].order_id+'" />'+createdDatePengiriman+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-red" id="dikirim_header'+data[i].order_id+'">Dikirim</a>'+
                                            '<span id="dikirim_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';
                selesai_page = '<div id="selesai_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-check bg-red" id="selesai_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="selesai_time'+data[i].order_id+'" />'+createdDateDone+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-red" id="selesai_header'+data[i].order_id+'">Selesai</a>'+
                                            '<span id="selesai_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';

                if (data[i].status_order_barang == 'checkout' && data[i].createdStatusLunas == 'n') {
                    if (data[i].tipe_pembayaran == 'T') {
                        status_pelunasan ='<br><label class="text-white text-center text-xs status_pelunasan'+data[i].order_id+'">(Menunggu Verifikasi Pembayaran)</label>';
                    }
                    background = 'bg-secondary';
                } else
                if (data[i].status_order_barang == 'lunas' && data[i].createdStatusLunas == 'y') {
                    lunas_page = '<div id="lunas_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-money-check-alt bg-green" id="lunas_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="lunas_time'+data[i].order_id+'" />'+createdDateLunas+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-green" id="lunas_header'+data[i].order_id+'">Verifikasi Pembayaran</a>'+
                                            '<span id="lunas_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';
                    status_pelunasan ='';
                    background = 'bg-olive';
                } else
                if (data[i].status_order_barang == 'packing' && data[i].createdStatusPacking == 'y') {
                    dikemas_page = '<div id="dikemas_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-box bg-green" id="dikemas_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="dikemas_time'+data[i].order_id+'" />'+createdDatePacking+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-green" id="dikemas_header'+data[i].order_id+'">Dikemas</a>'+
                                            '<span id="dikemas_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';
                    status_pelunasan ='';
                    background = 'bg-primary';
                }
                if (data[i].status_order_barang == 'pengiriman' && data[i].createdStatusPengiriman == 'y') {
                    dikirim_page = '<div id="dikirim_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-truck bg-green" id="dikirim_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="dikirim_time'+data[i].order_id+'" />'+createdDatePengiriman+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-green" id="dikirim_header'+data[i].order_id+'">Dikirim</a>'+
                                            '<span id="dikirim_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';
                    status_pelunasan ='';
                    background = 'bg-info';
                }
                if (data[i].status_order_barang == 'done' && data[i].createdStatusDone == 'y') {
                    selesai_page = '<div id="selesai_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-check bg-green" id="selesai_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="selesai_time'+data[i].order_id+'" />'+createdDateDone+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-green" id="selesai_header'+data[i].order_id+'">Selesai</a>'+
                                            '<span id="selesai_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';
                    status_pelunasan ='';
                    background = 'bg-success';
                }
                $('#item-list').append(
                    '<div class="card text-center '+background+'" style="margin-bottom: 0.2rem;"id="headingOne'+data[i].order_id+'">'+
                        '<h5>'+
                            '<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne'+data[i].order_id+'" aria-expanded="true" aria-controls="collapseOne'+data[i].order_id+'">'+
                                '<label class="text-white text-center">No Order '+data[i].order_id+'</label> <br>'+
                                '<label class="text-white text-center">Tanggal Order '+data[i].tgl_checkout+'</label> <br>'+
                                '<label class="text-white text-center grand_total'+data[i].order_id+'">'+formatRupiah(data[i].grand_total,'Rp. ')+' ('+tipe_pembayaran+')</label>'+
                                status_pelunasan+
                            '</button>'+
                        '</h5>'+
                    '</div>'+
                    '<div id="collapseOne'+data[i].order_id+'" class="collapse" aria-labelledby="headingOne'+data[i].order_id+'" data-parent="#accordion">'+
                        '<div class="card-body pt-1">'+
                        '<div class="row pb-3">'+
                            // '<div class="col-sm-12">'+
                            //     '<a data-toggle="collapse" data-target="#demo'+data[i].order_id+'">Detail Pesanan</a>'+
                            //     ' <div id="demo'+data[i].order_id+'" class="collapse">'+
                            //         'Lorem ipsum dolor text....'+data[i].order_id+
                            //     '</div>'+
                            // '</div>'+
                        '</div>'+
                        '<div class="timeline">'+
                            lunas_page+
                            dikemas_page+
                            dikirim_page+
                            selesai_page+
                            '</div>'+
                        '</div>'+
                    '</div>'
                );

            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error show data');
        }
    });
}
function get_list_order_header_done() {
    Swal.fire({
        title: '',
        html: '<div class="spinner-grow text-dark text-center" style="width: 3rem; height: 3rem;" role="status"> <span class="sr-only">Loading...</span> </div> <br> Loading...',
        showCancelButton: false,
        showConfirmButton: false,
    });
    Swal.close();
    $.ajax({
        url: "<?php echo site_url('order/get_list_order_header_done'); ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#item-list-history').empty();
            var lunas_page = '';
            var dikemas_page = '';
            var dikirim_page = '';
            var selesai_page = '';
            var status_pelunasan = '';
            var background = '';
            for (var i = 0; i < data.length; i++) {
                var no = i;

                var createdDateLunas = data[i].createdDateLunas;
                var createdDatePacking = data[i].createdDatePacking;
                var createdDatePengiriman = data[i].createdDatePengiriman;
                var createdDateDone = data[i].createdDateDone;
                if (data[i].createdDateLunas == "0000-00-00 00:00:00") {
                    createdDateLunas = "";
                }
                if (data[i].createdDatePacking == "0000-00-00 00:00:00") {
                    createdDatePacking = "";
                }
                if (data[i].createdDatePengiriman == "0000-00-00 00:00:00") {
                    createdDatePengiriman = "";
                }
                if (data[i].createdDateDone == "0000-00-00 00:00:00") {
                    createdDateDone = "";
                }
                if (data[i].tipe_pembayaran == 'C') {
                    var tipe_pembayaran = "COD";
                    lunas_page = '';
                } else {
                    var tipe_pembayaran = "Transfer";
                    lunas_page = '<div id="lunas_page'+data[i].order_id+'">'+
                                        '<i class="fas fa-money-check-alt bg-red" id="lunas_icon'+data[i].order_id+'"></i>'+
                                        '<div class="timeline-item">'+
                                            '<span class="time"><i class="fas fa-clock"></i> <span id="lunas_time'+data[i].order_id+'" />'+createdDateLunas+'</span>'+
                                            '<h3 class="timeline-header"><a href="#" class="text-red" id="lunas_header'+data[i].order_id+'">Verifikasi Pembayaran</a>'+
                                                '<span id="lunas_nama'+data[i].order_id+'" />'+
                                            '</h3>'+
                                        '</div>'+
                                    '</div>';
                }

                dikemas_page = '<div id="dikemas_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-box bg-red" id="dikemas_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="dikemas_time'+data[i].order_id+'" />'+createdDatePacking+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-red" id="dikemas_header'+data[i].order_id+'">Dikemas</a>'+
                                            '<span id="dikemas_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';
                dikirim_page = '<div id="dikirim_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-truck bg-red" id="dikirim_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="dikirim_time'+data[i].order_id+'" />'+createdDatePengiriman+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-red" id="dikirim_header'+data[i].order_id+'">Dikirim</a>'+
                                            '<span id="dikirim_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';
                selesai_page = '<div id="selesai_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-check bg-red" id="selesai_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="selesai_time'+data[i].order_id+'" />'+createdDateDone+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-red" id="selesai_header'+data[i].order_id+'">Selesai</a>'+
                                            '<span id="selesai_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';

                if (data[i].status_order_barang == 'checkout' && data[i].createdStatusLunas == 'n') {
                    if (data[i].tipe_pembayaran == 'T') {
                        status_pelunasan ='<br><label class="text-white text-center text-xs status_pelunasan'+data[i].order_id+'">(Menunggu Verifikasi Pembayaran)</label>';
                    }
                    background = 'bg-secondary';
                } else
                if (data[i].status_order_barang == 'lunas' && data[i].createdStatusLunas == 'y') {
                    lunas_page = '<div id="lunas_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-money-check-alt bg-green" id="lunas_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="lunas_time'+data[i].order_id+'" />'+createdDateLunas+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-green" id="lunas_header'+data[i].order_id+'">Verifikasi Pembayaran</a>'+
                                            '<span id="lunas_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';
                    status_pelunasan ='';
                    background = 'bg-olive';
                } else
                if (data[i].status_order_barang == 'packing' && data[i].createdStatusPacking == 'y') {
                    dikemas_page = '<div id="dikemas_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-box bg-green" id="dikemas_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="dikemas_time'+data[i].order_id+'" />'+createdDatePacking+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-green" id="dikemas_header'+data[i].order_id+'">Dikemas</a>'+
                                            '<span id="dikemas_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';
                    status_pelunasan ='';
                    background = 'bg-primary';
                }
                if (data[i].status_order_barang == 'pengiriman' && data[i].createdStatusPengiriman == 'y') {
                    dikirim_page = '<div id="dikirim_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-truck bg-green" id="dikirim_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="dikirim_time'+data[i].order_id+'" />'+createdDatePengiriman+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-green" id="dikirim_header'+data[i].order_id+'">Dikirim</a>'+
                                            '<span id="dikirim_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';
                    status_pelunasan ='';
                    background = 'bg-info';
                }
                if (data[i].status_order_barang == 'done' && data[i].createdStatusDone == 'y') {
                    selesai_page = '<div id="selesai_page'+data[i].order_id+'">'+
                                    '<i class="fas fa-check bg-green" id="selesai_icon'+data[i].order_id+'"></i>'+
                                    '<div class="timeline-item">'+
                                        '<span class="time"><i class="fas fa-clock"></i> <span id="selesai_time'+data[i].order_id+'" />'+createdDateDone+'</span>'+
                                        '<h3 class="timeline-header"><a href="#" class="text-green" id="selesai_header'+data[i].order_id+'">Selesai</a>'+
                                            '<span id="selesai_nama'+data[i].order_id+'" />'+
                                        '</h3>'+
                                    '</div>'+
                                '</div>';
                    status_pelunasan ='';
                    background = 'bg-success';
                }
                $('#item-list-history').append(
                    '<div class="card text-center '+background+'" style="margin-bottom: 0.2rem;"id="headingOne'+data[i].order_id+'">'+
                        '<h5>'+
                            '<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne'+data[i].order_id+'" aria-expanded="true" aria-controls="collapseOne'+data[i].order_id+'">'+
                                '<label class="text-white text-center">No Order '+data[i].order_id+'</label> <br>'+
                                '<label class="text-white text-center">Tanggal Order '+data[i].tgl_checkout+'</label> <br>'+
                                '<label class="text-white text-center grand_total'+data[i].order_id+'">'+formatRupiah(data[i].grand_total,'Rp. ')+' ('+tipe_pembayaran+')</label>'+
                                status_pelunasan+
                            '</button>'+
                        '</h5>'+
                    '</div>'+
                    '<div id="collapseOne'+data[i].order_id+'" class="collapse" aria-labelledby="headingOne'+data[i].order_id+'" data-parent="#accordion">'+
                        '<div class="card-body">'+
                            '<div class="timeline">'+
                            lunas_page+
                            dikemas_page+
                            dikirim_page+
                            selesai_page+
                            '</div>'+
                        '</div>'+
                    '</div>'
                );

            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error show data');
        }
    });
}

$('#table2 tbody').on('click', '.delete_row', function() {
    var tgl_order = $(this).parents("tr").find(".order_list_tgl_order").val();
    var kode_barang = $(this).parents("tr").find(".order_list_kode_barang").val();
    var userid = $(this).parents("tr").find(".order_list_userid").val();
    var detailid = $(this).parents("tr").find(".order_list_detailid").val();
    
    $.ajax({
        url: "<?php echo site_url('order/cancel'); ?>",
        type: "POST",
        dataType: "JSON",
        data: {
            tgl_order: tgl_order, 
            kode_barang: kode_barang, 
            userid: userid, 
            detailid: detailid, 
        },
        success: function(data) {
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: 'Berhasil dihapus!',
                timer: 2000,
                showCancelButton: false,
                showConfirmButton: false
            }).then(function() {
                Swal.close();
                get_list_order_summary();
                $('#length_list').text($('#jumlah_data').val());
                $('#length_list2').text($('#jumlah_data').val());
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error nonaktif data');
        }
    });
    
    // $(this).parents("tr").remove();
});
$('#table2 tbody').on('click', '.quantity-right-plus-list', function() {
    var quantitiyOrder = parseInt($(this).parents("tr").find(".order_list_quantity").val());
    $(this).parents("tr").find(".order_list_quantity").val(quantitiyOrder + 1)

    if ($(this).parents("tr").find(".order_list_satuan_jual").val('')) {
        $(this).parents("tr").find(".order_list_label_total").text("Rp. 0");
    }
    if (isNaN($(this).parents("tr").find(".order_list_quantity").val())){
        $(this).parents("tr").find(".order_list_quantity").val(0);
    }

    $(this).parents("tr").find(".order_list_harga_total").val(parseInt($(this).parents("tr").find(".order_list_quantity").val()) * parseInt($(this).parents("tr").find(".order_list_harga_jual").val()));
    $(this).parents("tr").find(".order_list_label_total").text(formatRupiah($(this).parents("tr").find(".order_list_harga_total").val(),'Rp.'));

    // if ($(this).parents("tr").find(".order_list_quantity").val() >=20) {
    //     bonus = $(this).parents("tr").find(".order_list_harga_total").val()/100;
    //     $(this).parents("tr").find(".order_list_bonus").val(bonus);
    //     $(this).parents("tr").find(".order_list_label_bonus").text('- '+formatRupiah($(this).parents("tr").find(".order_list_bonus").val(),'Rp.'));
    // } else {
    //     bonus = 0;
    //     $(this).parents("tr").find(".order_list_bonus").val(bonus);
    //     $(this).parents("tr").find(".order_list_label_bonus").text('');
    // }

    // grand_total = 0;
    // if ($(this).parents("tr").find(".data_ceklis").val('y')) {
    //     grand_total =  parseInt($('#grand_total').val()) - parseInt(($(this).parents("tr").find(".order_list_harga_total").val()) - $(this).parents("tr").find(".order_list_bonus").val());
    //     $('#grand_total').val(grand_total);
    //     $('#grand_total2').text('Rp. '+formatRupiah($('#grand_total').val()));
    // }
   

});
$('#table2 tbody').on('click', '.quantity-left-minus-list', function() {
    var quantitiyOrder = parseInt($(this).parents("tr").find(".order_list_quantity").val());
    if(quantitiyOrder>0){
        $(this).parents("tr").find(".order_list_quantity").val(quantitiyOrder - 1)
        if ($(this).parents("tr").find(".order_list_satuan_jual").val('')) {
            $(this).parents("tr").find(".order_list_label_total").text("Rp. 0");
        }
        if (isNaN($(this).parents("tr").find(".order_list_quantity").val())){
            $(this).parents("tr").find(".order_list_quantity").val(0);
        }

        $(this).parents("tr").find(".order_list_harga_total").val(parseInt($(this).parents("tr").find(".order_list_quantity").val()) * parseInt($(this).parents("tr").find(".order_list_harga_jual").val()));
        $(this).parents("tr").find(".order_list_label_total").text(formatRupiah($(this).parents("tr").find(".order_list_harga_total").val(),'Rp.'));

        // if ($(this).parents("tr").find(".order_list_quantity").val() >=20) {
        //     bonus = $(this).parents("tr").find(".order_list_harga_total").val()/100;
        //     $(this).parents("tr").find(".order_list_bonus").val(bonus);
        //     $(this).parents("tr").find(".order_list_label_bonus").text('- '+formatRupiah($(this).parents("tr").find(".order_list_bonus").val(),'Rp.'));
        // } else {
        //     bonus = 0;
        //     $(this).parents("tr").find(".order_list_bonus").val(bonus);
        //     $(this).parents("tr").find(".order_list_label_bonus").text('');
        // }

        // grand_total = 0;
        // if ($(this).parents("tr").find(".data_ceklis").val('y')) {
        //     grand_total =  parseInt($('#grand_total').val()) - parseInt(($(this).parents("tr").find(".order_list_harga_total").val()) - $(this).parents("tr").find(".order_list_bonus").val());
        //     $('#grand_total').val(grand_total);
        //     $('#grand_total2').text('Rp. '+formatRupiah($('#grand_total').val()));
        // }
    }
});

$('#table2 tbody').on('keyup', '.order_list_quantity', function() {
    $(this).parents("tr").find(".order_list_harga_total").val(parseInt($(this).parents("tr").find(".order_list_quantity").val()) * parseInt($(this).parents("tr").find(".order_list_harga_jual").val()));
    $(this).parents("tr").find(".order_list_label_total").text(formatRupiah($(this).parents("tr").find(".order_list_harga_total").val(),'Rp.'));
    if (isNaN($(this).parents("tr").find(".order_list_quantity").val())){
        $(this).parents("tr").find(".order_list_quantity").val(0);
    }
    if ($(this).parents("tr").find(".order_list_satuan_jual").val('')) {
        $(this).parents("tr").find(".order_list_label_total").text("Rp. 0");
    }
    $(this).parents("tr").find(".order_list_harga_total").val(parseInt($(this).parents("tr").find(".order_list_quantity").val()) * parseInt($(this).parents("tr").find(".order_list_harga_jual").val()));
    $(this).parents("tr").find(".order_list_label_total").text(formatRupiah($(this).parents("tr").find(".order_list_harga_total").val(),'Rp.'));

    // if ($(this).parents("tr").find(".order_list_quantity").val() >=20) {
    //     bonus = $(this).parents("tr").find(".order_list_harga_total").val()/100;
    //     $(this).parents("tr").find(".order_list_bonus").val(bonus);
    //     $(this).parents("tr").find(".order_list_label_bonus").text('- '+formatRupiah($(this).parents("tr").find(".order_list_bonus").val(),'Rp.'));
    // } else {
    //     bonus = 0;
    //     $(this).parents("tr").find(".order_list_bonus").val(bonus);
    //     $(this).parents("tr").find(".order_list_label_bonus").text('');
    // }

    // grand_total = 0;
    // if ($(this).parents("tr").find(".data_ceklis").val('y')) {
    //     grand_total =  parseInt($('#grand_total').val()) - parseInt(($(this).parents("tr").find(".order_list_harga_total").val()) - $(this).parents("tr").find(".order_list_bonus").val());
    //     $('#grand_total').val(grand_total);
    //     $('#grand_total2').text('Rp. '+formatRupiah($('#grand_total').val()));
    // }
});

function formatRupiah(angka, prefix)
{
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split    = number_string.split(','),
        sisa     = split[0].length % 3,
        rupiah     = split[0].substr(0, sisa),
        ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
        
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function select2_list2(select_id, link, value = "", text = "") {
    $(select_id).select2().val(null).trigger("change");
    $(select_id).select2({
        ajax: {
            url: base_url + link,
            dataType: 'JSON',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        },
        placeholder: 'Satuan',
        width: '100%',
    });
    if (value != "") {
        var newState = new Option(text, value, true, true);
        $(select_id).append(newState).trigger('change');
    };
}

$('#select_all').on('change', function() {
    var row = 0;
    total_belanja = 0;
    // ongkir = 5000;
    $('#ongkir').val(ongkir);
    $('#total_belanja').val(total_belanja);
    if ($(this).prop('checked')) {
        // ongkir = 5000;
        $('.data_ceklis').prop('checked','checked');
        $(this).val('y');
        row = $('#jumlah_data').val();
        for(i=0;i<=(row-1);i++){
            $('#data_ceklis'+i).prop('checked','checked');
            $('#delete_row'+i).hide();
            $('#order_list_quantity'+i).val();
            $('#order_list_quantity'+i).attr('readonly', true);
            $('#quantity-left-minus-list'+i).attr('disabled', true);
            $('#quantity-right-plus-list'+i).attr('disabled', true);
            $('#order_list_harga_total'+i).val();
            $('#order_list_bonus'+i).val();
            total_belanja =  parseInt($('#total_belanja').val()) + parseInt(($('#order_list_harga_total'+i).val()) - $('#order_list_bonus'+i).val());
            $('#total_belanja').val(total_belanja);
            $('#label_total_belanja').text('Total Belanja = Rp. '+formatRupiah($('#total_belanja').val()));
            
            if ($('#total_belanja').val() >= 300000) {
                ongkir = 0;
                bonus = total_belanja / 100;
            } else {
                ongkir = 5000;
                bonus = 0;
            }
            $('#ongkir').val(ongkir);
            $('#label_ongkir').text('Ongkir = Rp. '+formatRupiah($('#ongkir').val()));

            $('#bonus').val(bonus);
            $('#label_bonus').text('Diskon = - Rp. '+formatRupiah($('#bonus').val()));

            $('#biaya_penanganan').val(bonus);
            $('#label_biaya_penanganan').text('Biaya Penanganan = Rp. '+formatRupiah($('#biaya_penanganan').val()));
            
            $('#grand_total').val(total_belanja);
            $('#grand_total2').text('Rp. '+formatRupiah($('#grand_total').val()));
        }

    } else {
        $('.data_ceklis').prop('checked', false);
        $(this).val('n');
        row = $('#jumlah_data').val();
        for(i=0;i<=(row-1);i++){
            $('.data_ceklis').prop('checked', false);
            $('#delete_row'+i).show();
            $('#order_list_quantity'+i).attr('readonly', false);
            $('#quantity-left-minus-list'+i).attr('disabled', false);
            $('#quantity-right-plus-list'+i).attr('disabled', false);
        }
        $('#total_belanja').val(total_belanja);
        $('#label_total_belanja').text('Total Belanja = Rp. '+formatRupiah($('#total_belanja').val()));
        if ($('#total_belanja').val() >= 300000) {
                ongkir = 0;
                bonus = total_belanja / 100;
            } else {
                ongkir = 5000;
                bonus = 0;
            }
            $('#ongkir').val(ongkir);
            $('#label_ongkir').text('Ongkir = Rp. '+formatRupiah($('#ongkir').val()));

            $('#bonus').val(bonus);
            $('#label_bonus').text('Diskon = - Rp. '+formatRupiah($('#bonus').val()));

            $('#biaya_penanganan').val(bonus);
            $('#label_biaya_penanganan').text('Biaya Penanganan = Rp. '+formatRupiah($('#biaya_penanganan').val()));
    }
});

function CheckMyValue(i) {
    total_belanja = 0;
    // ongkir = 5000;
    if ($('#data_ceklis'+i).prop('checked')){
        // ongkir = 5000;
        $('#data_ceklis'+i).prop('checked','checked');
        $('#delete_row'+i).hide();
        $('#order_list_quantity'+i).val();
        $('#order_list_quantity'+i).attr('readonly', true);
        $('#quantity-left-minus-list'+i).attr('disabled', true);
        $('#quantity-right-plus-list'+i).attr('disabled', true);
        $('#order_list_harga_total'+i).val();
        $('#order_list_bonus'+i).val();
        total_belanja =  parseInt($('#total_belanja').val()) + parseInt(($('#order_list_harga_total'+i).val()) - $('#order_list_bonus'+i).val());
        $('#total_belanja').val(total_belanja);
        $('#label_total_belanja').text('Total Belanja = Rp. '+formatRupiah($('#total_belanja').val()));
        if ($('#total_belanja').val() >= 300000) {
                ongkir = 0;
                bonus = total_belanja / 100;
            } else {
                ongkir = 5000;
                bonus = 0;
            }
            $('#ongkir').val(ongkir);
            $('#label_ongkir').text('Ongkir = Rp. '+formatRupiah($('#ongkir').val()));

            $('#bonus').val(bonus);
            $('#label_bonus').text('Diskon = - Rp. '+formatRupiah($('#bonus').val()));

            $('#biaya_penanganan').val(bonus);
            $('#label_biaya_penanganan').text('Biaya Penanganan = Rp. '+formatRupiah($('#biaya_penanganan').val()));

            $('#grand_total').val(total_belanja);
            $('#grand_total2').text('Rp. '+formatRupiah($('#grand_total').val()));
    } else {
        $('#data_ceklis'+i).prop('checked', false);
        $('#delete_row'+i).show();
        $('#order_list_quantity'+i).val();
        $('#order_list_quantity'+i).attr('readonly', false);
        $('#quantity-left-minus-list'+i).attr('disabled', false);
        $('#quantity-right-plus-list'+i).attr('disabled', false);
        $('#order_list_harga_total'+i).val();
        $('#order_list_bonus'+i).val();
        total_belanja =  parseInt($('#total_belanja').val()) - parseInt(($('#order_list_harga_total'+i).val()) - $('#order_list_bonus'+i).val());
        $('#total_belanja').val(total_belanja);
        $('#label_total_belanja').text('Total Belanja = Rp. '+formatRupiah($('#total_belanja').val()));
        if ($('#total_belanja').val() >= 300000) {
                ongkir = 0;
                bonus = total_belanja / 100;
            } else {
                ongkir = 5000;
                bonus = 0;
            }
            $('#ongkir').val(ongkir);
            $('#label_ongkir').text('Ongkir = Rp. '+formatRupiah($('#ongkir').val()));

            $('#bonus').val(bonus);
            $('#label_bonus').text('Diskon = - Rp. '+formatRupiah($('#bonus').val()));

            $('#biaya_penanganan').val(bonus);
            $('#label_biaya_penanganan').text('Biaya Penanganan = Rp. '+formatRupiah($('#biaya_penanganan').val()));
    }
}

function cart() {
    save_method = 'add_checkout';
    $('#form-order_list')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-order_list').modal('show');

    get_list_order_summary();
    $('#length_list').text($('#jumlah_data').val());
    $('#length_list2').text($('#jumlah_data').val());
    $('[name="alamat_kirim"]').attr('readonly', false);
    $('[name="alamat_kirim"]').removeClass('is-invalid');
    $('.help-block-alamat_kirim').addClass('text-danger').text('');
    $('.bukti_pembayaran').hide();
    $('.biaya_penanganan').show();
    $('#ongkir').val(ongkir);
    $('#label_ongkir').text('Ongkir = Rp. '+formatRupiah($('#ongkir').val()));
    
}

function history_order() {
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-history_order').modal('show');
    $('.modal-title-form-history_order').text('Riwayat Order');
    get_list_order_header_done();
}

function proses_order() {
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-proses_order').modal('show');
    $('.modal-title-form-proses_order').text('Proses Order');
    get_list_order_header_proses();
}

$('.product').on('click', '.add_to_cart', function() {
    save_method = 'add_to_cart';
    $('#form-order')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-order').modal('show');
    $('.modal-title-form-order').text('Edit Barang');

    $('[name="kode_barang"]').val($(this).data('kode_barang'));
    $('[name="nama_barang"]').val($(this).data('nama_barang'));
    $('[name="photo"]').val($(this).data('photo'));
    $('[name="satuan_jual_id"]').val($(this).data('satuan'));
    $('[name="harga_jual"]').val($(this).data('harga_jual'));
    $('[name="harga_beli"]').val($(this).data('harga_beli'));

    $('#label_nama_barang').text($(this).data('nama_barang'));
    $('#keterangan').val($(this).data('keterangan'));

    $('[name="satuan_jual_id"]').attr('readonly', false);
    $('[name="quantity"]').attr('readonly', false);

    $('[name="satuan_jual_id"]').removeClass('is-invalid');
    $('.help-block-satuan_jual_id').addClass('text-danger').text('');
	$('[name="quantity"]').removeClass('is-invalid');
    $('.help-block-quantity').addClass('text-danger').text('');

    $('.photo-product').html('<img class="card-img-top" src="'+$(this).data('path_photo')+'" style="width: 70%; max-width: 400px; height: auto;">'); // show photo
    
    select_id2 = "#satuan_jual";
    link2 = "order/get_list_satuan_barang?kode_barang="+$("#kode_barang").val();
    select2_list2(select_id2, link2);

    if ($('#satuan_jual').val('')) {
        $("#label_total").text("Rp. 0");
    }

    $("#harga_total").val(0);
    // $("#harga_jual").val(0);
    // $("#bonus").val(0);

    $("#quantity").keyup(function(){
        $('#harga_total').val(parseInt($(this).val()) * parseInt($('#harga_jual').val()));
        $('#label_total').text(formatRupiah($('#harga_total').val(),'Rp.'));
        if (isNaN($("#quantity").val())){
            $("#quantity").val(0);
        }
        if (isNaN($("#harga_total").val())){
            $("#harga_total").val(0);
        }
        
        // if (parseInt($('#quantity').val()) >= 20) {
        //     bonus = parseInt($('#harga_total').val()) / 100;
        // } else {
        //     bonus = 0;
        // }
        // if (parseInt($('#harga_total').val()) >= 300000) {
        //     bonus = parseInt($('#harga_total').val()) / 100;
        // } else {
        //     bonus = 0;
        // }
        // $('#bonus').val(bonus)
    });

    $('#photo').show();
    $('#btnSaveApp').show();
    
});

function save() {
    $('#btnSave').text('Saving...');
    $('#btnSave').attr('disabled', true);
    if (save_method == "add_to_cart") {
        url = 'order/add_to_cart';
        var formData = new FormData($('#form-order')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#modal-form-order').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Berhasil di tambahkan ke keranjang...',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        get_list_barang($('#filter_kategori').val(), '')
                        $('#modal-form-order').modal('hide');
                        get_list_order_summary();
                        Swal.close();
                    });
                } else {
                    if (data.inputerror) {
                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                            $('.help-block-' + data.inputerror[i]).addClass('text-danger').text(data
                                .error_string[i]);
                        }
                    }
                    if (data.msg) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning!',
                            text: data.msg,
                            timer: 1500,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }
                }
                $('#btnSave').text('Save');
                $('#btnSave').attr('disabled', false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('Save');
                $('#btnSave').attr('disabled', false);
            }
        });
    } else if (save_method == "add_checkout") {
        url = 'order/add_checkout';
        var formData = new FormData($('#form-order_list')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#modal-form-order_list').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil disimpan...',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        $('#modal-form-order_list').modal('hide');
                        Swal.close();
                        get_list_order_summary();
                    });
                } else {
                    if (data.inputerror) {
                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                            $('.help-block-' + data.inputerror[i]).addClass('text-danger').text(data
                                .error_string[i]);
                        }
                    }
                    if (data.msg) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning!',
                            text: data.msg,
                            timer: 1500,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }
                }
                $('#btnSaveApp').text('Save');
                $('#btnSaveApp').attr('disabled', false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSaveApp').text('Save');
                $('#btnSaveApp').attr('disabled', false);
            }
        });
    } 
    
}
</script>