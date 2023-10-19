<form id="editSales">
    @csrf
    <input type="hidden" id="id_sales" name="id_sales" value="{{ $sales->id }}">
    <div class="row mb-3">
        <label for="number" class="col-sm-4 col-form-label"><b>Code</b></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="number" name="number" value="{{ $sales->number }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="date" class="col-sm-4 col-form-label"><b>Date</b></label>
        <div class="col-sm-8">
            <input type="date" class="form-control" id="date" name="date"
                value="{{ old('date', $sales->date) }}">
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
            @foreach ($sales->salesDetails as $key => $detail)
                <tr>
                    {{-- <input type="hidden" id="id_details" name="id_details"> --}}
                    <td>
                        <select class="form-select" id="basic-usage" name="id[{{ $key }}]"
                            data-placeholder="Choose one thing">
                            <option></option>
                            @foreach ($barang as $item)
                                <option value="{{ old('id', $item->id) }}"
                                    @if ($detail->inventory->id == $item->id) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" class="form-control" id="stockBarang" name="stock[{{ $key }}]"
                            @readonly(true) value="{{ $detail->inventory->stock }}">
                    </td>
                    <td><input type="number" class="form-control" id="price" name="price[{{ $key }}]"
                            value="{{ old('price', $detail->price) }}"></td>
                    <td><input type="number" class="form-control" id="qty" name="qty[{{ $key }}]"
                            value="{{ old('qty', $detail->qty) }}"></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" id="remove">DELETE</button>
                    </td>
                </tr>
            @endforeach

        </table>
        <div class="row">
            <div class="col-6">Total</div>
            <div class="col-6">
                <input type="number" class="form-control" id="total" name="total" value="{{ $total }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            <button class="btn btn-primary" type="submit">Update</button>
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

    // $(".totalPrice").keyup(function() {
    //     var qty = parseInt($("#qty").val())
    //     var price = parseInt($("#price").val())
    //     var total = price * qty;
    //     $("#total").attr("value", total);

    // });
</script>
