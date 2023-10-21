<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Inventories;
use App\Models\Sales;
use App\Models\SalesDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang=Inventories::all();
        return view('sales.index',['barang'=>$barang]);
    }
    
    public function read()
    {
        return view('sales.read', [
            'sales' => Sales::all()
        ]);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $barang=Inventories::all();
    //     return view('sales.create',[
    //         'barang'=>$barang
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

        $sales = new Sales();
        $sales->number = Helper::IDGenerator(new Sales(), 'code', 3, 'SC');
        $sales->date = $params['date'];
        $sales->user_id = Auth::user()->id;
        $sales->save();

        $salesDetails = [];

        foreach ($params['id'] as $key => $inventoryId) {
            $salesDetails[] = [
                'sales_id' => $sales->id,
                'inventory_id' => $inventoryId,
                'qty' => $params['qty'][$key],
                'price' => $params['price'][$key],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        SalesDetails::insert($salesDetails);

        foreach ($request->id as $key => $id) {
        $inventoryId = $id;
        $qty = $request->qty[$key];

        $inventory = Inventories::find($inventoryId);

        if ($inventory) {
            $newStock = $inventory->stock - $qty;
            $newStock = ($newStock < 0) ? 0 : $newStock;

            $inventory->stock = $newStock;
            $inventory->save();
        }
    }

        return response()->json(['message' => 'Data Sales berhasil disimpan']);
    
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales=Sales::find($id);
        $sales_details=SalesDetails::where('sales_id',$id)->get();
        if($sales_details){
            $total = 0;
            $totalPrice = 0;
            foreach ($sales_details as $sales_detail) {
                $total += $sales_detail->price * $sales_detail->qty;
                $totalPrice+=$total;

            }
        }
         return response()->json([
            'totalPrice'=>$totalPrice,
            'sales'=>$sales,
            'sales_details' => $sales_details
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
        $sales=Sales::find($id);
        $sales_details=SalesDetails::where('sales_id',$id)->get();
        $inventory=Inventories::all();
         return response()->json([
            'sales'=>$sales,
            'sales_details' => $sales_details,
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
        $sales = Sales::findOrFail($id);

        if (!$sales) {
            return response()->json(['message' => 'Sales tidak ditemukan'], 404);
        }

        $sales->number = $params['number'];
        $sales->date = $params['date'];
        $sales->update();
        $sales_details=SalesDetails::where('sales_id', $id)->get();
        foreach ($sales_details as $detail) {
            $detail->delete();
        }

        $salesDetails = [];

        foreach ($params['id'] as $key => $inventoryId) {
            $salesDetails[] = [
                'sales_id' => $id,
                'inventory_id' => $inventoryId,
                'qty' => $params['qty'][$key],
                'price' => $params['price'][$key],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        SalesDetails::insert($salesDetails);

        // Perbarui stok barang
        foreach ($request->id as $key => $id) {
        $inventoryId = $id;
        $newQty = $request->qty[$key];

        $salesDetail = SalesDetails::where('sales_id', $id)->first();

        if ($salesDetail) {
            $oldQty = $salesDetail->qty;
            $qtyDiff = $newQty - $oldQty;
            $inventory = Inventories::find($inventoryId);

            if ($inventory) {
                $newStock = $inventory->stock - $qtyDiff;
                $newStock = ($newStock < 0) ? 0 : $newStock;

                $inventory->stock = $newStock;
                $inventory->update();
            }
        }
    }
        return response()->json(['message' => 'Data Sales berhasil diperbarui']);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sales = Sales::find($id);

        if (!$sales) {
            return redirect('/sales')->with('error', 'Pembelian tidak ditemukan!');
        }

        $salesDetails = SalesDetails::where('sales_id', $id)->get();

        foreach ($salesDetails as $detail) {
            $inventory = Inventories::find($detail->inventory_id);
            if ($inventory) {
                $inventory->stock += $detail->qty;
                $inventory->save();
            }

            $detail->delete();
        }

        $sales->delete();

            return response()->json(['message' => 'Pembelian dan item pembelian berhasil dihapus']);
    }
}
