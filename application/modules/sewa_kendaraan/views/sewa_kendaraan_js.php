<script>

var save_method;
var grand_total = 0;
var uang_muka = 0;
var base_url = "<?php echo base_url();?>";
$(document).ready(function() {

    // $("#filter_tipe_kendaraan").select2();    
    get_list_kendaraan('', '');
    
    let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
    if (isMobile) {
        $('.lyt-content').removeClass('content-wrapper');
    } else {
        $('.lyt-content').addClass('content-wrapper');
    }
    
});


$('#filter').on('click', function() {
    get_list_kendaraan('', '');
});

$("#search").keyup(function(){
    get_list_kendaraan($(this).val(), '');
});

function get_list_kendaraan(searchTerm, typeTerm) {
    $.ajax({
        url: "<?php echo site_url('sewa_kendaraan/get_list_kendaraan?searchTerm='); ?>" + searchTerm +"&typeTerm=" + typeTerm,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('.kendaraan').html(data.html);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error show data');
        }
    });
}
$('#tgl_pinjam').attr({ 
    min : $('#tgl_pinjam').val(), 
});
$('#tgl_kembali').attr({ 
    min : $('#tgl_pinjam').val(), 
});

$('#tgl_pinjam').on('change', function() {
    $('#tgl_kembali').attr({ 
        min : $('#tgl_pinjam').val(), 
        value : '', 
    });
});

$('.kendaraan').on('click', '.add_to_cart', function() {
    $('#btnSaveApp').text('Save');
    $('#btnSaveApp').attr('disabled', false);
    save_method = 'add_to_cart';
    $('#form-sewa')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-sewa').modal('show');

    $('[name="kendaraan_id"]').val($(this).data('kendaraan_id'));
    $('[name="nama_kendaraan"]').val($(this).data('nama_kendaraan'));
    $('[name="harga_kendaraan"]').val($(this).data('harga_kendaraan'));
    $('[name="photo"]').val($(this).data('photo'));

    $('#label_nama_kendaraan').text($(this).data('nama_kendaraan'));
    $('#label_tahun_kendaraan').text($(this).data('tahun_kendaraan'));
    $('#label_kapasitas_kendaraan').text($(this).data('kapasitas_kendaraan'));
    $('#label_merk_kendaraan').text($(this).data('merk_kendaraan'));
    $('#label_no_polisi').text($(this).data('no_polisi'));

    $('[name="kendaraan_id"]').attr('readonly', false);
    $('[name="nama_kendaraan"]').attr('readonly', false);
    $('[name="harga_kendaraan"]').attr('readonly', false);
    $('[name="photo"]').attr('readonly', false);
    $('[name="tgl_pinjam"]').attr('readonly', false);
    $('[name="tgl_kembali"]').attr('readonly', false);

    $('[name="kendaraan_id"]').removeClass('is-invalid');
    $('.help-block-kendaraan_id').addClass('text-danger').text('');
	$('[name="nama_kendaraan"]').removeClass('is-invalid');
    $('.help-block-nama_kendaraan').addClass('text-danger').text('');
    $('[name="harga_kendaraan"]').removeClass('is-invalid');
    $('.help-block-harga_kendaraan').addClass('text-danger').text('');
	$('[name="photo"]').removeClass('is-invalid');
    $('.help-block-photo').addClass('text-danger').text('');
    $('[name="tgl_pinjam"]').removeClass('is-invalid');
    $('.help-block-tgl_pinjam').addClass('text-danger').text('');
	$('[name="tgl_kembali"]').removeClass('is-invalid');
    $('.help-block-tgl_kembali').addClass('text-danger').text('');
    
    $('.photo-kendaraan').html('<img class="card-img-top" src="'+$(this).data('path_photo')+'" style="width: 100%; max-width: 400px; height: auto;">'); // show photo

    $('#photo').show();
    $('#btnSaveApp').show();
    
});

