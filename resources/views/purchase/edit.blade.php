<form id="updateForm" method="POST">
    @csrf
    @method('put')
    <input type="hidden" id="id_purchase" name="id_purchase" value="">
    <div class="row mb-3">
        <label for="number" class="col-sm-4 col-form-label"><b>Code</b></label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="number" name="number" value="{{ old('number') }}" disabled>
        </div>
    </div>
    <div class="row mb-3">
        <label for="date" class="col-sm-4 col-form-label"><b>Date</b></label>
        <div class="col-sm-8">
            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped" id="general_comments">
            <thead>
                <tr>
                    <th width="30%">Name</th>
                    <th width="20%">Stock</th>
                    <th width="15%">Price</th>
                    <th width="15%">Qty</th>
                    <th width="15%">Total</th>
                    <th width="5%">
                        <button class="btn btn-success" type="button" id="btn-add-row">ADD</button>
                    </th>
                    </tr>
            </thead>
            <tbody id="table-content-edit">
                
            </tbody>
            </table>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6"><b>Total Price</b></div>
        <div class="col-6">
            <input type="number" class="form-control" id="totalPrice" readonly disabled>
        </div>
    </div>
        <button class="btn btn-primary" type="submit">UPDATE</button>
</form>

