<script>
var table_master_tipe_kendaraan;
var save_method;
$(document).ready(function() {

    //datatables
    table_master_tipe_kendaraan = $('#table1').DataTable({
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
        scrollCollapse: true,
        select: true,
        responsive: false,
        order: [], //Initial no order.
        ordering: true,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: "<?php echo site_url('master_tipe_kendaraan/master_tipe_kendaraan_list'); ?>",
            type: "POST",
            data: function(data) {}
        },
        //Set column definition initialisation properties.
        columnDefs: [{
            targets: [0,4], //first column / numbering column
            orderable: false, //set not orderable
        }, ], 
    }); 
});

$('#filter').on('click', function() {
    table_master_tipe_kendaraan.ajax.url("master_tipe_kendaraan/master_tipe_kendaraan_list?status=" + $('#filter_status').val()).load();
});

$("#filter_status").select2();

function add_form() {
    save_method = 'add';
    $('#form-master_tipe_kendaraan')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-master_tipe_kendaraan').modal('show');
    $('.modal-title-form-master_tipe_kendaraan').text('Add Kendaraan Tipe');
    $('[name="tipe_id"]').attr('readonly', false);
    $('[name="tipe_desc"]').attr('readonly', false);
    $('[name="siet"]').attr('readonly', false);

	$('[name="tipe_desc"]').removeClass('is-invalid');
    $('.help-block-tipe_desc').addClass('text-danger').text('');
	$('[name="siet"]').removeClass('is-invalid');
    $('.help-block-siet').addClass('text-danger').text('');
    
    $('#btnSaveApp').show();
    $('.tipe_id').show();
} 

$('#table1').on('click', '.view_record', function() {
    save_method = 'update';
    $('#form-master_tipe_kendaraan')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-master_tipe_kendaraan').modal('show');
    $('.modal-title-form-master_tipe_kendaraan').text('View Kendaraan Tipe');
    $('[name="tipe_id"]').val($(this).data('tipe_id'));
    $('[name="tipe_desc"]').val($(this).data('tipe_desc'));
    $('[name="siet"]').val($(this).data('siet'));
    $('[name="tipe_id"]').attr('readonly', true);
    $('[name="tipe_desc"]').attr('readonly', true);
    $('[name="siet"]').attr('readonly', true);

	$('[name="tipe_desc"]').removeClass('is-invalid');
    $('.help-block-tipe_desc').addClass('text-danger').text('');
	$('[name="siet"]').removeClass('is-invalid');
    $('.help-block-siet').addClass('text-danger').text('');

    $('#btnSaveApp').hide();
    $('.tipe_id').hide();
});

$('#table1').on('click', '.edit_record', function() {
    save_method = 'update';
    $('#form-master_tipe_kendaraan')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-master_tipe_kendaraan').modal('show');
    $('.modal-title-form-master_tipe_kendaraan').text('Edit Kendaraan Tipe');
    $('[name="tipe_id"]').val($(this).data('tipe_id'));
    $('[name="tipe_desc"]').val($(this).data('tipe_desc'));
    $('[name="siet"]').val($(this).data('siet'));
    $('[name="tipe_id"]').attr('readonly', true);
    $('[name="tipe_desc"]').attr('readonly', false);
    $('[name="siet"]').attr('readonly', false);

	$('[name="tipe_desc"]').removeClass('is-invalid');
    $('.help-block-tipe_desc').addClass('text-danger').text('');
	$('[name="siet"]').removeClass('is-invalid');
    $('.help-block-siet').addClass('text-danger').text('');
    
    $('#btnSaveApp').show();
    $('.tipe_id').hide();
});

$('#table1').on('click', '.delete_record', function() {
    var tipe_id = $(this).data('tipe_id');
    var tipe_desc = $(this).data('tipe_desc');
    Swal.fire({
        icon: 'warning',
        title: 'Are You Sure?',
        text: 'Delete data [' + tipe_id + '] ' + tipe_desc,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('master_tipe_kendaraan/nonactive'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    tipe_id: tipe_id
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
                        table_master_tipe_kendaraan.ajax.reload();
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
    var tipe_id = $(this).data('tipe_id');
    var tipe_desc = $(this).data('tipe_desc');
    Swal.fire({
        icon: 'warning',
        title: 'Are You Sure?',
        text: 'Reactive data [' + tipe_id + '] ' + tipe_desc,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('master_tipe_kendaraan/reactive'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    tipe_id: tipe_id
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
                        table_master_tipe_kendaraan.ajax.reload();
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
        url = 'master_tipe_kendaraan/add';
    } else {
        url = 'master_tipe_kendaraan/update';
    }
    var formData = new FormData($('#form-master_tipe_kendaraan')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $('#modal-form-master_tipe_kendaraan').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Data berhasil disimpan...',
                    timer: 2000,
                    showCancelButton: false,
                    showConfirmButton: false
                }).then(function() {
                    table_master_tipe_kendaraan.ajax.reload();
                    $('#modal-form-master_tipe_kendaraan').modal('hide');
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