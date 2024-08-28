<script>
var table_master_kendaraan;
var save_method;
$(document).ready(function() {
    //datatables
    table_master_kendaraan = $('#table1').DataTable({
        "footerCallback": function(row, data, start, end, display) {
            var api = this.api(),
                data;

            // Remove the formatting to get integer data for summation
            var intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };
        },
        dom: 'lBfrtip',
        lengthMenu: [
            [10, 25, 50, 100, -1],
            ['10', '25', '50', '100', 'All']
        ],
        buttons: ['print','copyHtml5','excelHtml5','csvHtml5','pdfHtml5','colvis'],
        autoWidth: false,
        processing: true,
        serverSide: true,
        scrollY: '25vh',
        scrollX: true,
        destroy: true,
        scrollCollapse: true,
        select: true,
        responsive: false,
        order: [], //Initial no order.
        ordering: true,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: "<?php echo site_url('master_kendaraan/master_kendaraan_list'); ?>",
            type: "POST",
            data: function(data) {}
        },
        //Set column definition initialisation properties.
        columnDefs: [{
            targets: [0,5,6], //first column / numbering column
            orderable: false, //set not orderable
        }, ], 
    }); 
    
    $("#filter_status").select2();

    let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
    if (isMobile) {
        $('.lyt-content').removeClass('content-wrapper');
    } else {
        $('.lyt-content').addClass('content-wrapper');
    }
});

$('#filter').on('click', function() {
    table_master_kendaraan.ajax.url("master_kendaraan/master_kendaraan_list?oid=" + $('#filter_kantor').val()+"&status=" + $('#filter_status').val()).load();
});

function add_form() {
    save_method = 'add';
    $('#form-master_kendaraan')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-master_kendaraan').modal('show');
    $('.modal-title-form-master_kendaraan').text('Add Barang');

    $('[name="kendaraan_id"]').attr('readonly', false);
    $('[name="photo_name"]').attr('readonly', false);
    $('[name="bensin_kendaraan"]').attr('readonly', false);
    $('[name="photo"]').attr('disabled', false);
    $('[name="nama_kendaraan"]').attr('readonly', false);
    $('[name="merk_kendaraan"]').attr('readonly', false);
    $('[name="deskripsi_kendaraan"]').attr('readonly', false);
    $('[name="tahun_kendaraan"]').attr('readonly', false);
    $('[name="kapasitas_kendaraan"]').attr('disabled', false);
    $('[name="harga_kendaraan"]').attr('readonly', false);
    $('[name="warna_kendaraan"]').attr('readonly', false);
    $('[name="no_polisi"]').attr('readonly', false);

    $('#photo-preview div').text('(No photo)');
    
	$('[name="kendaraan_id"]').removeClass('is-invalid');
    $('.help-block-kendaraan_id').addClass('text-danger').text('');
	$('[name="photo_name"]').removeClass('is-invalid');
    $('.help-block-photo_name').addClass('text-danger').text('');
	$('[name="bensin_kendaraan"]').removeClass('is-invalid');
    $('.help-block-bensin_kendaraan').addClass('text-danger').text('');
	$('[name="photo"]').removeClass('is-invalid');
    $('.help-block-photo').addClass('text-danger').text('');
	$('[name="nama_kendaraan"]').removeClass('is-invalid');
    $('.help-block-nama_kendaraan').addClass('text-danger').text('');
	$('[name="merk_kendaraan"]').removeClass('is-invalid');
    $('.help-block-merk_kendaraan').addClass('text-danger').text('');
	$('[name="deskripsi_kendaraan"]').removeClass('is-invalid');
    $('.help-block-deskripsi_kendaraan').addClass('text-danger').text('');
	$('[name="tahun_kendaraan"]').removeClass('is-invalid');
    $('.help-block-tahun_kendaraan').addClass('text-danger').text('');
	$('[name="kapasitas_kendaraan"]').removeClass('is-invalid');
    $('.help-block-kapasitas_kendaraan').addClass('text-danger').text('');
	$('[name="harga_kendaraan"]').removeClass('is-invalid');
    $('.help-block-harga_kendaraan').addClass('text-danger').text('');
	$('[name="warna_kendaraan"]').removeClass('is-invalid');
    $('.help-block-warna_kendaraan').addClass('text-danger').text('');
	$('[name="no_polisi"]').removeClass('is-invalid');
    $('.help-block-no_polisi').addClass('text-danger').text('');


    $('#photo').show();
	
    $('#btnSaveApp').show();
} 

