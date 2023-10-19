@extends('partials.main')

@section('content')
    <div class="main bg-light py-3">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="card-title py-2">
                        <h5>Data Purchase</h5>
                    </div>
                    <div class="card-description">
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary mb-3" id="add-button">Tambah Data</button>
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
    <div class="modal fade bd-example-modal-xl" id="createModal" tabindex="-1" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalLabel">Modal label</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="page">
                        {{-- Form --}}
                        @include('purchase.create')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#add-button").on('click', function() {
            $("#createModal").modal('show');
            $("#ModalLabel").text('Tambah Data Purchase');
        });

        //read data
        function read() {
            $.get("{{ url('lihat') }}", {}, function(data, status) {
                $("#readData").html(data);
                $('#myTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                });
            });

        }

        function showDetails(id) {
            $.get("{{ url('/sales') }}/" + id, {}, function(data, status) {
                $("#ModalLabel").html("Detail Data Purchase")
                $("#page").html(data);
                $("#createModal").modal('show');

            });
        }

        //proses show edit
        function show(id) {
            $.get("{{ url('/sales') }}/" + id + "/edit", {}, function(data, status) {
                $("#ModalLabel").html("Edit Data Purchase")
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

    <script type="text/javascript">
    let rowCount = 0;

    $(document).on("click", '#btn-add-row', function() {
        let div = $("<tr>");
        div.html(addRow());
        $("#table-content").append(div);
        $('#inventory_id_' + rowCount).select2({
            dropdownParent: $('#createModal')
        }).on('change', function() {

        var selectedOption = $('option:selected', this);
        var stock = selectedOption.data('stock');
        var rowValue = $(this).data("index");
        console.log('index saat ini:', rowValue);
        console.log('Row saat ini:', rowCount);

        $('#stock_value_' + rowValue).val(stock);
        });

        buildProducts('#inventory_id_' + rowCount);

        rowCount++;
    });

    

    function addRow() {
        let cols = '';

        cols += '<td>';
        cols += '    <select class="form-select" id="inventory_id_' + rowCount + '" data-index="' + rowCount + '" name="id[]">';
        cols += '        <option value="0"> Pilih Barang </option>';
        cols += '    </select>';
        cols += '</td>';
        cols += '<td>';
        cols += '   <input type="text" class="form-control" id="stock_value_' + rowCount + '" value="0" readonly disabled>';
        cols += '</td>';
        cols += '<td>';
        cols += '   <input type="number" class="form-control" id="qty_value_' + rowCount + '" name="price[]" placeholder="0" onchange="calculate(this)">';
        cols += '</td>';
        cols += '<td>';
        cols += '   <input type="number" class="form-control" id="price_value_' + rowCount + '" name="qty[]" placeholder="0" onchange="calculate(this)">';
        cols += '</td>';
        cols += '<td>';
        cols += '   <input type="number" class="form-control total" id="total_value_' + rowCount + '" value="0" readonly disabled>';
        cols += '</td>';
        cols +=
            '<td><button type="button" class="btn btn-danger" id="delete-row">DELETE</button></td>';

        return cols;
    }

    function buildProducts(element) {
        $.ajax({
            url: '/get-inventory',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var selectElement = $(element);
                selectElement.empty(); 
                selectElement.append($('<option>', {
                    value: 0,
                    text: 'Pilih Barang'
                }));

                $.each(data, function(index, inventory) {
                   var option =$('<option>', {
                        value: inventory.id,
                        text: inventory.name
                    });

                   option.attr("data-stock",inventory.stock);
                   selectElement.append(option);
                });
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function calculate(element){
        var index = $(element).closest('tr').index();
        var qty = $('#qty_value_' + index).val();
        var price = $('#price_value_' + index).val();
        var total = qty*price;
        $('#total_value_' + index).val(total);

        var totalPrice=0;
        $('.total').each(function() {
            var totalValue = parseFloat($(this).val());
            totalPrice =+(totalPrice)+ +(totalValue);
        });

        console.log(totalPrice);
        $('#totalPrice').val(totalPrice);
    }

    
    $(document).on("click", "#delete-row", function() {
        $(this).closest("tr").remove();
    });

    $(document).ready(function(){
            $('#addForm').submit(function (e) {
            e.preventDefault(); 

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: '/purchase', 
                data: formData,
                dataType: 'json',
                success: function (response) {
                    Swal.fire({
                        title: 'Sukses',
                        text: 'Data pembelian berhasil disimpan.',
                        icon: 'success',
                    }).then(function () {
                        $(".btn-close").click();
                        read();
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseJSON);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menyimpan data.',
                    });
                },
            });
        });
});
    
</script>

@endsection
