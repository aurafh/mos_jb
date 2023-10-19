@extends('partials.main')

@section('content')
    <div class="main bg-light py-3">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="card-title py-2">
                        <h5>Data Inventori</h5>
                    </div>
                    <div class="card-description">
                        <div class="row">
                            <div class="col mb-3">
                                <button class="btn btn-primary" id="add-button">Tambah Data</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responssive"id="readData">
                        {{-- Table Data Inventory --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="page">
                        {{-- Form --}}
                        @include('inventory.create')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit-->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
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
@endsection

@section('script')
<script>
        $(document).ready(function() {
            $("#add-button").on('click', function() {
            $("#createModal").modal('show');
            $("#ModalLabel").text('Tambah Data Inventory');
        });
        });

        //read data
        function read() {
            $.get("{{ url('baca') }}", {}, function(data, status) {
                $("#readData").html(data);
                $('#myTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                });
            });
        }

        //proses create
        function store() {
            var code = $('#code').val();
            var name = $('#name').val();
            var price = $('#price').val();
            var stock = $('#stock').val();
            $.ajax({
                type: "POST",
                url: "{{ route('inventory.store') }}",
                data: {
                    code: code,
                    name: name,
                    price: price,
                    stock: stock,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
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
        function show(id) {
            $.get("{{ url('/inventory') }}/" + id + "/edit", {}, function(data, status) {
                $("#ModalLabel").html("Edit Data Inventori")
                $("#page").html(data);
                $("#createModal").modal('show');
            });
        }

        //proses update data
        function update(id) {
            var code = $('#code').val();
            var name = $('#name').val();
            var price = $('#price').val();
            var stock = $('#stock').val();
            $.ajax({
                type: "POST",
                url: "{{ url('/inventory') }}/" + id,
                data: {
                    code: code,
                    name: name,
                    price: price,
                    stock: stock,
                    _token: "{{ csrf_token() }}",
                    _method: "PUT"
                },
                success: function(data) {
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
        function deleteData(itemID) {
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
                        url: "{{ url('/inventory') }}/" + itemID,
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        success: function(data) {
                            $(".btn-close").click();
                            Swal.fire('Data Terhapus', '', 'success');
                            read()
                        }
                    });
                }
            });
        };
    </script>
@endsection