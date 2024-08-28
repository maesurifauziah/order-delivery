<script>
var table_master_kategori_barang;
var save_method;
$(document).ready(function() {

    //datatables
    table_master_kategori_barang = $('#table1').DataTable({
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
        scrollY: '35vh',
        scrollX: true,
        scrollCollapse: true,
        select: true,
        responsive: false,
        order: [], //Initial no order.
        ordering: true,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: "<?php echo site_url('master_kategori_barang/master_kategori_barang_list?status='); ?>" + $('#filter_status').val(),
            type: "POST",
            data: function(data) {}
        },
        //Set column definition initialisation properties.
        columnDefs: [{
            targets: [0,4], //first column / numbering column
            orderable: false, //set not orderable
        }, ], 
    }); 

    // let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;

    //     if (isMobile) {
    //         $('#table1').DataTable( {
    //             scrollY: '25vh',
    //         } );
    //         table_master_kategori_barang.ajax.reload();
    //     } else {
    //         $('#table1').DataTable( {
    //             scrollY: '45vh',
    //         } );
    //         table_master_kategori_barang.ajax.reload();
            
    //     }
});

$('#filter').on('click', function() {
    table_master_kategori_barang.ajax.url("master_kategori_barang/master_kategori_barang_list?status=" + $('#filter_status').val()).load();
});

$("#filter_status").select2();

function add_form() {
    save_method = 'add';
    $('#form-master_kategori_barang')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-master_kategori_barang').modal('show');
    $('.modal-title-form-master_kategori_barang').text('Add Kategori Barang');
    $('[name="kategori_id"]').attr('readonly', false);
    $('[name="kategori_desc"]').attr('readonly', false);
    $('[name="urutan"]').attr('readonly', false);

	$('[name="kategori_desc"]').removeClass('is-invalid');
    $('.help-block-kategori_desc').addClass('text-danger').text('');
	$('[name="urutan"]').removeClass('is-invalid');
    $('.help-block-urutan').addClass('text-danger').text('');
    
    $('#btnSaveApp').show();
    $('.kategori_id').show();
} 

$('#table1').on('click', '.view_record', function() {
    save_method = 'update';
    $('#form-master_kategori_barang')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-master_kategori_barang').modal('show');
    $('.modal-title-form-master_kategori_barang').text('View Kategori Barang');
    $('[name="kategori_id"]').val($(this).data('kategori_id'));
    $('[name="kategori_desc"]').val($(this).data('kategori_desc'));
    $('[name="urutan"]').val($(this).data('urutan'));
    $('[name="kategori_id"]').attr('readonly', true);
    $('[name="kategori_desc"]').attr('readonly', true);
    $('[name="urutan"]').attr('readonly', true);

	$('[name="kategori_desc"]').removeClass('is-invalid');
    $('.help-block-kategori_desc').addClass('text-danger').text('');
	$('[name="urutan"]').removeClass('is-invalid');
    $('.help-block-urutan').addClass('text-danger').text('');

    $('#btnSaveApp').hide();
    $('.kategori_id').hide();
});

$('#table1').on('click', '.edit_record', function() {
    save_method = 'update';
    $('#form-master_kategori_barang')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-master_kategori_barang').modal('show');
    $('.modal-title-form-master_kategori_barang').text('Edit Kategori Barang');
    $('[name="kategori_id"]').val($(this).data('kategori_id'));
    $('[name="kategori_desc"]').val($(this).data('kategori_desc'));
    $('[name="urutan"]').val($(this).data('urutan'));
    $('[name="kategori_id"]').attr('readonly', true);
    $('[name="kategori_desc"]').attr('readonly', false);
    $('[name="urutan"]').attr('readonly', false);

	$('[name="kategori_desc"]').removeClass('is-invalid');
    $('.help-block-kategori_desc').addClass('text-danger').text('');
	$('[name="urutan"]').removeClass('is-invalid');
    $('.help-block-urutan').addClass('text-danger').text('');
    
    $('#btnSaveApp').show();
    $('.kategori_id').hide();
});

$('#table1').on('click', '.delete_record', function() {
    var kategori_id = $(this).data('kategori_id');
    var kategori_desc = $(this).data('kategori_desc');
    Swal.fire({
        icon: 'warning',
        title: 'Are You Sure?',
        text: 'Delete data [' + kategori_id + '] ' + kategori_desc,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('master_kategori_barang/nonactive'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    kategori_id: kategori_id
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil dihapus',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        table_master_kategori_barang.ajax.reload();
                        Swal.close();
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error delete data');
                }
            });
        }
    });
});

$('#table1').on('click', '.reactive_record', function() {
    var kategori_id = $(this).data('kategori_id');
    var kategori_desc = $(this).data('kategori_desc');
    Swal.fire({
        icon: 'warning',
        title: 'Are You Sure?',
        text: 'Reactive data [' + kategori_id + '] ' + kategori_desc,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('master_kategori_barang/reactive'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    kategori_id: kategori_id
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil diaktifkan',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        table_master_kategori_barang.ajax.reload();
                        Swal.close();
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error reactive data');
                }
            });
        }
    });
});

function save() {
    $('#btnSaveApp').text('Saving...');
    $('#btnSaveApp').attr('disabled', true);
    if (save_method == "add") {
        url = 'master_kategori_barang/add';
    } else {
        url = 'master_kategori_barang/update';
    }
    var formData = new FormData($('#form-master_kategori_barang')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $('#modal-form-master_kategori_barang').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Data berhasil disimpan...',
                    timer: 2000,
                    showCancelButton: false,
                    showConfirmButton: false
                }).then(function() {
                    table_master_kategori_barang.ajax.reload();
                    $('#modal-form-master_kategori_barang').modal('hide');
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