$('#table1').on('click', '.edit_record', function() {
    save_method = 'update';
    $('#form-master_kendaraan')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-master_kendaraan').modal('show');
    $('.modal-title-form-master_kendaraan').text('Edit Barang');

    $('[name="kendaraan_id"]').val($(this).data('kendaraan_id'));
    $('[name="photo_name"]').val($(this).data('photo_name'));
    $('[name="bensin_kendaraan"]').val($(this).data('bensin_kendaraan'));
    $('[name="nama_kendaraan"]').val($(this).data('nama_kendaraan'));
    $('[name="merk_kendaraan"]').val($(this).data('merk_kendaraan'));
    $('[name="deskripsi_kendaraan"]').val($(this).data('deskripsi_kendaraan'));
    $('[name="tahun_kendaraan"]').val($(this).data('tahun_kendaraan'));
    $('[name="kapasitas_kendaraan"]').val($(this).data('kapasitas_kendaraan'));
    $('[name="harga_kendaraan"]').val(formatRupiah($(this).data('harga_kendaraan').toString()));
    $('[name="warna_kendaraan"]').val($(this).data('warna_kendaraan'));
    $('[name="no_polisi"]').val($(this).data('no_polisi'));
   
    if($(this).data('photo'))
    {
        $('#photo-preview div').html('<img src="'+$(this).data('path_photo')+'" class="img-responsive" style="width: 100%; max-width: 400px; height: auto;">'); // show photo
        $('#photo-preview div').append('<span id="label_remove_photo"><input type="checkbox" name="remove_photo" id="remove_photo" value="n" /> Remove</span>'); // remove photo
        $('#remove_photo').on('change', function() {
            $('#label_remove_photo').show();
            if ($(this).prop('checked')) {
                $(this).val('y');
            } else {
                $(this).val('n');
            }
        });
    }
    else
    {
        $('#photo-preview div').text('(No photo)');
    }

    $('[name="kendaraan_id"]').attr('readonly', false);
    $('[name="photo_name"]').attr('readonly', false);
    $('[name="bensin_kendaraan"]').attr('readonly', false);
    $('[name="photo"]').attr('disabled', false);
    $('[name="nama_kendaraan"]').attr('readonly', false);
    $('[name="merk_kendaraan"]').attr('readonly', false);
    $('[name="deskripsi_kendaraan"]').attr('readonly', false);
    $('[name="tahun_kendaraan"]').attr('readonly', false);
    $('[name="kapasitas_kendaraan"]').attr('disabled', false);
    $('[name="harga_kendaraan"]').attr('readonly', false);
    $('[name="warna_kendaraan"]').attr('readonly', false);
    $('[name="no_polisi"]').attr('readonly', false);
    
	$('[name="kendaraan_id"]').removeClass('is-invalid');
    $('.help-block-kendaraan_id').addClass('text-danger').text('');
	$('[name="photo_name"]').removeClass('is-invalid');
    $('.help-block-photo_name').addClass('text-danger').text('');
	$('[name="bensin_kendaraan"]').removeClass('is-invalid');
    $('.help-block-bensin_kendaraan').addClass('text-danger').text('');
	$('[name="photo"]').removeClass('is-invalid');
    $('.help-block-photo').addClass('text-danger').text('');
	$('[name="nama_kendaraan"]').removeClass('is-invalid');
    $('.help-block-nama_kendaraan').addClass('text-danger').text('');
	$('[name="merk_kendaraan"]').removeClass('is-invalid');
    $('.help-block-merk_kendaraan').addClass('text-danger').text('');
	$('[name="deskripsi_kendaraan"]').removeClass('is-invalid');
    $('.help-block-deskripsi_kendaraan').addClass('text-danger').text('');
	$('[name="tahun_kendaraan"]').removeClass('is-invalid');
    $('.help-block-tahun_kendaraan').addClass('text-danger').text('');
	$('[name="kapasitas_kendaraan"]').removeClass('is-invalid');
    $('.help-block-kapasitas_kendaraan').addClass('text-danger').text('');
	$('[name="harga_kendaraan"]').removeClass('is-invalid');
    $('.help-block-harga_kendaraan').addClass('text-danger').text('');
	$('[name="warna_kendaraan"]').removeClass('is-invalid');
    $('.help-block-warna_kendaraan').addClass('text-danger').text('');
	$('[name="no_polisi"]').removeClass('is-invalid');
    $('.help-block-no_polisi').addClass('text-danger').text('');

    $('#photo').show();

    $('#btnSaveApp').show();
    
});

