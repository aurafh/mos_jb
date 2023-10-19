<table class="table table-striped" id="myTable">
    <thead>
        <tr>
            <th>Kode Transaksi</th>
            <th>Tanggal</th>
            <th>Nama Sales</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale->number }}</td>
                <td>{{ $sale->date }}</td>
                <td>{{ $sale->user->name }}</td>
                <td>{{ $sale->date }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false"></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" onclick="showDetails({{ $sale->id }})">Details</a>
                            </li>
                            <li><a class="dropdown-item" onclick="show({{ $sale->id }})">Edit</a></li>
                            <li><a class="dropdown-item" onclick="deleteSales({{ $sale->id }})">Hapus</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
