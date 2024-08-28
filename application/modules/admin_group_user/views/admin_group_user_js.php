<script>
var table_group_user;
var table_group_user_view;
var save_method;
$(document).ready(function() {
    //datatables
    table_group_user = $('#table1').DataTable({
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
            url: "<?php echo site_url('admin_group_user/admin_group_user_list'); ?>",
            type: "POST",
            data: function(data) {}
        },
        //Set column definition initialisation properties.
        columnDefs: [{
            targets: [0,4], //first column / numbering column
            orderable: false, //set not orderable
        }, ], 
    }); 

    // table_group_user_view = $('#table1_user_group_view').DataTable({
    //     scrollY: '300',
    //     searching: false,
    //     paging: false,
    //     ordering: false,
    //     info: false,
    //     destroy: true
    // });
    // table_group_user_view = $('#table1_user_group_add').DataTable({
    //     scrollY: '300',
    //     searching: false,
    //     paging: false,
    //     ordering: false,
    //     info: false,
    //     destroy: true
    // });
    // table_group_user_view = $('#table1_user_group_edit').DataTable({
    //     scrollY: '300',
    //     searching: false,
    //     paging: false,
    //     ordering: false,
    //     info: false,
    //     destroy: true
    // });

    
    $("#filter_status").select2();
    // $("#filter_company").select2();
    $("#filter_kantor").select2();

    let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
    if (isMobile) {
        $('.lyt-content').removeClass('content-wrapper');
    } else {
        $('.lyt-content').addClass('content-wrapper');
    }
});

// $("#filter_kantor").val("<?php echo $this->session->userdata('oid');?>");
$('#filter').on('click', function() {
    table_group_user.ajax.url("admin_group_user/admin_group_user_list?status=" + $('#filter_status').val()).load();
});


function add_form() {
    save_method = 'add';
    $('#form-admin_group_user')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-admin_group_user').modal('show');
    $('.modal-title-form-admin_group_user').text('Add User Group');

    $('[name="user_group"]').attr('readonly', false);
    $('[name="group_name"]').attr('readonly', false);
    
	$('[name="user_group"]').removeClass('is-invalid');
    $('.help-block-user_group').addClass('text-danger').text('');
	$('[name="group_name"]').removeClass('is-invalid');
    $('.help-block-group_name').addClass('text-danger').text('');
	// get_daftar_application_menu();
    $('#btnSaveApp').show();
} 

$('#table1').on('click', '.edit_record', function() {
    save_method = 'update';
    $('#form-admin_group_user_edit')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-admin_group_user_edit').modal('show');
    $('.modal-title-form-admin_group_user_edit').text('Edit User Group');

    $('[name="user_group_edit"]').val($(this).data('user_group'));
    $('[name="group_name_edit"]').val($(this).data('group_name'));

    $('[name="user_group_edit"]').attr('readonly', true);
    $('[name="group_name_edit"]').attr('readonly', true);

	$('[name="user_group_edit"]').removeClass('is-invalid');
    $('.help-block-user_group_edit').addClass('text-danger').text('');
	$('[name="group_name_edit"]').removeClass('is-invalid');
    $('.help-block-group_name_edit').addClass('text-danger').text('');
    // get_daftar_application_menu_edit();
    $('#btnSaveApp').show();
});

$('#table1').on('click', '.view_record', function() {
    save_method = 'update';
    $('#form-admin_group_user_view')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-admin_group_user_view').modal('show');
    $('.modal-title-form-admin_group_user_view').text('View User Group');
    $('[name="user_group_view"]').val($(this).data('user_group'));
    $('[name="group_name_view"]').val($(this).data('group_name'));

    $('[name="user_group_view"]').attr('readonly', true);
    $('[name="group_name_view"]').attr('readonly', true);

	$('[name="user_group_view"]').removeClass('is-invalid');
    $('.help-block-user_group_view').addClass('text-danger').text('');
	$('[name="group_name_view"]').removeClass('is-invalid');
    $('.help-block-group_name_view').addClass('text-danger').text('');
    
    // get_view_detail_group_user();
    
});


function get_view_detail_group_user() {
    $.ajax({
        url: "<?php echo site_url('admin_group_user/get_view_detail_group_user/'); ?>"+$('#user_group_view').val(),
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#tbody_user_group_view').html(data.html);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error show data');
        }
    });
}

