<script>
    function save() {
    $('#btnSaveApp').text('Saving...');
    $('#btnSaveApp').attr('disabled', true);
    url = 'login/register';
    var formData = new FormData($('#form-register')[0]);
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data) {
            if (data.status) {
                $('#modal-form-register').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Data berhasil disimpan...',
                    timer: 2000,
                    showCancelButton: false,
                    showConfirmButton: false
                }).then(function() {
                    $('#modal-form-register').modal('hide');
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