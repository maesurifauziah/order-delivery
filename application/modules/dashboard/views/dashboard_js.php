<script>
    var base_url = "<?php echo base_url();?>";
    $(document).ready(function() {
        get_list_barang_top3('');

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

            
            if (parseInt($('#quantity').val()) >= 20) {
                bonus = parseInt($('#harga_total').val()) / 100;
            } else {
                bonus = 0;
            }
            $('#bonus').val(bonus)
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

                if (parseInt($('#quantity').val()) >= 20) {
                    bonus = parseInt($('#harga_total').val()) / 100;
                } else {
                    bonus = 0;
                }
                $('#bonus').val(bonus)
            }
        });
        
        let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
        if (isMobile) {
            $('.promo').html(
                '<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">'+
                    '<ol class="carousel-indicators">'+
                        '<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>'+
                        '<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>'+
                        '<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>'+
                    '</ol>'+
                    '<div class="carousel-inner promo2">'+
                    '</div>'+
                    '<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">'+
                        '<span class="carousel-control-prev-icon" aria-hidden="true"></span>'+
                        '<span class="sr-only">Previous</span>'+
                    '</a>'+
                    '<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">'+
                        '<span class="carousel-control-next-icon" aria-hidden="true"></span>'+
                        '<span class="sr-only">Next</span>'+
                    '</a>'+
                '</div>'
            );
            $('.promo2').append(
            ' <div class="carousel-item active">'+
                    '<img class="img-fluid w-100" src="'+base_url+'upload/dummy/promo1.jpeg" alt="Promo 1">'+
                '</div>'+
                '<div class="carousel-item">'+
                    '<img class="img-fluid w-100" src="'+base_url+'upload/dummy/promo2.jpeg" alt="Promo 2">'+
                '</div>'+
                '<div class="carousel-item">'+
                    '<img class="img-fluid w-100" src="'+base_url+'upload/dummy/promo3.jpeg" alt="Promo 3">'+
                '</div>'
            );
            $('.carousel').carousel({
                interval: 2000
            });
            $('.lyt-content').removeClass('content-wrapper');
        } else {
            $('.promo').html(
            ' <div class="row">'+
                    '<div class="col-4">'+
                        '<img class="img-fluid w-100" src="'+base_url+'upload/dummy/promo1.jpeg" alt="Promo 1">'+
                    '</div>'+
                    '<div class="col-4">'+
                        '<img class="img-fluid w-100" src="'+base_url+'upload/dummy/promo2.jpeg" alt="Promo 1">'+
                    '</div>'+
                    '<div class="col-4">'+
                        '<img class="img-fluid w-100" src="'+base_url+'upload/dummy/promo3.jpeg" alt="Promo 1">'+
                    '</div>'+
                '</div>'
            );
            $('.lyt-content').addClass('content-wrapper');
        }

    });

function get_list_barang_top3(searchTerm) {
    $.ajax({
        url: "<?php echo site_url('order/get_list_barang_top3?searchTerm='); ?>"+searchTerm,
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

$('.product').on('click', '#order_redirect', function() {
    loadPage('order')
});

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
        
        if (parseInt($('#quantity').val()) >= 20) {
            bonus = parseInt($('#harga_total').val()) / 100;
        } else {
            bonus = 0;
        }
        $('#bonus').val(bonus)
    });

    $('#photo').show();
    $('#btnSaveApp').show();
    
});
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
$("#satuan_jual").on('change', function () {
    $(this).next().val($(this).find('option:selected').val());
    var string = $(this).next().val().toString();
    var explode = string.split("-");
    $(this).next().next().val(explode[0]);
    $(this).next().next().next().val(explode[1]);
  
    $('#harga_total').val(parseInt($('#quantity').val()) * explode[1]);
    $('#label_total').text(formatRupiah($('#harga_total').val(),'Rp.'));
    
    if (isNaN($("#harga_total").val())){
        $("#label_total").text("Rp. 0");
        $("#harga_total").val(0);
    }
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
                        get_list_barang('');
                        $('#modal-form-order').modal('hide');
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
    } 
    
}
</script>