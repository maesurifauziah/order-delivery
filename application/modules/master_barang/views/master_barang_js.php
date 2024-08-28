<script>
var table_master_barang;
var save_method;
var base_url = '<?php echo base_url();?>';
$(document).ready(function() {
    //datatables
    table_master_barang = $('#table1').DataTable({
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
        scrollY: '45vh',
        scrollX: true,
        destroy: true,
        scrollCollapse: true,
        select: true,
        responsive: true,
        order: [], //Initial no order.
        ordering: true,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: "<?php echo site_url('master_barang/master_barang_list?kategori_id='); ?>" + $('#filter_kategori_id').val()+"&status=" + $('#filter_status').val(),
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
    $("#filter_kategori_id").select2();

    let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
    if (isMobile) {
        $('.lyt-content').removeClass('content-wrapper');
    } else {
        $('.lyt-content').addClass('content-wrapper');
    }
    
});

$('#filter').on('click', function() {
    table_master_barang.ajax.url("master_barang/master_barang_list?kategori_id=" + $('#filter_kategori_id').val()+"&status=" + $('#filter_status').val()).load();
});

$('#kategori_id').select2();

function add_form() {
    save_method = 'add';
    $('#form-master_barang')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-master_barang').modal('show');
    $('.modal-title-form-master_barang').text('Add Barang');

    $('[name="kode_barang"]').attr('readonly', false);
    $('[name="nama_barang"]').attr('readonly', false);
    $('[name="kategori_id"]').attr('disabled', false);
    $('[name="photo_name"]').attr('readonly', false);
    $('[name="photo"]').attr('readonly', false);
    $('[name="harga_beli"]').attr('readonly', false);
    $('[name="harga_jual"]').attr('readonly', false);
    $('[name="satuan"]').attr('readonly', false);
    $('[name="keterangan"]').attr('readonly', false);

    
    $('#photo-preview div').text('(No photo)');
    
	$('[name="kode_barang"]').removeClass('is-invalid');
    $('.help-block-kode_barang').addClass('text-danger').text('');
	$('[name="photo_name"]').removeClass('is-invalid');
    $('.help-block-photo_name').addClass('text-danger').text('');
	$('[name="nama_barang"]').removeClass('is-invalid');
    $('.help-block-nama_barang').addClass('text-danger').text('');
	$('[name="photo"]').removeClass('is-invalid');
    $('.help-block-photo').addClass('text-danger').text('');
	$('[name="harga_beli"]').removeClass('is-invalid');
    $('.help-block-harga_beli').addClass('text-danger').text('');
	$('[name="harga_jual"]').removeClass('is-invalid');
    $('.help-block-harga_jual').addClass('text-danger').text('');
	$('[name="satuan"]').removeClass('is-invalid');
    $('.help-block-sat').addClass('text-danger').text('');
	$('[name="keterangan"]').removeClass('is-invalid');
    $('.help-block-keterangan').addClass('text-danger').text('');
    $('[name="kategori_id"]').removeClass('is-invalid');
    $('.help-block-kategori_id').addClass('text-danger').text('');
	
	$('#kategori_id').select2().next().show();
    $('#photo').show();
    $('#btnSaveApp').show();
} 

$('#table1').on('click', '.edit_record', function() {
    save_method = 'update';
    $('#form-master_barang')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-master_barang').modal('show');
    $('.modal-title-form-master_barang').text('Edit Barang');

    $('[name="kode_barang"]').val($(this).data('kode_barang'));
    $('[name="nama_barang"]').val($(this).data('nama_barang'));
    $('[name="harga_beli"]').val($(this).data('harga_beli'));
    $('[name="harga_jual"]').val($(this).data('harga_jual'));
    $('[name="satuan"]').val($(this).data('satuan'));
    $('[name="keterangan"]').val($(this).data('keterangan'));
    $('[name="photo_name"]').val($(this).data('photo'));
    $('[name="kategori_id"]').val($(this).data('kategori_id'));
    
    if($(this).data('photo'))
    {
        $('#photo-preview div').html('<img src="'+$(this).data('path_photo')+'" class="img-responsive" style="width: 50%; max-width: 400px; height: auto;">'); // show photo
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

    $('[name="kode_barang"]').attr('readonly', false);
    $('[name="photo_name"]').attr('readonly', false);
    $('[name="nama_barang"]').attr('readonly', false);
    $('[name="photo"]').attr('readonly', false);
    $('[name="harga_beli"]').attr('readonly', false);
    $('[name="harga_jual"]').attr('readonly', false);
    $('[name="satuan"]').attr('readonly', false);
    $('[name="keterangan"]').attr('readonly', false);
    $('[name="kategori_id"]').attr('disabled', false);

	$('[name="kode_barang"]').removeClass('is-invalid');
    $('.help-block-kode_barang').addClass('text-danger').text('');
	$('[name="photo_name"]').removeClass('is-invalid');
    $('.help-block-photo_name').addClass('text-danger').text('');
	$('[name="nama_barang"]').removeClass('is-invalid');
    $('.help-block-nama_barang').addClass('text-danger').text('');
	$('[name="photo"]').removeClass('is-invalid');
    $('.help-block-photo').addClass('text-danger').text('');
	$('[name="harga_beli"]').removeClass('is-invalid');
    $('.help-block-harga_beli').addClass('text-danger').text('');
	$('[name="harga_jual"]').removeClass('is-invalid');
    $('.help-block-harga_jual').addClass('text-danger').text('');
	$('[name="satuan"]').removeClass('is-invalid');
    $('.help-block-sat').addClass('text-danger').text('');
    $('[name="kategori_id"]').removeClass('is-invalid');
    $('.help-block-kategori_id').addClass('text-danger').text('');
    $('[name="keterangan"]').removeClass('is-invalid');
    $('.help-block-keterangan').addClass('text-danger').text('');

    $('#kategori_id').select2().next().show();
    $('#photo').show();
    $('#btnSaveApp').show();
    
});



$('#table1').on('click', '.view_record', function() {
    save_method = 'update';
    $('#form-master_barang')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-master_barang').modal('show');
    $('.modal-title-form-master_barang').text('View Barang');
    $('[name="kode_barang"]').val($(this).data('kode_barang'));
    $('[name="nama_barang"]').val($(this).data('nama_barang'));
    $('[name="harga_beli"]').val($(this).data('harga_beli'));
    $('[name="harga_jual"]').val($(this).data('harga_jual'));
    $('[name="satuan"]').val($(this).data('satuan'));
    $('[name="photo_name"]').val($(this).data('photo'));
    $('[name="kategori_id"]').val($(this).data('kategori_id'));
    $('[name="keterangan"]').val($(this).data('keterangan'));

    if($(this).data('photo'))
    {
        $('#photo-preview div').html('<img src="'+$(this).data('path_photo')+'" class="img-responsive" style="width: 50%; max-width: 400px; height: auto;">'); // show photo
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
   

    $('[name="kode_barang"]').attr('readonly', true);
    $('[name="photo_name"]').attr('readonly', true);
    $('[name="nama_barang"]').attr('readonly', true);
    $('[name="photo"]').attr('readonly', true);
    $('[name="harga_beli"]').attr('readonly', true);
    $('[name="harga_jual"]').attr('readonly', true);
    $('[name="satuan"]').attr('readonly', true);
    $('[name="keterangan"]').attr('readonly', true);
    $('[name="kategori_id"]').attr('disabled', true);

	$('[name="kode_barang"]').removeClass('is-invalid');
    $('.help-block-kode_barang').addClass('text-danger').text('');
	$('[name="photo_name"]').removeClass('is-invalid');
    $('.help-block-photo_name').addClass('text-danger').text('');
	$('[name="nama_barang"]').removeClass('is-invalid');
    $('.help-block-nama_barang').addClass('text-danger').text('');
	$('[name="photo"]').removeClass('is-invalid');
    $('.help-block-photo').addClass('text-danger').text('');
	$('[name="harga_beli"]').removeClass('is-invalid');
    $('.help-block-harga_beli').addClass('text-danger').text('');
	$('[name="harga_jual"]').removeClass('is-invalid');
    $('.help-block-harga_jual').addClass('text-danger').text('');
	$('[name="satuan"]').removeClass('is-invalid');
    $('.help-block-sat').addClass('text-danger').text('');
    $('[name="kategori_id"]').removeClass('is-invalid');
    $('.help-block-kategori_id').addClass('text-danger').text('');
    $('[name="keterangan"]').removeClass('is-invalid');
    $('.help-block-keterangan').addClass('text-danger').text('');
    
    $('#kategori_id').select2().next().show();
    $('#photo').hide();
    $('#btnSaveApp').hide();
});

$('#table1').on('click', '.nonactive_record', function() {
    var kode_barang = $(this).data('kode_barang');
    var nama_barang = $(this).data('nama_barang');
    Swal.fire({
        icon: 'warning',
        title: 'Are You Sure?',
        text: 'Non Active [' + kode_barang + '] '+ nama_barang,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('master_barang/nonactive'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    kode_barang: kode_barang
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
                        table_master_barang.ajax.reload();
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
    var kode_barang = $(this).data('kode_barang');
    var nama_barang = $(this).data('nama_barang');
    Swal.fire({
        icon: 'warning',
        title: 'Are You Sure?',
        text: 'Active [' + kode_barang + '] '+ nama_barang,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('master_barang/reactive'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    kode_barang: kode_barang
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
                        table_master_barang.ajax.reload();
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
        url: "<?php echo site_url('master_barang/generate'); ?>",
        type: 'POST',
        data: {},
        dataType: 'JSON'
    }).done(function(data) {
        var $a = $("<a>");
            $a.attr("href", data.file);
            $("body").append($a);
            $a.attr("download", "master_barang.xlsx");
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
    $('#form-import-master_barang')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-import-master_barang').modal('show');
    $('.modal-title-import-master_barang').text('Import Data');
    $('#btnSave').show();
}

function importUpload() {
    var url = "<?php echo site_url('master_barang/import'); ?>";
    var formData = new FormData($('#form-import-master_barang')[0]);
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
                        table_master_barang.ajax.reload();
                        $('#modal-import-master_barang').modal('hide');
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
        url = 'master_barang/add';
    } else {
        url = 'master_barang/update';
    }
    var formData = new FormData($('#form-master_barang')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $('#modal-form-master_barang').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Data berhasil disimpan...',
                    timer: 2000,
                    showCancelButton: false,
                    showConfirmButton: false
                }).then(function() {
                    table_master_barang.ajax.reload();
                    $('#modal-form-master_barang').modal('hide');
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