<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Inventories;
use App\Models\Purchases;
use App\Models\PurchaseDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang=Inventories::all();
        return view('purchase.index',[
            'barang'=>$barang,
        ]);
    }

    public function read()
    {
        return view('purchase.read', [
            'purchases' => Purchases::all()
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('purchase.create',[
    //     ]);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->all();

        $purchase = new Purchases();
        $purchase->number = Helper::IDGenerator(new Purchases(), 'code', 3, 'PC');
        $purchase->date = $params['date'];
        $purchase->user_id = Auth::user()->id;
        $purchase->save();

        $purchaseDetails = [];

        foreach ($params['id'] as $key => $inventoryId) {
            $purchaseDetails[] = [
                'purchase_id' => $purchase->id,
                'inventory_id' => $inventoryId,
                'qty' => $params['qty'][$key],
                'price' => $params['price'][$key],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        PurchaseDetails::insert($purchaseDetails);

        foreach ($request->id as $key => $id) {
        $inventoryId = $id;
        $qty = $request->qty[$key];

        $inventory = Inventories::find($inventoryId);

        if ($inventory) {
            $newStock = $inventory->stock + $qty;
            $newStock = ($newStock < 0) ? 0 : $newStock;

            $inventory->stock = $newStock;
            $inventory->save();
        }
    }

        return response()->json(['message' => 'Data Purchases berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase=Purchases::find($id);
        $purchase_details=PurchaseDetails::where('purchase_id',$id)->get();
        if($purchase_details){
            $total = 0;
            $totalPrice = 0;
            foreach ($purchase_details as $purchase_detail) {
                $total += $purchase_detail->price * $purchase_detail->qty;
                $totalPrice+=$total;

            }
        }
         return response()->json([
            'totalPrice'=>$totalPrice,
            'purchase'=>$purchase,
            'purchase_details' => $purchase_details
         ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase=Purchases::find($id);
        $purchase_details=PurchaseDetails::where('purchase_id',$id)->get();
        $inventory=Inventories::all();
         return response()->json([
            'purchase'=>$purchase,
            'purchase_details' => $purchase_details,
            'inventory' => $inventory,
            'status'=>'success'
         ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();
        $purchase = Purchases::findOrFail($id);

        if (!$purchase) {
            return response()->json(['message' => 'Purchase tidak ditemukan'], 404);
        }
        
        $purchase_details=PurchaseDetails::where('purchase_id', $id)->get();
        foreach ($purchase_details as $detail) {
            $detail->delete();
        }

        $purchase->number = $params['number'];
        $purchase->date = $params['date'];
        $purchase->update();
        
        $purchaseDetails = [];

        foreach ($params['id'] as $key => $inventoryId) {
            $purchaseDetails[] = [
                'purchase_id' => $id,
                'inventory_id' => $inventoryId,
                'qty' => $params['qty'][$key],
                'price' => $params['price'][$key],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        PurchaseDetails::insert($purchaseDetails);

        // Perbarui stok barang
        foreach ($request->id as $key => $id) {
        $inventoryId = $id;
        $newQty = $request->qty[$key];

        $purchaseDetail = PurchaseDetails::where('purchase_id', $id)->first();

        if ($purchaseDetail) {
            $oldQty = $purchaseDetail->qty;
            $qtyDiff = $newQty - $oldQty;
            $inventory = Inventories::find($inventoryId);

            if ($inventory) {
                $newStock = $inventory->stock + $qtyDiff;
                $newStock = ($newStock < 0) ? 0 : $newStock;

                $inventory->stock = $newStock;
                $inventory->update();
            }
        }
    }
        return response()->json(['message' => 'Data Purchase berhasil diperbarui']);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Purchases::find($id);

        if (!$purchase) {
            return redirect('/purchase')->with('error', 'Pembelian tidak ditemukan!');
        }

        $purchaseDetails = PurchaseDetails::where('purchase_id', $id)->get();

        foreach ($purchaseDetails as $detail) {
            $inventory = Inventories::find($detail->inventory_id);
            if ($inventory) {
                $inventory->stock -= $detail->qty;
                $inventory->save();
            }

            $detail->delete();
        }

        $purchase->delete();

            return response()->json(['message' => 'Pembelian dan item pembelian berhasil dihapus']);
    }
 
}
