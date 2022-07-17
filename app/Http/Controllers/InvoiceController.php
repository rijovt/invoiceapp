<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\InvoiceItem;
use App\Invoice;

class InvoiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $invoices = Invoice::latest()->paginate(25);

        return view('home', compact('invoices'));
    }

    public function create()
    {
        InvoiceItem::where(['user_id' => Auth::user()->id,'add_id' => 0])->delete();
        return view('createInvoice');
    }

    public function additem(Request $request)
    {   
        $request['user_id'] = Auth::user()->id;
        $request['name'] = ucfirst($request['name']); 
        $invoiceItem = InvoiceItem::create($request->all());

        $items = InvoiceItem::where(['user_id' => Auth::user()->id,'add_id' => 0]);      
        $invoiceItem['grand'] = $items->sum('total');

        return response()->json($invoiceItem, 200);
    }

    public function destroyitem(InvoiceItem $item)
    {
        $item->delete();

        $items = InvoiceItem::where(['user_id' => Auth::user()->id,'add_id' => 0]);      
        $invoiceItem['grand'] = $items->sum('total');
        return response()->json($invoiceItem, 200);
    }

    public function finalize(Request $request)
    {  
        $last = Invoice::where('invoice_no', '!=', null)->where('active', 1)->orderBy('id', 'DESC')->first();
        $request['invoice_no'] = empty($last->invoice_no) ? 1 : $last->invoice_no+1;        
        $request['user_id'] = Auth::user()->id;         
        $invoice = Invoice::create($request->all());

        InvoiceItem::where(['user_id' => Auth::user()->id,'add_id' => 0])->update(['add_id' => $invoice->id]);

        return redirect()
            ->route('home')
            ->withStatus('Success');
    }

    public function print(Invoice $id)
    {
        $items = InvoiceItem::where(['add_id' => $id->id])->get();

        return view('print', ['invoice' => $id,'items' => $items]);
    }
}
