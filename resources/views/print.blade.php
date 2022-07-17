@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-header">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title">Sale Summary</h4>
            </div>
            <div class="col-4 text-right">
                <button class="btn btn-sm btn-success" onclick="prit()">Print</button>
                <button class="btn btn-sm"><a href="{{ route('home') }}">Back to Invoices</a></button>
                
            </div>
        </div>
    </div>
    <div id="pdiv" class="card-body">
        <table class="main" width="100%" cellpadding="0" cellspacing="0">
            <tbody>
                        <tr>
                        <td class="content-wrap aligncenter">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td class="content-block">
                                        <h2>Invoice</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <table class="invoice">
                                            <tbody><tr>
                                                <td>Invoice #{{ $invoice->invoice_no }}
                                                <br>{{ date('Y-m-d h:i:sa', strtotime($invoice->created_at ?? $invoice->created_at)) }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table class="invoice-items" cellpadding="0" cellspacing="0">
                                                        <tbody>
                                                            <thead class="thead-light text-center"> 
                                                                <th>Name</th>
                                                                <th>Qty</th>
                                                                <th>Unit Price</th>
                                                                <th>Value</th>
                                                                <th>Tax</th>
                                                                <th>Total</th>
                                                            </thead> 
                                                            @foreach ($items as $item)
                                    
                                                            <tr>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ $item->qty }}</td>
                                                                <td class="alignright">$ {{ $item->price }}</td>
                                                                <td class="alignright">$ {{ $item->value }}</td>
                                                                <td class="alignright">$ {{ $item->tax }}</td>
                                                                <td class="alignright">$ {{ $item->total }}</td>
                                                            </tr>
                                                            @endforeach

                                                            <tr class="total">
                                                            @if($invoice->discount)
                                                                <td colspan="5" class="alignright" width="80%"></td>
                                                                
                                                                <td class="alignright">$ {{ $invoice->total_amount }}</td>
                                                            </tr>
                                                            <tr>    
                                                                <td colspan="5" class="alignright" width="80%">Discount</td>
                                                                <td class="alignright">$ {{ $invoice->discount }}</td>
                                                            </tr>
                                                            @endif

                                                        <tr class="total">
                                                            <td colspan="5" class="alignright" width="80%">Grand Total</td>
                                                            <td class="alignright">$ {{ $invoice->final_amount }}</td>
                                                        </tr>
                                                    </tbody></table>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>                                
                            </tbody></table>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>

<style type="text/css">


/* -------------------------------------
    HEADER, FOOTER, MAIN
------------------------------------- */
.main {
    background: #fff;
    border: 1px solid #e9e9e9;
    border-radius: 3px;
}

.content-wrap {
    padding: 20px;
}

.content-block {
    padding: 0 0 20px;
}

.header {
    width: 100%;
    margin-bottom: 20px;
}

.footer {
    width: 100%;
    clear: both;
    color: #999;
    padding: 20px;
}
.footer a {
    color: #999;
}
.footer p, .footer a, .footer unsubscribe, .footer td {
    font-size: 12px;
}

/* -------------------------------------
    TYPOGRAPHY
------------------------------------- */
h1, h2, h3 {
    font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
    color: #000;
    margin: 40px 0 0;
    line-height: 1.2;
    font-weight: 400;
}

h1 {
    font-size: 32px;
    font-weight: 500;
}

h2 {
    font-size: 24px;
}

h3 {
    font-size: 18px;
}

h4 {
    font-size: 14px;
    font-weight: 600;
}

p, ul, ol {
    margin-bottom: 10px;
    font-weight: normal;
}
p li, ul li, ol li {
    margin-left: 5px;
    list-style-position: inside;
}


/* -------------------------------------
    OTHER STYLES THAT MIGHT BE USEFUL
------------------------------------- */
.last {
    margin-bottom: 0;
}

.first {
    margin-top: 0;
}

.aligncenter {
    text-align: center;
}

.alignright {
    text-align: right;
}

.alignleft {
    text-align: left;
}

.clear {
    clear: both;
}

/* -------------------------------------
    ALERTS
    Change the class depending on warning email, good email or bad email
------------------------------------- */
.alert {
    font-size: 16px;
    color: #fff;
    font-weight: 500;
    padding: 20px;
    text-align: center;
    border-radius: 3px 3px 0 0;
}
.alert a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
}
.alert.alert-warning {
    background: #f8ac59;
}
.alert.alert-bad {
    background: #ed5565;
}
.alert.alert-good {
    background: #1ab394;
}

/* -------------------------------------
    INVOICE
    Styles for the billing table
------------------------------------- */
.invoice {
    margin: 40px auto;
    text-align: left;
    width: 50%;
}
.invoice td {
    padding: 5px 0;
}
.invoice .invoice-items {
    width: 100%;
}
.invoice .invoice-items td {
    border-top: #eee 1px solid;
}
.invoice .invoice-items .total td {
    border-top: 2px solid #333;
    border-bottom: 2px solid #333;
    font-weight: 700;
}
</style>
@endsection

@push('js')
<script>
function prit()
{
    var newstr=document.getElementById("pdiv").innerHTML;
    
    w=window.open('', '_blank', 'width=1100,height=600');
        w.document.write(newstr);
        w.print();
        w.close();
}
</script>
@endpush
