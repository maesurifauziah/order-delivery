<script>
var save_method;
var table_order_kurir;

$(document).ready(function() {

    //datatables
    table_order_kurir = $('#table1').DataTable({
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
        responsive: true,
        order: [], //Initial no order.
        ordering: true,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: "<?php echo site_url('order_kurir/order_kurir_list'); ?>" +
				"?status_order_barang=" + $('#filter_status_order_barang').val() +
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
   
    $("#filter_status_order_barang").select2();

    let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
    if (isMobile) {
        $('.lyt-content').removeClass('content-wrapper');
    } else {
        $('.lyt-content').addClass('content-wrapper');
    }
});


$('#filter').on('click', function() {
    table_order_kurir.ajax.url("order_kurir/order_kurir_list?status_order_barang=" + $('#filter_status_order_barang').val() +
        "&date_start=" + $('#filter_date_start').val() +
        "&date_end=" + $('#filter_date_end').val()).load();
});

$('#table1').on('click', '.packing_record', function() {
    var order_id = $(this).data('order_id');
    Swal.fire({
        icon: 'warning',
        title: 'Anda yakin?',
        text: '[' + order_id + '] di Packing?',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('order_kurir/proses'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    order_id: order_id
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
                        table_order_kurir.ajax.reload();
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

$('#table1').on('click', '.approve_record', function() {
    var order_id = $(this).data('order_id');
    Swal.fire({
        icon: 'warning',
        title: 'Anda yakin?',
        text: '[' + order_id + '] Approve Pembayaran?',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('order_kurir/approve'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    order_id: order_id
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
                        table_order_kurir.ajax.reload();
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
$('#table1').on('click', '.delivery_record', function() {
    var order_id = $(this).data('order_id');
    Swal.fire({
        icon: 'warning',
        title: 'Anda yakin?',
        text: '[' + order_id + '] dikirim?',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('order_kurir/kirim'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    order_id: order_id
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
                        table_order_kurir.ajax.reload();
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

$('#table1').on('click', '.checklist_record', function() {
    var order_id = $(this).data('order_id');
    Swal.fire({
        icon: 'warning',
        title: 'Anda yakin?',
        text: '[' + order_id + '] Selesai ?',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('order_kurir/selesai'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    order_id: order_id
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
                        table_order_kurir.ajax.reload();
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
    var order_id = $(this).data('order_id');
    Swal.fire({
        icon: 'warning',
        title: 'Anda yakin?',
        text: '[' + order_id + '] dibatalkan?',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('order_kurir/cancel'); ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    order_id: order_id
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
                        table_order_kurir.ajax.reload();
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
    $('#modal-form-order_barang').modal('show');
    $('.modal-title-form-order_barang').html('<label>View Detail Order ['+$(this).data('order_id')+']</label>');
    $('[name="order_id"]').val($(this).data('order_id'));
    $('#total2').text($(this).data('total_format'));
    
    get_detail_order_by_id();
});

function get_detail_order_by_id() {
    $.ajax({
        url: "<?php echo site_url('order_kurir/get_detail_order_by_id/'); ?>"+$('#order_id').val(),
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