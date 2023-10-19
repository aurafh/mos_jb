<table id="myTable" class="table table-striped">
    <thead>
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stock</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inventories as $invent)
            <tr>
                <td>{{ $invent->code }}</td>
                <td>{{ $invent->name }}</td>
                <td>{{ $invent->price }}</td>
                <td>{{ $invent->stock }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false"></button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" onclick="show({{ $invent->id }})">Edit</a></li>
                            <li><a class="dropdown-item" onclick="deleteData({{ $invent->id }})">Hapus</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