function cart() {
    save_method = 'add_checkout';
    $('#form-sewa_list')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-sewa_list').modal('show');

    $('[name="titik_jemput"]').attr('readonly', false);

    $('[name="titik_jemput"]').removeClass('is-invalid');
    $('.help-block-titik_jemput').addClass('text-danger').text('');

    get_list_sewa_summary();
    $('#length_list').text($('#jumlah_data').val());
    $('#length_list2').text($('#jumlah_data').val());

    
}

function get_list_sewa_summary() {
    $('#grand_total').val(0);
    $('#grand_total2').text('Rp. 0');
    $('#uang_muka').val(0);
    $('#uang_muka2').text('Rp. 0 (Uang Muka 30%)');
    Swal.fire({
        title: '',
        html: '<div class="spinner-grow text-dark text-center" style="width: 3rem; height: 3rem;" role="status"> <span class="sr-only">Loading...</span> </div> <br> Loading...',
        showCancelButton: false,
        showConfirmButton: false,
    });
    Swal.close();
    $.ajax({
        url: "<?php echo site_url('sewa_kendaraan/get_list_sewa_summary'); ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#item_detail').empty();
            $('#jumlah_data').val(data.length);
            if (data.length == null) {
                $('#jumlah_data').val(0);
            }
            var  uang_muka = 0;
            var  path_photo = 0;
            for (var i = 0; i < data.length; i++) {
                var no = i;
                var uang_muka = (data[i].subtotal_sewa * 30) / 100 ;

                if (data[i].photo == '' || data[i].photo == null) {
                    path_photo = '<img src="'+base_url+'upload/dummy/images.jpg" class="img-responsive" style="width: 100%; max-width: 100px; height: auto;" />';
                } else {
                    path_photo = '<img src="'+base_url+'upload/master_kendaraan/'+data[i].photo+'" class="img-responsive" style="width: 100%; max-width: 100px; height: auto;" />';
                }
                
                $('#item_detail').append(
                    '<tr>'+
                        '<td style="vertical-align: middle;" class="text-center" width="10%">'+
                            '<input type="checkbox" class="data_ceklis" name="data_ceklis['+i+']" id="data_ceklis'+i+'" onclick="CheckMyValue('+i+')">'+
                        '</td>'+
                        '<td width="25%" style="vertical-align: middle;">' +
                        path_photo+
                        '</td>'+
                        '<td width="55%">' +
                            '<div class="row">'+
                                '<div class="col-sm-12 border-bottom">'+
                                    '<label class="text-sm" style="color:black; font-weight: bold; margin-bottom: 0rem;">Nama Kendaraan</label> <br>'+
                                    '<p class="text-sm" style="margin-bottom: 0.2rem;">'+data[i].nama_kendaraan+'</p>'+
                                '</div>'+
                                '<div class="col-sm-12 border-bottom">'+
                                    '<label class="text-sm" style="color:black; font-weight: bold; margin-bottom: 0rem;">Merk Kendaraan</label> <br>'+
                                    '<p class="text-sm" style="margin-bottom: 0.2rem;">'+data[i].merk_kendaraan+'</p>'+
                                '</div>'+
                                '<div class="col-sm-12 border-bottom">'+
                                    '<label class="text-sm" style="color:black; font-weight: bold; margin-bottom: 0rem;">Kapasitas</label> <br>'+
                                    '<p class="text-sm" style="margin-bottom: 0.2rem;">'+data[i].kapasitas_kendaraan+' Siet</p>'+
                                '</div>'+
                                '<div class="col-sm-12 border-bottom">'+
                                    '<label class="text-sm" style="color:black; font-weight: bold; margin-bottom: 0rem;">Tanggal Peminjaman</label> <br>'+
                                    '<p class="text-sm" style="margin-bottom: 0.2rem;">'+data[i].tgl_pinjam+' - '+data[i].tgl_kembali+' ('+data[i].lama_pinjam+' Hari)</p>'+
                                '</div>'+
                                '<div class="col-sm-6 text-right">'+
                                    '<label class="text-sm " style="color:black; font-weight: bold; margin-bottom: 0rem;">Sub Total</label> '+
                                '</div>'+
                                '<div class="col-sm-6">'+
                                    '<p class="text-sm text-right" style="margin-bottom: 0.2rem;">'+formatRupiah(data[i].subtotal_sewa, 'Rp. ')+'</p>'+
                                '</div>'+
                                '<div class="col-sm-12">'+
                                    '<input type="hidden" class="sewa_list_tgl_sewa" name="sewa_list_tgl_sewa['+i+']" id="sewa_list_tgl_sewa'+i+'" value="'+data[i].tgl_sewa+'" />'+
                                    '<input type="hidden" class="sewa_list_kendaraan_id" name="sewa_list_kendaraan_id['+i+']" id="sewa_list_kendaraan_id'+i+'" value="'+data[i].kendaraan_id+'" />'+
                                    '<input type="hidden" class="sewa_list_userid" name="sewa_list_userid['+i+']" id="sewa_list_userid'+i+'" value="'+data[i].userid+'" />'+
                                    '<input type="hidden" class="sewa_list_detailid" name="sewa_list_detailid['+i+']" id="sewa_list_detailid'+i+'" value="'+data[i].detailid+'" />'+
                                    '<input type="hidden" class="sewa_list_nama_kendaraan" name="sewa_list_nama_kendaraan['+i+']" id="sewa_list_nama_kendaraan'+i+'" value="'+data[i].nama_kendaraan+'" />'+
                                    '<input type="hidden" class="sewa_list_photo" name="sewa_list_photo['+i+']" id="sewa_list_photo'+i+'" value="'+data[i].photo+'" />'+
                                    '<input type="hidden" class="sewa_list_tgl_pinjam" name="sewa_list_tgl_pinjam['+i+']" id="sewa_list_tgl_pinjam'+i+'" value="'+data[i].tgl_pinjam+'" />'+
                                    '<input type="hidden" class="sewa_list_tgl_kembali" name="sewa_list_tgl_kembali['+i+']" id="sewa_list_tgl_kembali'+i+'" value="'+data[i].tgl_kembali+'" />'+
                                    '<input type="hidden" class="sewa_list_lama_pinjam" name="sewa_list_lama_pinjam['+i+']" id="sewa_list_lama_pinjam'+i+'" value="'+data[i].lama_pinjam+'" />'+
                                    '<input type="hidden" class="sewa_list_harga_kendaraan" name="sewa_list_harga_kendaraan['+i+']" id="sewa_list_harga_kendaraan'+i+'" value="'+data[i].harga_kendaraan+'" />'+
                                    '<input type="hidden" class="sewa_list_subtotal_sewa" name="sewa_list_subtotal_sewa['+i+']" id="sewa_list_subtotal_sewa'+i+'" value="'+data[i].subtotal_sewa+'" />'+
                                    '<input type="hidden" class="sewa_list_status_sewa" name="sewa_list_status_sewa['+i+']" id="sewa_list_status_sewa'+i+'" value="'+data[i].status_sewa+'" />'+
                                    '<input type="hidden" class="sewa_list_status" name="sewa_list_status['+i+']" id="sewa_list_status'+i+'" value="'+data[i].status+'" />'+
                                '</div>'+
                            '</div>'+
                        '</td>'+
                        '<td style="vertical-align: middle;" class="text-center" width="10%">'+
                            '<a href="#" class="delete_row btn-danger btn-xs" id="delete_row'+i+'" ><i class="fas fa-trash"></i></a>'+
                        '</td>'+
                    '</tr>'
                );
               
            }
            
            $('#length_list').text($('#jumlah_data').val());
            $('#length_list2').text($('#jumlah_data').val());
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error show data');
        }
    });
}

