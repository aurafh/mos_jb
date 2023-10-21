<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Inventories;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;


class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang=Inventories::all();
        return view('inventory.index',['barang'=>$barang]);
    }


    public function read()
    {
        return view('inventory.read', [
            'inventories' => Inventories::latest()->get()
        ]);
    }

    public function getInventory()
    {
        $getData = Inventories::all();
        return response()->json($getData);
    }


    public function getName($id){

        
        $inventory = Inventories::find($id);
         return response()->json([
            'name' => $inventory->name,
            'stock'=>$inventory->stock
         ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function select(Request $request){
        $term=$request->input('q');
        $items=Inventories::where('name','like','%'.$term.'%')->get();
        return response()->json($items);
    }


    public function store(Request $request)
    {
       $request->validate([
        'name'=>'required',
        'price'=>'required',
        'stock'=>'required',
       ]);

         $new=new Inventories;
         $new->code = Helper::IDGenerator(new Inventories, 'code', 3, 'KB');
         $new->name = $request->input('name');
         $new->price = $request->input('price');
         $new->stock =$request->input('stock');
         $save=$new->save();
         
         if($save){
            return redirect('/inventory')->with('toast_success', 'Data Inventori berhasil ditambahkan!');
         }
         else{
            return back()->with('toast_error', 'Gagal menambahkan Data Inventori!');
         }
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
        $inventori=Inventories::findOrFail($id);
        return view ('inventory.edit',['inventori'=>$inventori]);
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
        Validator::make($request->all(),[
            'name'=>'required',
            'price'=>'required',
            'stock'=>'required',
        ])->validate();

        $inventori=Inventories::findOrFail($id);
        $inventori->name=$request->get('name');
        $inventori->price=$request->get('price');
        $inventori->stock=$request->get('stock');
        if ($inventori->update()) {
            return redirect('/inventory')->with('toast_success', 'Data Inventori berhasil diubah!');
    }
        return back()->with('toast_error', 'Gagal menambahkan Data Inventori!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventori=Inventories::findOrFail($id);
        $inventori->delete();
        return redirect('/inventory')->with('success','Data Inventori berhasil dihapus!');
    }
}
