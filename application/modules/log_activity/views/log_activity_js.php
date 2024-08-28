<script>
var save_method;
var table_log_activity;

$(document).ready(function() {

    //datatables
    table_log_activity = $('#table1').DataTable({
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
            [10, 25, 50, 100],
            ['10', '25', '50', '100']
        ],
        buttons: [{
                extend: 'copyHtml5',
                footer: true
            },
            {
                extend: 'excelHtml5',
                footer: true
            },
            {
                extend: 'csvHtml5',
                footer: true
            },
            {
                extend: 'pdfHtml5',
                footer: true
            }
        ],
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
            url: "<?php echo site_url('log_activity/log_activity_list'); ?>" +
				"?oid=<?php echo $this->session->userdata('oid');?>" +
                "&date_start=" + $('#filter_date_start').val() +
                "&date_end=" + $('#filter_date_end').val(),
            type: "POST",
            data: function(data) {}
        },
        //Set column definition initialisation properties.
        columnDefs: [{
            targets: [0], //first column / numbering column
            orderable: false, //set not orderable
        }, ],

    });
    $("#filter_oid").val("<?php echo $this->session->userdata('oid');?>");
    $("#filter_oid").select2();

    let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
    if (isMobile) {
        $('.lyt-content').removeClass('content-wrapper');
    } else {
        $('.lyt-content').addClass('content-wrapper');
    }
});

function onlyNumberKey(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}

function templateUpload() {
    window.location = "upload/template/template_customer_import.xlsx";
}

$('#filter').on('click', function() {
    table_log_activity.ajax.url("log_activity/log_activity_list?oid=" + $('#filter_oid').val() +
        "&date_start=" + $('#filter_date_start').val() +
        "&date_end=" + $('#filter_date_end').val()).load();
});

function add_form() {
    save_method = 'add';
    $('#form-customer')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-customer').modal('show');
    $('.modal-title-form-customer').text('Add Customer');
    $("#oid").val("<?php echo $this->session->userdata('oid');?>");
    $('[name="cust_id"]').attr('readonly', false);
    $('[name="nama_cust"]').attr('readonly', false);
    $('[name="ktp"]').attr('readonly', false);
    $('[name="alamat"]').attr('readonly', false);
    $('[name="kota"]').attr('readonly', false);
    $('[name="telp"]').attr('readonly', false);
    $('[name="hp"]').attr('readonly', false);
    $('[name="oid"]').attr('disabled', false);
    $('#btnSave').show();
}

$('#table1').on('click', '.view_record', function() {
    save_method = 'update';
    $('#form-customer')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-customer').modal('show');
    $('.modal-title-form-customer').text('Edit Customer');
    $('[name="cust_id"]').val($(this).data('cust_id'));
    $('[name="nama_cust"]').val($(this).data('nama_cust'));
    $('[name="ktp"]').val($(this).data('ktp'));
    $('[name="alamat"]').val($(this).data('alamat'));
    $('[name="kota"]').val($(this).data('kota'));
    $('[name="telp"]').val($(this).data('telp'));
    $('[name="hp"]').val($(this).data('hp'));
    $('[name="oid"]').val($(this).data('oid'));
    $('[name="cust_id"]').attr('readonly', true);
    $('[name="nama_cust"]').attr('readonly', true);
    $('[name="ktp"]').attr('readonly', true);
    $('[name="alamat"]').attr('readonly', true);
    $('[name="kota"]').attr('readonly', true);
    $('[name="telp"]').attr('readonly', true);
    $('[name="hp"]').attr('readonly', true);
    $('[name="oid"]').attr('disabled', true);
    $('#btnSave').hide();
});

$('#table1').on('click', '.edit_record', function() {
    save_method = 'update';
    $('#form-customer')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-customer').modal('show');
    $('.modal-title-form-customer').text('Edit Customer');
    $('[name="cust_id"]').val($(this).data('cust_id'));
    $('[name="nama_cust"]').val($(this).data('nama_cust'));
    $('[name="ktp"]').val($(this).data('ktp'));
    $('[name="alamat"]').val($(this).data('alamat'));
    $('[name="kota"]').val($(this).data('kota'));
    $('[name="telp"]').val($(this).data('telp'));
    $('[name="hp"]').val($(this).data('hp'));
    $('[name="oid"]').val($(this).data('oid'));
    $('[name="cust_id"]').attr('readonly', false);
    $('[name="nama_cust"]').attr('readonly', false);
    $('[name="ktp"]').attr('readonly', true);
    $('[name="alamat"]').attr('readonly', false);
    $('[name="kota"]').attr('readonly', false);
    $('[name="telp"]').attr('readonly', false);
    $('[name="hp"]').attr('readonly', false);
    $('[name="oid"]').attr('disabled', false);
    $('#btnSave').show();
});

$('#table1').on('click', '.delete_record', function() {
    var id = $(this).data('cust_id');
    var nama_cust = $(this).data('nama_cust');
    Swal.fire({
        icon: 'warning',
        title: 'Are You Sure?',
        text: 'Delete data [' + id + '] ' + nama_cust,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('log_activity/delete/'); ?>" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil dihapus',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        table_log_activity.ajax.reload();
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

function save() {
    $('#btnSave').text('Saving...');
    $('#btnSave').attr('disabled', true);
    if (save_method == "add") {
        url = 'log_activity/add';
    } else {
        url = 'log_activity/update';
    }
    var formData = new FormData($('#form-customer')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $('#modal-form-import').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Data berhasil disimpan...',
                    timer: 2000,
                    showCancelButton: false,
                    showConfirmButton: false
                }).then(function() {
                    table_log_activity.ajax.reload();
                    $('#modal-form-customer').modal('hide');
                    Swal.close();
                });
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                    $('[name="' + data.inputerror[i] + '"]').next().addClass('text-danger').text(data
                        .error_string[i]);
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
</script>