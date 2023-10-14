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
                    <div class="col-6">
                        <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary">CSV</button>
                        <button type="button" class="btn btn-outline-secondary">Excel</button>
                        <button type="button" class="btn btn-outline-secondary">PDF</button>
                        </div>
                    </div>
                    <div class="col-6 d-md-flex justify-content-md-end">
                        <a href="{{ route('sales.create') }}" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">Tambah Data</a>
                    </div>
                 </div>
            </div>
            <div class="table-responssive">
            <table class="table table-striped mt-2">
            <thead>
              <tr>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Nama Saler</th>
                <th>Total</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($sales as $sale)
              <tr>
                <td>{{ $sale->number }}</td>
                <td>{{ $sale->date }}</td>
                <td>{{ $sale->number }}</td>
                <td>{{ $sale->date }}</td>
                <td>
                    <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{ route('sales.edit', $sale->id) }}">Edit</a></li>
                      <li>
                        <form method="POST" action="{{ route('sales.destroy', $sale->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn dropdown-item" type="submit">Hapus</button>
                        </form>
                      </li>
                    </ul>
                  </div>
                </td>
            </tr>    
              @endforeach
        </tbody>
    </table>
</div>
    </div>
    </div>
    </div>
    </div>
@endsection