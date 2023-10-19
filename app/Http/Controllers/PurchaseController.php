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
        $number=Helper::IDGenerator(new Purchases(), 'code', 3, 'KJ');
        $barang=Inventories::all();
        return view('purchase.index',[
            'barang'=>$barang,
            'number'=>$number
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

        // Buat objek pembelian
        $purchase = new Purchases();
        $purchase->number = $params['number'];
        $purchase->date = $params['date'];
        $purchase->user_id = Auth::user()->id; // Anda bisa sesuaikan dengan user yang sedang login
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

        return response()->json(['message' => 'Data pembelian berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