$('#select_all').on('change', function() {
    var row = 0;
    grand_total = 0;
    uang_muka = 0;
    $('#grand_total').val(grand_total);
    $('#uang_muka').val(uang_muka);
    if ($(this).prop('checked')) {
        $('.data_ceklis').prop('checked','checked');
        $(this).val('y');
        row = $('#jumlah_data').val();
        for(i=0;i<=(row-1);i++){
            $('#data_ceklis'+i).prop('checked','checked');
            $('#delete_row'+i).hide();
            grand_total =  parseInt($('#grand_total').val()) + parseInt($('#sewa_list_subtotal_sewa'+i).val());
            uang_muka =  (grand_total * 30) / 100;
            $('#grand_total').val(grand_total);
            $('#grand_total2').text('Rp. '+formatRupiah($('#grand_total').val()));
            $('#uang_muka').val(uang_muka);
            $('#uang_muka2').text('Rp. '+formatRupiah($('#uang_muka').val())+' (Uang Muka 30%)');
        }

    } else {
        $('.data_ceklis').prop('checked', false);
        $(this).val('n');
        row = $('#jumlah_data').val();
        for(i=0;i<=(row-1);i++){
            $('.data_ceklis').prop('checked', false);
            $('#delete_row'+i).show();
        }
        $('#grand_total').val(grand_total);
        $('#grand_total2').text('Rp. '+formatRupiah($('#grand_total').val()));
        $('#uang_muka').val(uang_muka);
        $('#uang_muka2').text('Rp. '+formatRupiah($('#uang_muka').val())+' (Uang Muka 30%)');
    }
});

