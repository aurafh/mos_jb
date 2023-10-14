<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
  </head>
  <body>
    @include('layouts.navbar')

    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script>
      $(document).ready(function() {
        read()
      });
      
      // let table = new DataTable('#myTable');
      //read data
      function read(){
        $.get("{{ url('read') }}",{}, function(data,status){
          $("#readData").html(data);
          $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
          });
        });
      }


      //modal create
      function create(){
        $.get("{{ route('inventory.create') }}",{}, function(data,status){
          $("#ModalLabel").html("Tambah Data Inventori")
          $("#page").html(data);
          $("#createModal").modal('show');
        });
      }

      //proses create
      function store(){
        var code = $('#code').val();
        var name = $('#name').val();
        var price = $('#price').val();
        var stock = $('#stock').val();
        $.ajax({
          type: "POST",
          url:"{{ route('inventory.store') }}",
          data: {
            code: code,
            name: name,
            price: price,
            stock: stock,
            _token: "{{ csrf_token() }}"
          },
          success: function(data){
            Swal.fire({
                title: 'Sukses',
                text: 'Data Inventori berhasil disimpan.',
                icon: 'success',
            }).then(function() {
                $(".btn-close").click();
                read();
            });

            // $(".btn-close").click();
            // read()
          }
        });
      }

      //proses show edit
      function show(id){
        $.get("{{ url('/inventory') }}/"+ id + "/edit",{}, function(data,status){
          $("#ModalLabel").html("Edit Data Inventori")
          $("#page").html(data);
          $("#createModal").modal('show');
        });
      }

      //proses update data
      function update(id){
        var code = $('#code').val();
        var name = $('#name').val();
        var price = $('#price').val();
        var stock = $('#stock').val();
        $.ajax({
          type: "POST",
          url:"{{ url('/inventory') }}/" + id,
          data: {
            code: code,
            name: name,
            price: price,
            stock: stock,
            _token: "{{ csrf_token() }}",
            _method: "PUT"
          },
          success: function(data){
            Swal.fire({
                title: 'Sukses',
                text: 'Data Inventori berhasil diubah.',
                icon: 'success',
            }).then(function() {
                $(".btn-close").click();
                read();
            });
          }
        });
      }

      //proses delete data
      function deleteData(itemID){
        $('.delete-confirm').on('click', function () {
            var itemId = $(this).data('id');
            Swal.fire({
                title: 'Hapus Data',
                text: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                  type: "POST",
                  url:"{{ url('/inventory') }}/" + itemID,
                  data: {
                  _token: "{{ csrf_token() }}",
                  _method: "DELETE"
            },
            success: function(data){
            $(".btn-close").click();
            Swal.fire('Data Terhapus', '', 'success');
            read()
            }
            });
          }
        });
      });
    }
      </script>
    @include('sweetalert::alert')

  </body>
</html>