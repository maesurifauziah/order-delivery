<script>
var save_method;
var table_sewa_kendaraan_approver;

$(document).ready(function() {

    //datatables
    table_sewa_kendaraan_approver = $('#table1').DataTable({
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
            url: "<?php echo site_url('sewa_kendaraan_approver/sewa_kendaraan_approver_list'); ?>" +
				"?status_pembayaran=" + $('#filter_status_pembayaran').val() +
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
   
    $("#filter_status_pembayaran").select2();

    let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
    if (isMobile) {
        $('.lyt-content').removeClass('content-wrapper');
    } else {
        $('.lyt-content').addClass('content-wrapper');
    }
});


$('#filter').on('click', function() {
    table_sewa_kendaraan_approver.ajax.url("sewa_kendaraan_approver/sewa_kendaraan_approver_list?status_pembayaran=" + $('#filter_status_pembayaran').val() +
        "&date_start=" + $('#filter_date_start').val() +
        "&date_end=" + $('#filter_date_end').val()).load();
});

$('#table1').on('click', '.down_paymen_record', function() {
    var sewa_id = $(this).data('sewa_id');
    Swal.fire({
        icon: 'warning',
        title: 'Anda yakin?',
        text: '[' + sewa_id + '] di Approve?',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('sewa_kendaraan_approver/approve_uang_muka'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    sewa_id: sewa_id
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil diproses',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        table_sewa_kendaraan_approver.ajax.reload();
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

$('#table1').on('click', '.pelunasan_record', function() {
    save_method = 'approve_pelunasan';
    $('#form-approve_pelunasan')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-approve_pelunasan').modal('show');
    $('.modal-title-form-approve_pelunasan').text('Approve Pelunasan ['+$(this).data('sewa_id')+']');
    $('#sewa_id_lns').val($(this).data('sewa_id'));
    
    $('[name="sewa_id_lns"]').attr('readonly', false);
    $('[name="plat_nomer"]').attr('readonly', false);
    $('[name="nama_supir"]').attr('readonly', false);

    $('[name="sewa_id_lns"]').removeClass('is-invalid');
    $('.help-block-sewa_id_lns').addClass('text-danger').text('');
	$('[name="plat_nomer"]').removeClass('is-invalid');
    $('.help-block-plat_nomer').addClass('text-danger').text('');
    $('[name="nama_supir"]').removeClass('is-invalid');
    $('.help-block-nama_supir').addClass('text-danger').text('');
});
function save() {
    if (save_method == "approve_pelunasan") {
        url = 'sewa_kendaraan_approver/approve_pelunasan';
        var formData = new FormData($('#form-approve_pelunasan')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#modal-form-approve_pelunasan').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil diproses...',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        $('#modal-form-approve_pelunasan').modal('hide');
                        table_sewa_kendaraan_approver.ajax.reload();
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
// $('#table1').on('click', '.pelunasan_record', function() {
//     var sewa_id = $(this).data('sewa_id');
//     Swal.fire({
//         icon: 'warning',
//         title: 'Anda yakin?',
//         text: '[' + sewa_id + '] di Approve?',
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: "Yes",
//         cancelButtonText: "No",
//         showCancelButton: true,
//     }).then((result) => {
//         if (result.value) {
//             $.ajax({
//                 url: "<?php echo site_url('sewa_kendaraan_approver/approve_pelunasan'); ?>",
//                 type: "POST",
//                 dataType: "JSON",
//                 data: {
//                     sewa_id: sewa_id
//                 },
//                 success: function(data) {
//                     Swal.fire({
//                         icon: 'success',
//                         title: 'Sukses!',
//                         text: 'Data berhasil diproses',
//                         timer: 2000,
//                         showCancelButton: false,
//                         showConfirmButton: false
//                     }).then(function() {
//                         table_sewa_kendaraan_approver.ajax.reload();
//                         Swal.close();
//                     });
//                 },
//                 error: function(jqXHR, textStatus, errorThrown) {
//                     alert('Error nonaktif data');
//                 }
//             });
//         }
//     });
// });

$('#table1').on('click', '.done_record', function() {
    var sewa_id = $(this).data('sewa_id');
    Swal.fire({
        icon: 'warning',
        title: 'Anda yakin?',
        text: '[' + sewa_id + '] Selesai ?',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('sewa_kendaraan_approver/selesai'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    sewa_id: sewa_id
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil diproses',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        table_sewa_kendaraan_approver.ajax.reload();
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

$('#table1').on('click', '.delete_record', function() {
    var sewa_id = $(this).data('sewa_id');
    Swal.fire({
        icon: 'warning',
        title: 'Anda yakin?',
        text: '[' + sewa_id + '] dibatalkan?',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('sewa_kendaraan_approver/cancel'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    sewa_id: sewa_id
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil diproses',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        table_sewa_kendaraan_approver.ajax.reload();
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

$('#table1').on('click', '.view_record', function() {
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-sewa_kendaraan_approver').modal('show');
    $('.modal-title-form-sewa_kendaraan_approver').html('<label>View Detail Sewa ['+$(this).data('sewa_id')+']</label>');
    $('[name="sewa_id"]').val($(this).data('sewa_id'));
    $('#total2').text($(this).data('grand_total_format'));
    
    get_detail_sewa_by_id();
});

function get_detail_sewa_by_id() {
    $.ajax({
        url: "<?php echo site_url('sewa_kendaraan_approver/get_detail_sewa_by_id/'); ?>"+$('#sewa_id').val(),
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#item_detail2').html(data.html);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error show data');
        }
    });
}

</script>