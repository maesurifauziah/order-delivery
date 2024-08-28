<script>
    var base_url = "<?php echo base_url(); ?>";
    $(document).ready(function() {
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};

        $(document).on('shown.bs.modal', function(e) {
            $.fn.dataTable.tables({
                visible: true,
                api: true
            }).columns.adjust();
            $('body').css('padding-right', '');
        });

        $(document).on('shown.bs.collapse', function() {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $(document).on('hidden.bs.modal', '.modal', function() {
            $('.modal:visible').length && $(document.body).addClass('modal-open');
            $('body').css('padding-right', '');
        });

        $('.select2').select2({
            placeholder: '--Select--',
            width: '100%'
        });

        // $('.select2bs4').select2({
        //     theme: 'bootstrap4',
        //     placeholder: '--Select--',
        //     width: '100%'
        // });

        // $('.select2').each(function() { 
        //     $(this).select2({ dropdownParent: $(this).parent()});
        // })

        let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;

        if (isMobile) {
            $('.show-sidebar').html('');
            $('.image-hight').attr("height", "90px");
            // $('.tg-img').attr("style", "height:6rem");
        } else {
            $('.show-sidebar').html('<li class="nav-item">'+
                '<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>'+
            '</li>');
            $('.image-hight').attr("height", "auto");
            // $('.tg-img').attr("style", "height:16rem");
        }


    });

    $("input").change(function() {
        $(this).removeClass('is-invalid');
        $(this).next().empty();
    });

    $("textarea").change(function() {
        $(this).removeClass('is-invalid');
        $(this).next().empty();
    });

    $("select").change(function() {
        $(this).removeClass('is-invalid');
        $(this).next().empty();
    });

    $(".select2").on("select2:select select2:unselecting", function() {
        $('.select2').select2({
            placeholder: '--Select--',
            width: '100%'
        });
    });


    function ucwords(str) {
        return (str + '').replace(/_/g, ' ').replace(/^([a-z])|\s+([a-z])/g, function($1) {
            return $1.toUpperCase();
        });
    }

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    }

    String.prototype.reverse = function() {
        return this.split("").reverse().join("");
    }

    function reformatText(input) {
        var x = input.value;
        x = x.replace(/,/g, ""); // Strip out all commas
        x = x.reverse();
        x = x.replace(/.../g, function(e) {
            return e + ",";
        }); // Insert new commas
        x = x.reverse();
        x = x.replace(/^,/, ""); // Remove leading comma
        input.value = x;
    }

    var intVal = function(i) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '') * 1 :
            typeof i === 'number' ?
            i : 0;
    };

    function onlyNumberKey(evt) {
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

    function separatorRibuan(_id) {
        var nilai = document.getElementById(_id.target.id);
        nilai.addEventListener('keyup', function(e) {
            nilai.value = formatRupiah(this.value);
        });
    }

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function persentaseP(hpp, harga) {
        var p = 0;
        var h = (intVal(harga) - intVal(hpp));
        p = (intVal(h) / intVal(hpp)) * 100;
        return p;
    }

    function persentaseH(hpp, persen) {
        var p = 0;
        var h = intVal(hpp) + intVal(hpp * (persen / 100));
        p = intVal(h);
        return p;
    }

    function diskonP(hj, diskon) {
        var p = 0;
        var h = intVal(hj) - (intVal(hj) - intVal(diskon));
        p = (intVal(h) / intVal(hj)) * 100;
        return p;
    }

    function diskonH(hj, persen) {
        var p = 0;
        var h = intVal(hj * (persen / 100));
        p = intVal(h);
        return p;
    }
</script>