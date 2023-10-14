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
                        <button class="btn btn-primary" onclick="create()">Tambah Data</button>
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
        </div>
      </div>
    </div>
  </div>
</div>
@endsection