function get_daftar_application_menu() {
    $.ajax({
        url: "<?php echo site_url('admin_group_user/get_daftar_application_menu'); ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#tbody_user_group_add').empty();
            for (var i = 0; i < data.length; i++) {
                
                $('#jumlah_data').val(data.length);
                $('#tbody_user_group_add').append(
                    '<tr>'+
                        '<td class="text-center" style="vertical-align: middle;"><input type="checkbox" name="data_ceklis['+i+']" id="data_ceklis'+i+'"></td>'+
                        '<td class="text-center" style="vertical-align: middle;">'+data[i].app_name_ci+'</td>'+
                        '<td class="text-center" style="vertical-align: middle;">'+data[i].title_ci+
                            '<input type="hidden" name="menuid['+i+']" id="menuid'+i+'" value="'+data[i].menuid+'" readonly>'+
                        '</td>'+
                        '<td class="text-center" style="vertical-align: middle;">'+data[i].level_ci+'</td>'+
                        '<td class="text-center" style="vertical-align: middle;">'+data[i].ket+'</td>'+
                    '</tr>'
                );
                // $('#qty'+i).attr('readonly', true);
                $('#sub_total'+i).attr('disabled', true);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error show data');
        }
    });
}

function get_daftar_application_menu_edit() {
    $.ajax({
        url: "<?php echo site_url('admin_group_user/get_daftar_application_menu_edit/'); ?>"+$('#user_group_edit').val(),
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#tbody_user_group_edit').empty();
            for (var i = 0; i < data.length; i++) {
                $('#jumlah_data_edit').val(data.length);
                $('#tbody_user_group_edit').append(
                    '<tr>'+
                        '<td class="text-center" style="vertical-align: middle;"><input type="checkbox" name="data_ceklis_edit['+i+']" id="data_ceklis_edit'+i+'"></td>'+
                        '<td class="text-center" style="vertical-align: middle;">'+data[i].app_name_ci+'</td>'+
                        '<td class="text-center" style="vertical-align: middle;">'+data[i].title_ci+
                            '<input type="hidden" name="menuid_edit['+i+']" id="menuid_edit'+i+'" value="'+data[i].menuid+'" readonly>'+
                        '</td>'+
                        '<td class="text-center" style="vertical-align: middle;">'+data[i].level_ci+'</td>'+
                        '<td class="text-center" style="vertical-align: middle;">'+data[i].ket+'</td>'+
                    '</tr>'
                );
                if((data[i].menuid_val == 0) && (data[i].title_ci_val == 0)){
                    $('#data_ceklis_edit'+i).prop('checked',false);
                } else {
                    $('#data_ceklis_edit'+i).prop('checked',true);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error show data');
        }
    });
}

function checkAll() {
	for (var j = 0; j <= $('#jumlah_data').val(); j++){
        $('#data_ceklis'+j).prop('checked','checked');
	}
}
function checkAllEdit() {
	for (var j = 0; j <= $('#jumlah_data_edit').val(); j++){
        $('#data_ceklis_edit'+j).prop('checked','checked');
	}
}
function unCheckAll() {
	for (var j = 0; j <= $('#jumlah_data').val(); j++){
        $('#data_ceklis'+j).prop('checked', false);
	}
}
function unCheckAllEdit() {
	for (var j = 0; j <= $('#jumlah_data_edit').val(); j++){
        $('#data_ceklis_edit'+j).prop('checked', false);
	}
}


$('#table1').on('click', '.nonactive_record', function() {
    var id = $(this).data('user_group');
    var nama_lengkap = $(this).data('group_name');
    Swal.fire({
        icon: 'warning',
        title: 'Are You Sure?',
        text: 'Non Active [' + id + '] '+ nama_lengkap,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('admin_group_user/nonactive?id='); ?>" + id,
                type: "DELETE",
                dataType: "JSON",
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil dinonavtive',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        table_group_user.ajax.reload();
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
    var id = $(this).data('user_group');
    var nama_lengkap = $(this).data('group_name');
    Swal.fire({
        icon: 'warning',
        title: 'Are You Sure?',
        text: 'Active [' + id + '] '+ nama_lengkap,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo site_url('admin_group_user/reactive?id='); ?>" + id,
                type: "DELETE",
                dataType: "JSON",
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil direactive',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        table_group_user.ajax.reload();
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

function save() {
    $('#btnSaveApp').text('Saving...');
    $('#btnSaveApp').attr('disabled', true);
    if (save_method == "add") {
        url = 'admin_group_user/add';
        var formData = new FormData($('#form-admin_group_user')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#modal-form-admin_group_user').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil disimpan...',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        table_group_user.ajax.reload();
                        $('#modal-form-admin_group_user').modal('hide');
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
                $('#btnSaveApp').text('Save');
                $('#btnSaveApp').attr('disabled', false);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSaveApp').text('Save');
                $('#btnSaveApp').attr('disabled', false);
            }
        });
    } else {
        url = 'admin_group_user/update';
        var formData = new FormData($('#form-admin_group_user_edit')[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if (data.status) {
                    $('#modal-form-admin_group_user_edit').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Data berhasil disimpan...',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(function() {
                        table_group_user.ajax.reload();
                        $('#modal-form-admin_group_user_edit').modal('hide');
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