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
        $sales=Sales::latest()->get();

        return view('sales.read', [
            'sales' => $sales
        ]);
    }

    public function stockBarang(Request $request)
    {
        $p = Inventories::select('stock')->where('id',$request->id)->first();       
        return response()->json($p);
    
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $number=Helper::IDGenerator(new Sales, 'code', 3, 'KJ');
        $barang=Inventories::all();
        return view('sales.create',[
            'number'=>$number,
            'barang'=>$barang
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userID=Auth::user()->id;
        $sale = new Sales();
        $sale->number = $request->input('number');
        $sale->date = $request->input('date');
        $sale->user_id = $userID;
        $sale->save();

    foreach ($request->id as $key => $id) {
        SalesDetails::create([
            'sales_id' => $sale->id,
            'inventory_id' => $id,
            'qty' => $request->input('qty')[$key],
            'price' => $request->input('price')[$key] 
        ]);
    }
        return redirect('/sales')->with('toast_success', 'Data Inventori berhasil ditambahkan!');
    
}
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales=Sales::findOrFail($id);
        $sales_detail=SalesDetails::where('sales_id',$id)->get();
        if($sales_detail){
            $totalPrice = 0;
            foreach ($sales_detail as $sales_detail) {
                $totalPrice += $sales_detail->price * $sales_detail->qty;
            }
        }
        return view('sales.show',[
        'sales'=>$sales,
        'total'=>$totalPrice
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
        // $number=Helper::IDGenerator(new Sales, 'code', 3, 'KJ');
        $barang=Inventories::all();
        $sales=Sales::findOrFail($id);
        $sales_detail=SalesDetails::where('sales_id',$id)->get();
        if($sales_detail){
            $totalPrice = 0;
            foreach ($sales_detail as $sales_detail) {
                $totalPrice += $sales_detail->price * $sales_detail->qty;
            }
        }
        return view('sales.edit',[
            'sales'=>$sales,
            'total'=>$totalPrice,
            'barang'=>$barang
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
        
    $userID = Auth::user()->id;

    // Temukan penjualan yang akan diupdate
    $sale = Sales::findOrFail($id);
    $sale->number = $request->input('number');
    $sale->date = $request->input('date');
    $sale->user_id = $userID;
    $sale->save();

    // Hapus detail penjualan yang ada terlebih dahulu
    $sale->salesDetails()->delete();

    // Loop melalui setiap detail penjualan yang diberikan dan tambahkan yang baru
    foreach ($request->input('id') as $key => $id) {
        SalesDetails::create([
            'sales_id' => $sale->id,
            'inventory_id' => $id,
            'qty' => $request->input('qty')[$key],
            'price' => $request->input('price')[$key]
        ]);
    }
    return redirect('/sales')->with('toast_success', 'Data Inventori berhasil diubah!');
    // return response()->json($sale);

    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sales_details=SalesDetails::where('sales_id',$id)->get();
        foreach ($sales_details as $detail) {
            $detail->delete();
        }
        $sales=Sales::findOrFail($id);
        $sales->delete();
        return redirect('/sales')->with('success','Data Sales berhasil dihapus!');
    }
}