$('#table1').on('click', '.view_record', function() {
    save_method = 'update';
    $('#form-master_kendaraan')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-master_kendaraan').modal('show');
    $('.modal-title-form-master_kendaraan').text('View Barang');
    
    $('[name="kendaraan_id"]').val($(this).data('kendaraan_id'));
    $('[name="photo_name"]').val($(this).data('photo_name'));
    $('[name="bensin_kendaraan"]').val($(this).data('bensin_kendaraan'));
    $('[name="nama_kendaraan"]').val($(this).data('nama_kendaraan'));
    $('[name="merk_kendaraan"]').val($(this).data('merk_kendaraan'));
    $('[name="deskripsi_kendaraan"]').val($(this).data('deskripsi_kendaraan'));
    $('[name="tahun_kendaraan"]').val($(this).data('tahun_kendaraan'));
    $('[name="kapasitas_kendaraan"]').val($(this).data('kapasitas_kendaraan'));
    $('[name="harga_kendaraan"]').val(formatRupiah($(this).data('harga_kendaraan').toString()));
    $('[name="warna_kendaraan"]').val($(this).data('warna_kendaraan'));
    $('[name="no_polisi"]').val($(this).data('no_polisi'));
   
    if($(this).data('photo'))
    {
        $('#photo-preview div').html('<img src="'+$(this).data('path_photo')+'" class="img-responsive" style="width: 100%; max-width: 400px; height: auto;">'); // show photo
        $('#remove_photo').on('change', function() {
            $('#label_remove_photo').hide();
            if ($(this).prop('checked')) {
                $(this).val('y');
            } else {
                $(this).val('n');
            }
        });
    }
    else
    {
        $('#photo-preview div').text('(No photo)');
    }
   
    $('[name="kendaraan_id"]').attr('readonly', true);
    $('[name="photo_name"]').attr('readonly', true);
    $('[name="bensin_kendaraan"]').attr('readonly', true);
    $('[name="photo"]').attr('disabled', true);
    $('[name="nama_kendaraan"]').attr('readonly', true);
    $('[name="merk_kendaraan"]').attr('readonly', true);
    $('[name="deskripsi_kendaraan"]').attr('readonly', true);
    $('[name="tahun_kendaraan"]').attr('readonly', true);
    $('[name="kapasitas_kendaraan"]').attr('disabled', true);
    $('[name="harga_kendaraan"]').attr('readonly', true);
    $('[name="warna_kendaraan"]').attr('readonly', true);
    $('[name="no_polisi"]').attr('readonly', true);
    
	$('[name="kendaraan_id"]').removeClass('is-invalid');
    $('.help-block-kendaraan_id').addClass('text-danger').text('');
	$('[name="photo_name"]').removeClass('is-invalid');
    $('.help-block-photo_name').addClass('text-danger').text('');
	$('[name="bensin_kendaraan"]').removeClass('is-invalid');
    $('.help-block-bensin_kendaraan').addClass('text-danger').text('');
	$('[name="photo"]').removeClass('is-invalid');
    $('.help-block-photo').addClass('text-danger').text('');
	$('[name="nama_kendaraan"]').removeClass('is-invalid');
    $('.help-block-nama_kendaraan').addClass('text-danger').text('');
	$('[name="merk_kendaraan"]').removeClass('is-invalid');
    $('.help-block-merk_kendaraan').addClass('text-danger').text('');
	$('[name="deskripsi_kendaraan"]').removeClass('is-invalid');
    $('.help-block-deskripsi_kendaraan').addClass('text-danger').text('');
	$('[name="tahun_kendaraan"]').removeClass('is-invalid');
    $('.help-block-tahun_kendaraan').addClass('text-danger').text('');
	$('[name="kapasitas_kendaraan"]').removeClass('is-invalid');
    $('.help-block-kapasitas_kendaraan').addClass('text-danger').text('');
	$('[name="harga_kendaraan"]').removeClass('is-invalid');
    $('.help-block-harga_kendaraan').addClass('text-danger').text('');
	$('[name="warna_kendaraan"]').removeClass('is-invalid');
    $('.help-block-warna_kendaraan').addClass('text-danger').text('');
	$('[name="no_polisi"]').removeClass('is-invalid');
    $('.help-block-no_polisi').addClass('text-danger').text('');

    $('#photo').hide();
    
    $('#btnSaveApp').hide();
});

