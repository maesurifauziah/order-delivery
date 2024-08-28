<script>
var table_apps;
var table_apps_menu;
var save_method;
$(document).ready(function() {
    //datatables
    table_apps = $('#table1').DataTable({
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
            url: "<?php echo site_url('admin_user_apps/admin_user_apps_list'); ?>",
            type: "POST",
            data: function(data) {}
        },
        //Set column definition initialisation properties.
        columnDefs: [{
            targets: [0,5], //first column / numbering column
            orderable: false, //set not orderable
        }, ], 
    }); 

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
    table_apps.ajax.url("admin_user_apps/admin_user_apps_list?oid=" + $('#filter_kantor').val()+"&status=" + $('#filter_status').val()).load();
});

// $('#filter_company').on('change', function() {
//         filter_get_list_branch($('#filter_company').val());
// });
// function filter_get_list_branch(id) {
//         $.ajax({
//                 url: "<?php echo site_url('admin_user_akses_cabang/filter_get_list_branch/'); ?>" + $('#filter_company').val(),
//                 type: "POST",
//                 dataType: "JSON",
//                 success: function(data) {
//                     $('#filter_kantor').empty();
//                     $('#filter_kantor').append('<option value="">all</option>');
//                     for (var i = 0; i < data.length; i++) {
//                         $('#filter_kantor').append('<option id=' + data[i].oid + ' value=' + data[i]
//                             .oid + '>' + data[i].nama_kantor + '</option>');
//                     }
//                     $('#filter_kantor').change();
//                 }
//             });
//     }

