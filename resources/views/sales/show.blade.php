<div class="row">
    <label for="number" class="col-sm-4 col-form-label"><b>Code</b></label>
    <div class="col-sm-8">
        : {{ $sales->number }}
    </div>
</div>
<div class="row">
    <label for="date" class="col-sm-4 col-form-label"><b>Date</b></label>
    <div class="col-sm-8">
        : {{ $sales->date }}
    </div>

    {{-- DetailPenjualan --}}
    <div>
        <table class="table table-striped" id="table">
            <tr>
                <th>Name</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Qty</th>
            </tr>
            @foreach ($sales->salesDetails as $detail)
                <tr>
                    <td>
                        {{ $detail->inventory->name }}
                    </td>
                    <td>
                        {{ $detail->inventory->stock }}
                    </td>
                    <td>
                        {{ $detail->price }}
                    </td>
                    <td>
                        {{ $detail->qty }}
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="row">
            <div class="col-6"><b>Total</b></div>
            <div class="col-6">
                : {{ $total }}
            </div>
        </div>
    </div>