function CheckMyValue(i) {
    grand_total = 0;
    uang_muka = 0;
    if ($('#data_ceklis'+i).prop('checked')){
        $('#data_ceklis'+i).prop('checked','checked');
        $('#delete_row'+i).hide();
        grand_total =  parseInt($('#grand_total').val()) + parseInt($('#sewa_list_subtotal_sewa'+i).val());
        uang_muka =  (grand_total * 30) / 100;
        $('#grand_total').val(grand_total);
        $('#grand_total2').text('Rp. '+formatRupiah($('#grand_total').val()));
        $('#uang_muka').val(uang_muka);
        $('#uang_muka2').text('Rp. '+formatRupiah($('#uang_muka').val())+' (Uang Muka 30%)');
    } else {
        $('#data_ceklis'+i).prop('checked', false);
        $('#delete_row'+i).show();
        grand_total =  parseInt($('#grand_total').val()) - parseInt($('#sewa_list_subtotal_sewa'+i).val());
        uang_muka =  (grand_total * 30) / 100;
        $('#grand_total').val(grand_total);
        $('#grand_total2').text('Rp. '+formatRupiah($('#grand_total').val()));
        $('#uang_muka').val(uang_muka);
        $('#uang_muka2').text('Rp. '+formatRupiah($('#uang_muka').val())+' (Uang Muka 30%)');
    }
}

function history_sewa() {
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-history_sewa').modal('show');
    $('.modal-title-form-history_sewa').text('Riwayat Sewa');
    get_list_sewa_header_not_cancel();
}

