<form id="createSales" method="POST">
    @csrf
    <div class="row mb-3">
        <label for="number" class="col-sm-4 col-form-label"><b>Code</b></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="number" name="number" value="{{ $number }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="date" class="col-sm-4 col-form-label"><b>Date</b></label>
        <div class="col-sm-8">
            <input type="date" class="form-control" id="date" name="date">
        </div>
    </div>

    {{-- DetailPenjualan --}}
    <div>
        <table class="table table-striped" id="table">
            <tr>
                <th>Name</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Qty</th>
                <th>
                    <button class="btn btn-success btn-sm" type="button" name="add" id="add">ADD</button>
                </th>
            </tr>
            <tr>
                <td>
                    <select class="form-select" id="basic-usage" name="id[]" data-placeholder="Choose one thing">
                        <option></option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" class="form-control" id="stockBarang" name="stock[]" @readonly(true)>
                </td>
                <td><input type="number" class="form-control" id="price" name="price[]"></td>
                <td><input type="number" class="form-control" id="qty" name="qty[]"></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" id="remove">DELETE</button>
                </td>
            </tr>
        </table>
        <div class="row">
            <div class="col-6">Total</div>
            <div class="col-6">
                <input type="number" class="form-control" id="total" name="total">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="btn btn-primary" type="submit">SAVE</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Fungsi untuk menghitung total
        function calculateTotal() {
            var total = 0;
            $('tr').each(function() {
                var price = parseInt($(this).find('#price').val()) || 0;
                var qty = parseInt($(this).find('#qty').val()) || 0;
                var itemTotal = price * qty;
                $(this).find('#total').val(itemTotal);
                total += itemTotal;
            });
            // Menampilkan total akumulasi di luar tabel
            $('#total').val(total);
        }

        // Memanggil fungsi calculateTotal saat input berubah
        $('#price, #qty').on('keyup', calculateTotal);
    });
</script>