$('input.number-separator').keyup(function(event) {
    if (/^[0-9.,]+$/.test($(this).val())) {
        $(this).val(
            formatRupiah($(this).val())
        );
        } else {
        $(this).val(
            $(this)
            .val()
            .substring(0, $(this).val().length - 1)
        );
        }
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

$('#table1').on('click', '.nonactive_record', function() {
    var kendaraan_id = $(this).data('kendaraan_id');
    var nama_kendaraan = $(this).data('nama_kendaraan');
    Swal.fire({
        icon: 'warning',
        title: 'Are You Sure?',
        text: 'Non Active [' + kendaraan_id + '] '+ nama_kendaraan,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('master_kendaraan/nonactive'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    kendaraan_id: kendaraan_id
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil dinonavtive',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        table_master_kendaraan.ajax.reload();
                        Swal.close();
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error nonaktif data');
                }
            });
        }
    });
});

$('#table1').on('click', '.reactive_record', function() {
    var kendaraan_id = $(this).data('kendaraan_id');
    var nama_kendaraan = $(this).data('nama_kendaraan');
    Swal.fire({
        icon: 'warning',
        title: 'Are You Sure?',
        text: 'Active [' + kendaraan_id + '] '+ nama_kendaraan,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('master_kendaraan/reactive'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    kendaraan_id: kendaraan_id
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil direactive',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        table_master_kendaraan.ajax.reload();
                        Swal.close();
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error nonaktif data');
                }
            });
        }
    });
});

function generate_template() {
    Swal.fire({
        title: '',
        html: '<div class="spinner-border text-primary text-center" style="width: 3rem; height: 3rem;" role="status"> <span class="sr-only">Loading...</span> </div> <br> Please Wait...',
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: false,
    });
    $.ajax({
        url: "<?php echo site_url('master_kendaraan/generate'); ?>",
        type: 'POST',
        data: {},
        dataType: 'JSON'
    }).done(function(data) {
        var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", "master_kendaraan.xlsx");
            $a[0].click();
            $a.remove();
            Swal.close();
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Export data'
            }).then(function() {
                Swal.close();
            });
    });
}
function import_template() {
    $('#form-import-master_kendaraan')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-import-master_kendaraan').modal('show');
    $('.modal-title-import-master_kendaraan').text('Import Data');
    $('#btnSave').show();
}

function importUpload() {
    var url = "<?php echo site_url('master_kendaraan/import'); ?>";
    var formData = new FormData($('#form-import-master_kendaraan')[0]);
    url =
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Data Success saved...',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        Swal.close();
                        // $('#file_excel').val('');
                        table_master_kendaraan.ajax.reload();
                        $('#modal-import-master_kendaraan').modal('hide');
                    });
                } else {
                    if (data.msg) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning!',
                            text: data.msg,
                            showConfirmButton: true
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning!',
                            text: 'Choose file cannot be empty!!!',
                            showConfirmButton: true
                        }).then(function() {
                            Swal.close();
                        });
                    }

                }
              
            },
            error: function(result) {
                // $('#modal-import-stock-error').modal('show');
                // $('#responseText').html(result.responseText);
                Swal.fire({
                    icon: 'warning',
                    title: 'Error!',
                    text: 'Import data error!!!',
                    showConfirmButton: true
                });
                
            }
        });
}

function save() {
    $('#btnSaveApp').text('Saving...');
    $('#btnSaveApp').attr('disabled', true);
    if (save_method == "add") {
        url = 'master_kendaraan/add';
    } else {
        url = 'master_kendaraan/update';
    }
    var formData = new FormData($('#form-master_kendaraan')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $('#modal-form-master_kendaraan').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Data berhasil disimpan...',
                    timer: 2000,
                    showCancelButton: false,
                    showConfirmButton: false
                }).then(function() {
                    table_master_kendaraan.ajax.reload();
                    $('#modal-form-master_kendaraan').modal('hide');
                    Swal.close();
                });
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                    $('.help-block-' + data.inputerror[i]).addClass('text-danger').text(data
                        .error_string[i]);
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





</script>