function get_list_sewa_header_not_cancel() {
    Swal.fire({
        title: '',
        html: '<div class="spinner-grow text-dark text-center" style="width: 3rem; height: 3rem;" role="status"> <span class="sr-only">Loading...</span> </div> <br> Loading...',
        showCancelButton: false,
        showConfirmButton: false,
    });
    Swal.close();
    $.ajax({
        url: "<?php echo site_url('sewa_kendaraan/get_list_sewa_header_not_cancel'); ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#item-list').empty();
            var sewa = {}, groupBy = "sewa_id";
            var status_uang_muka = '';
            var bts_byr = '';
            var sisa_pembayaran = 0;

            for (var i = 0; i < data.length; i++) {
                if (!sewa[data[i][groupBy]])
                    sewa[data[i][groupBy]] = [];
                    sewa[data[i][groupBy]].push(data[i]);
            };

            for (key in sewa) {
                if (sewa.hasOwnProperty(key)) {
                    // console.log(key);
                    
                    $('#item-list').append(
                        '<div class="card text-center" style="margin-bottom: 0.2rem;"id="headingOne'+key+'">'+
                            '<h5>'+
                                '<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne'+key+'" aria-expanded="true" aria-controls="collapseOne'+key+'">'+
                                    '<label class="text-white text-center">No. Tiket '+key+'</label> <br>'+
                                    '<label class="text-white text-center grand_total'+key+'"> </label><br>'+
                                    '<label class="text-white text-center text-xs status_uang_muka'+key+'"> </label><br>'+
                                    '<div id="bts_byr'+key+'">'+
                                    '</div>'+
                                '</button>'+
                            '</h5>'+
                        '</div>'+
                        '<div>'+
                            '<div id="collapseOne'+key+'" class="collapse" aria-labelledby="headingOne'+key+'" data-parent="#accordion">'+
                                '<div style="padding: 0.3rem 1rem;">'+
                                    '<a href="javascript:void(0);" class="bayar_lunas" data-sewa_id="'+key+'" id="bayar_lunas'+key+'"></a>'+
                                '</div>'+
                                '<div class="card-body" id="item-list-dtl'+key+'" style="padding-top: 0rem !important">'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );
                    if (sewa[key].length){
                        for (var i = 0; i < sewa[key].length; i++) {
                            // console.log(sewa[key][i].nama_kendaraan);
                            $('#item-list-dtl'+sewa[key][i].sewa_id).append(
                                '<div class="row">'+
                                    '<div class="col-sm-12 border">'+
                                        '<label class="text-sm" style="color:black; font-weight: bold;">'+sewa[key][i].sewa_id+'-'+sewa[key][i].detailid+'</label> <br>'+
                                        '<p><b>Nama Kendaraan      : </b>'+sewa[key][i].nama_kendaraan+'</p>'+
                                        '<p><b>Merk Kendaraan      : </b>'+sewa[key][i].merk_kendaraan+'</p>'+
                                        '<p><b>Kapasitas Kendaraan : </b>'+sewa[key][i].kapasitas_kendaraan+'Siet </p>'+
                                        '<p><b>Tanggal Sewa : </b>'+sewa[key][i].tgl_pinjam+' - '+sewa[key][i].tgl_kembali+'('+sewa[key][i].lama_pinjam+' Hari)</p>'+
                                        '<p><b>Titik Jemput : </b>'+sewa[key][i].titik_jemput+'</p>'+
                                    '</div>'+
                                '</div>'
                            );

                            $('.grand_total'+sewa[key][i].sewa_id).text(formatRupiah(sewa[key][i].grand_total, 'Rp. '));
                            // $('.batas_pembayaran'+sewa[key][i].sewa_id).text('');
                            $('#bayar_lunas'+sewa[key][i].sewa_id).html('');
                            $('#bts_byr'+sewa[key][i].sewa_id).html('');

                            sisa_pembayaran = parseInt(sewa[key][i].grand_total) - parseInt(sewa[key][i].uang_muka);

                            if (sewa[key][i].status_pembayaran == 'uang_muka' && sewa[key][i].statusUangMuka == 'y') {
                                $('#headingOne'+sewa[key][i].sewa_id).removeClass('bg-secondary');
                                $('#headingOne'+sewa[key][i].sewa_id).addClass('bg-danger');
                                $('.status_uang_muka'+sewa[key][i].sewa_id).html('(Segera Lunasi!!, Sisa Pembayaran '+formatRupiah(sisa_pembayaran.toString(), 'Rp. ')+')');
                            
                                $('#bts_byr'+sewa[key][i].sewa_id).html('<label class="text-white text-center text-xs batas_pembayaran'+sewa[key][i].sewa_id+'"> Batas Pembayaran Tanggal '+sewa[key][i].tgl_pinjam_min_1+'</label>');
                                $('#bayar_lunas'+sewa[key][i].sewa_id).html('<h6>Lunasi Sekarang?</h6>');

                            } else if (sewa[key][i].status_pembayaran == 'uang_muka' && sewa[key][i].statusUangMuka == 'n') {
                                $('.status_uang_muka'+sewa[key][i].sewa_id).html('(Menunggu Verifikasi Uang Muka)');
                                $('#headingOne'+sewa[key][i].sewa_id).addClass('bg-secondary');
                            }

                            if (sewa[key][i].status_pembayaran == 'pelunasan' && sewa[key][i].statusPelunasan == 'y') {
                                $('#headingOne'+sewa[key][i].sewa_id).removeClass('bg-secondary');
                                $('#headingOne'+sewa[key][i].sewa_id).addClass('bg-success'); 
                                $('.status_uang_muka'+sewa[key][i].sewa_id).html('(Pembayaran Sudah Lunas, anda akan di jemput tanggal '+sewa[key][i].tgl_pinjam_min+', <br> Mobil = '+sewa[key][i].plat_nomer+', <br> Nama Supir = '+sewa[key][i].nama_supir+')');
                            } else if (sewa[key][i].status_pembayaran == 'pelunasan' && sewa[key][i].statusPelunasan == 'n') {
                                $('.status_uang_muka'+sewa[key][i].sewa_id).html('(Menunggu Verifikasi Pelunasan)');
                                $('#headingOne'+sewa[key][i].sewa_id).addClass('bg-gray-dark');
                            }
                        }
                    }
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error show data');
        }
    });
}

$('#item-list').on('click', '.bayar_lunas', function() {
    save_method = 'bayar_lunas';
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-bayar_lunas').modal('show');
    $('.modal-title-form-bayar_lunas').html('<label>Bayar Lunas ['+$(this).data('sewa_id')+']</label>');
    $('[name="sewa_id_pelunasan"]').val($(this).data('sewa_id'));
});

$('#table2 tbody').on('click', '.delete_row', function() {
    var tgl_sewa = $(this).parents("tr").find(".sewa_list_tgl_sewa").val();
    var kendaraan_id = $(this).parents("tr").find(".sewa_list_kendaraan_id").val();
    var userid = $(this).parents("tr").find(".sewa_list_userid").val();
    var detailid = $(this).parents("tr").find(".sewa_list_detailid").val();
    $.ajax({
        url: "<?php echo site_url('sewa_kendaraan/cancel'); ?>",
        type: "POST",
        dataType: "JSON",
        data: {
            tgl_sewa: tgl_sewa, 
            kendaraan_id: kendaraan_id, 
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
                get_list_sewa_summary();
                $('#length_list').text($('#jumlah_data').val());
                $('#length_list2').text($('#jumlah_data').val());
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error nonaktif data');
        }
    });
});

function save() {
    $('#btnSaveApp').text('Saving...');
    $('#btnSaveApp').attr('disabled', true);
    if (save_method == "add_to_cart") {
        url = 'sewa_kendaraan/add_to_cart';
        var formData = new FormData($('#form-sewa')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#modal-form-sewa').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Berhasil di tambahkan ke keranjang...',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        get_list_kendaraan('');
                        $('#modal-form-sewa').modal('hide');
                        get_list_sewa_summary();
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
        url = 'sewa_kendaraan/add_checkout';
        var formData = new FormData($('#form-sewa_list')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#modal-form-sewa_list').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil disimpan...',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        $('#modal-form-sewa_list').modal('hide');
                        Swal.close();
                        get_list_sewa_summary();
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
    } else if (save_method == "bayar_lunas") {
        url = 'sewa_kendaraan/bayar_lunas';
        var formData = new FormData($('#form-bayar_lunas')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#modal-form-bayar_lunas').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil disimpan...',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        $('#modal-form-bayar_lunas').modal('hide');
                        Swal.close();
                        get_list_sewa_summary();
                        get_list_sewa_header_not_cancel();
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