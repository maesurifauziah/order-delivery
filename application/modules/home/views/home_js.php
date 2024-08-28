<script>
function startbody() {
    loadPage('dashboard');
    // startTime();
}

// function startTime() {
//     var today = new Date();
//     var h = today.getHours();
//     var m = today.getMinutes();
//     var s = today.getSeconds();
//     m = checkTime(m);
//     s = checkTime(s);
//     document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
//     var t = setTimeout(startTime, 500);
// }

// function checkTime(i) {
//     if (i < 10) {
//         i = "0" + i
//     }; // add zero in front of numbers < 10
//     return i;
// }

function loadPage(page) {
    Swal.fire({
        title: '',
        html: '<div class="spinner-grow text-primary text-center" style="width: 3rem; height: 3rem;" role="status"> <span class="sr-only">Loading...</span> </div> <br> Loading...',
        showCancelButton: false,
        showConfirmButton: false,
    });
    $("#loadBody").load(page, function(response, status, xhr) {
        if (response == '') {
            window.location.href="<?php echo base_url();?>";
            return;
        }
        $('head title', window.parent.document).text("OD" + ' | ' + ucwords(page));
    });
    Swal.close();
}

function logout() {
    $.ajax({
        url: "<?php echo site_url('login/logout'); ?>",
        method: "GET",
        success: function(data) {
            location.reload();
        }
    });
}

function savePassword() {
    $('#btnSavePass').text('Saved...');
    $('#btnSavePass').attr('disabled', true);
    var url = "<?php echo site_url('home/change_password'); ?>";
    var formData = new FormData($('#form-change-password')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $('#modal-change-password').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.message,
                    timer: 2000,
                    showCancelButton: false,
                    showConfirmButton: false
                }).then(function() {
                    $('#form-change-password')[0].reset();
                    Swal.close();
                    logout();
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Failed',
                    text: data.message,
                    showCancelButton: false,
                });
            }
            $('#btnSavePass').text('Save');
            $('#btnSavePass').attr('disabled', false);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
            $('#btnSavePass').text('Save');
            $('#btnSavePass').attr('disabled', false);
        }
    });
}
</script>