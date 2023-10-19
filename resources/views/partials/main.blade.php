<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
</head>

<body>
    @include('layouts.navbar')

    @yield('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    @yield('script')
    <script>
    $(document).ready(function() {
            read(); //readData

            $('#basic-usage').select2({ //select2Data
                theme: "bootstrap-5",
                allowClear: true,
                placeholder: $(this).data('placeholder'),
            });

            var j = 0;
            $(document).on('change', '#basic-usage', function() { //stokShow
                ++j;
                var barang_id = $(this).val();
                var a = $(this).parents();
                console.log(barang_id);
                var op = "";
                $.ajax({
                    type: 'get',
                    url: "{{ url('stock/') }}",
                    data: {
                        'id': barang_id
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log("stock");
                        console.log(data.stock);
                        a.find('#stockBarang').val(data.stock);
                    },
                });
            });
        });

        // $(document).ready(function() {});
        var i = 0;
        $(document).on('click', '#add', function() {
            ++i;
            $('#table').append(
                `<tr>
                        <td>
                        <select class="form-select" id="basic-usage" name="id[]" data-placeholder="Choose one thing">
                        <option value="0">Pilih Barang</option>
                        </select>
                        </td>
                        <td><input type="number" class="form-control" id="stockBarang" name="stock[]" @readonly(true)></td>
                        <td><input type="number" class="form-control" id="price" name="price[]"></td>
                        <td><input type="number" class="form-control" id="qty" name="qty[]"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" id="remove">DELETE</button></td>
                    </tr>`);
        });

        $(document).on('click', '#remove', function() {
            $(this).parents('tr').remove();
        });


$(document).ready(function() {

$('.logout').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/logout', 
            data: {
             _token: '{{ csrf_token() }}'  
            },
            success: function (response) {
              Swal.fire({
              icon: 'success',
              title: 'Logout Success',
              text: 'Logout telah berhasil, silahkan kembali nanti!'
              }).then(function () {
                window.location.href = '/';
              });
            },
            error: function () {
                Swal.fire({
                icon: 'error',
                title: 'Logout Failed',
                text: 'Maaf, logout tidak berhasil!.'
                });
            }
        });
    });

            //proses create
            $("#createSales").on("submit", function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "/sales", // Sesuaikan dengan URL Anda
                    data: formData,
                    success: function(response) {
                        console.log("baru");
                        Swal.fire({
                            title: 'Sukses',
                            text: 'Data Sales berhasil disimpan.',
                            icon: 'success',
                        }).then(function() {
                            $(".btn-close").click();
                            read();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            //proses update data
            $("#editSales").on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var id = $("#id_sales").val();

                $.ajax({
                    type: "PUT", // Menggunakan metode PUT
                    url: "/sales/" + id, // Sesuaikan dengan URL pembaruan
                    headers: {
                        'Authorization': TOKEN,
                    },
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        Swal.fire({
                            title: 'Sukses',
                            text: 'Data Sales berhasil diupdate.',
                            icon: 'success',
                        }).then(function() {
                            // Menutup modal
                            $(".btn-close").click();
                            read();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });


            
    });
    </script>
</body>

</html>
