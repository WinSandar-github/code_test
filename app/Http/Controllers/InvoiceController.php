<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\tbl_invoice;
use App\Models\tbl_item;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('tbl_invoices')->orderBy('id','desc')->paginate(5);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $invoice=new tbl_invoice();
        $invoice->table_no=$request->table_no;
        $invoice->sub_total=$request->sub_total;
        $invoice->tax=$request->tax;
        $invoice->total=$request->total;
        $invoice->save();
        $invoice->receipt_no='00071004#'.$invoice->id;
        $invoice->save();
       
        for ($i = 0; $i < count($request->tableRows); $i++) {
            $item=new tbl_item();
            $item->qty=$request->tableRows[$i]['qty'];
            $item->description=$request->tableRows[$i]['description'];
            $item->price=$request->tableRows[$i]['price'];
            $item->amount=$request->tableRows[$i]['amount'];
            $item->invoice_id=$invoice->id;
            $item->save();
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function getInvoice($id)
    {
        $invoice=tbl_invoice::with('item')
                            ->where('tbl_invoices.id',$id)
                            ->get();
        return $invoice;
    }
}