$("#oid").on("select2:select select2:unselecting", function () {
    initailizeSelect2($('#oid').val());
});
function initailizeSelect2(oid) {
    $(".dt-select2").select2({
        ajax: {
            url: "<?php echo base_url();?>karyawan_manage/get_list_employee2",
            type: "POST",
            dataType: 'JSON',
            delay: 250,
            data: function(params) {
                return {
                    typeTerm: oid,
                    searchTerm: params.term,
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
}

$('#user_group').select2();

function add_form() {
    save_method = 'add';
    $('#form-admin_user_apps')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-admin_user_apps').modal('show');
    $('.modal-title-form-admin_user_apps').text('Add User');

    $('[name="userid"]').attr('readonly', false);
    $('[name="nama_lengkap"]').attr('readonly', false);
    $('[name="user_name"]').attr('readonly', false);
    $('[name="password"]').attr('readonly', false);
    $('[name="confirm_password"]').attr('readonly', false);
    $('[name="user_group"]').attr('disabled', false);
    $('[name="alamat"]').attr('readonly', false);
    $('[name="daerah"]').attr('readonly', false);
    $('[name="no_hp"]').attr('readonly', false);

	$('[name="userid"]').removeClass('is-invalid');
    $('.help-block-userid').addClass('text-danger').text('');
	$('[name="nama_lengkap"]').removeClass('is-invalid');
    $('.help-block-nama_lengkap').addClass('text-danger').text('');
	$('[name="user_name"]').removeClass('is-invalid');
    $('.help-block-user_name').addClass('text-danger').text('');
	$('[name="password"]').removeClass('is-invalid');
    $('.help-block-password').addClass('text-danger').text('');
	$('[name="confirm_password"]').removeClass('is-invalid');
    $('.help-block-confirm_password').addClass('text-danger').text('');
	$('[name="user_group"]').removeClass('is-invalid');
    $('.help-block-user_group').addClass('text-danger').text('');
	$('[name="daerah"]').removeClass('is-invalid');
    $('.help-block-daerah').addClass('text-danger').text('');
	$('[name="alamat"]').removeClass('is-invalid');
    $('.help-block-alamat').addClass('text-danger').text('');
	$('[name="no_hp"]').removeClass('is-invalid');
    $('.help-block-no_hp').addClass('text-danger').text('');
	
    $('.password').show();
    $('.confirm_password').show();

    $('#user_group').select2().next().show();
	
    $('#btnSaveApp').show();
} 

$('#table1').on('click', '.edit_record', function() {
    save_method = 'update';
    $('#form-admin_user_apps')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-admin_user_apps').modal('show');
    $('.modal-title-form-admin_user_apps').text('Edit User');

    $('[name="userid"]').val($(this).data('userid'));
    $('[name="nama_lengkap"]').val($(this).data('nama_lengkap'));
    $('[name="user_name"]').val($(this).data('user_name'));
    $('[name="user_group"]').val($(this).data('user_group'));
    $('[name="alamat"]').val($(this).data('alamat'));
    $('[name="daerah"]').val($(this).data('daerah'));
    $('[name="no_hp"]').val($(this).data('no_hp'));

    $('[name="userid"]').attr('readonly', false);
    $('[name="nama_lengkap"]').attr('readonly', false);
    $('[name="user_name"]').attr('readonly', false);
    $('[name="password"]').attr('readonly', false);
    $('[name="confirm_password"]').attr('readonly', false);
    $('[name="user_group"]').attr('disabled', false);
    $('[name="alamat"]').attr('readonly', false);
    $('[name="daerah"]').attr('readonly', false);
    $('[name="no_hp"]').attr('readonly', false);

	$('[name="userid"]').removeClass('is-invalid');
    $('.help-block-userid').addClass('text-danger').text('');
	$('[name="nama_lengkap"]').removeClass('is-invalid');
    $('.help-block-nama_lengkap').addClass('text-danger').text('');
	$('[name="user_name"]').removeClass('is-invalid');
    $('.help-block-user_name').addClass('text-danger').text('');
	$('[name="password"]').removeClass('is-invalid');
    $('.help-block-password').addClass('text-danger').text('');
	$('[name="confirm_password"]').removeClass('is-invalid');
    $('.help-block-confirm_password').addClass('text-danger').text('');
	$('[name="user_group"]').removeClass('is-invalid');
    $('.help-block-user_group').addClass('text-danger').text('');
	$('[name="alamat"]').removeClass('is-invalid');
    $('.help-block-alamat').addClass('text-danger').text('');
	$('[name="daerah"]').removeClass('is-invalid');
    $('.help-block-daerah').addClass('text-danger').text('');
	$('[name="no_hp"]').removeClass('is-invalid');
    $('.help-block-no_hp').addClass('text-danger').text('');

    $('.password').hide();
    $('.confirm_password').hide();

    $('#user_group').select2().next().show();
    
    $('#btnSaveApp').show();
    
});

$('#table1').on('click', '.view_record', function() {
    save_method = 'update';
    $('#form-admin_user_apps')[0].reset();
    $('.form-group').removeClass('text-danger');
    $('.help-block').empty();
    $('#modal-form-admin_user_apps').modal('show');
    $('.modal-title-form-admin_user_apps').text('View User');
    
    $('[name="userid"]').val($(this).data('userid'));
    $('[name="nama_lengkap"]').val($(this).data('nama_lengkap'));
    $('[name="user_name"]').val($(this).data('user_name'));
    $('[name="user_group"]').val($(this).data('user_group'));
    $('[name="alamat"]').val($(this).data('alamat'));
    $('[name="daerah"]').val($(this).data('daerah'));
    $('[name="no_hp"]').val($(this).data('no_hp'));

    $('[name="userid"]').attr('readonly', true);
    $('[name="nama_lengkap"]').attr('readonly', true);
    $('[name="user_name"]').attr('readonly', true);
    $('[name="password"]').attr('readonly', true);
    $('[name="confirm_password"]').attr('readonly', true);
    $('[name="user_group"]').attr('disabled', true);
    $('[name="alamat"]').attr('readonly', true);
    $('[name="daerah"]').attr('readonly', true);
    $('[name="no_hp"]').attr('readonly', true);

	$('[name="userid"]').removeClass('is-invalid');
    $('.help-block-userid').addClass('text-danger').text('');
	$('[name="nama_lengkap"]').removeClass('is-invalid');
    $('.help-block-nama_lengkap').addClass('text-danger').text('');
	$('[name="user_name"]').removeClass('is-invalid');
    $('.help-block-user_name').addClass('text-danger').text('');
	$('[name="password"]').removeClass('is-invalid');
    $('.help-block-password').addClass('text-danger').text('');
	$('[name="oid"]').removeClass('is-invalid');
    $('.help-block-oid').addClass('text-danger').text('');
	$('[name="karyawan_id"]').removeClass('is-invalid');
    $('.help-block-karyawan_id').addClass('text-danger').text('');
	$('[name="user_group"]').removeClass('is-invalid');
    $('.help-block-user_group').addClass('text-danger').text('');

    $('.password').hide();
    $('.confirm_password').hide();

    $('#oid').select2().next().show();
    $('#karyawan_id').select2().next().show();
    $('#user_group').select2().next().show();
    
    $('#btnSaveApp').hide();
});

$('#table1').on('click', '.nonactive_record', function() {
    var id = $(this).data('userid');
    var nama_lengkap = $(this).data('nama_lengkap');
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
                url: "<?php echo site_url('admin_user_apps/nonactive?id='); ?>" + id,
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
                        table_apps.ajax.reload();
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
    var id = $(this).data('userid');
    var nama_lengkap = $(this).data('nama_lengkap');
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
                url: "<?php echo site_url('admin_user_apps/reactive?id='); ?>" + id,
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
                        table_apps.ajax.reload();
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
        url = 'admin_user_apps/add';
    } else {
        url = 'admin_user_apps/update';
    }
    var formData = new FormData($('#form-admin_user_apps')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $('#modal-form-admin_user_apps').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Data berhasil disimpan...',
                    timer: 2000,
                    showCancelButton: false,
                    showConfirmButton: false
                }).then(function() {
                    table_apps.ajax.reload();
                    $('#modal-form-admin_user_apps').modal('hide');
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