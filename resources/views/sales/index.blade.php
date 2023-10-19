@extends('partials.main')

@section('content')
    <div class="main bg-light py-3">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="card-title py-2">
                        <h5>Data Sales</h5>
                    </div>
                    <div class="card-description">
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary mb-3" onclick="createForm()">Tambah Data</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responssive" id="readData">
                        {{-- Table Data Sales --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="page">
                        {{-- Form --}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        //read data
        function read() {
            $.get("{{ url('read') }}", {}, function(data, status) {
                $("#readData").html(data);
                $('#myTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                });
            });

        }

        //modal create
        function createForm() {
            $.get("{{ route('sales.create') }}", {}, function(data, status) {
                $("#ModalLabel").html("Tambah Data Sales")
                $("#page").html(data);
                $("#createModal").modal('show');

            });
        }

        function showDetails(id) {
            $.get("{{ url('/sales') }}/" + id, {}, function(data, status) {
                $("#ModalLabel").html("Detail Data Sales")
                $("#page").html(data);
                $("#createModal").modal('show');

            });
        }

        //proses show edit
        function show(id) {
            $.get("{{ url('/sales') }}/" + id + "/edit", {}, function(data, status) {
                $("#ModalLabel").html("Edit Data Sales")
                $("#page").html(data);
                $("#createModal").modal('show');
            });
        }

        //proses delete data
        function deleteSales(itemID) {
            var itemId = $(this).data('id');
            Swal.fire({
                title: 'Hapus Data',
                text: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST", // Gunakan metode DELETE
                        url: "/sales/" + itemID,
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        success: function(response) {
                            console.log("hapus");
                            $(".btn-close").click();
                            Swal.fire('Data Terhapus', '', 'success');
                            read()
                        },
                    });
                }
            });
        };
    </script>
@endsection
