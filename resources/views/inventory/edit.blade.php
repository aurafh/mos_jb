              <div class="row mb-3">
                  <label for="code" class="col-sm-4 col-form-label">Kode Barang</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="code" name="code" disabled value="{{ old('code', $inventori->code) }}">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="name" class="col-sm-4 col-form-label">Nama Barang</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $inventori->name) }}">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="price" class="col-sm-4 col-form-label">Price</label>
                  <div class="col-sm-8">
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $inventori->price) }}">
                  </div>
                </div>
                <div class="row mb-4">
                  <label for="stock" class="col-sm-4 col-form-label">Stock</label>
                  <div class="col-sm-8">
                    <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $inventori->stock) }}">
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <button class="btn btn-primary" onclick="update({{ $inventori->id }})">Update</button>
                  </div>
                </div>