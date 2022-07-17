@extends('layouts.app', ['page' => 'Add Invoce'])

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">New Invoice</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('home') }}" class="btn btn-sm btn-primary">Back</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form class="border" method="post" id="formData" autocomplete="off">
                            @csrf

                            <div class="p-lg-3">
                                <div class="row">
                                    <div class="col-2">
                                        <label class="form-control-label" for="input-item">Name</label>
                                        <input type="text" name="name" id="input-item" class="form-control">
                                    </div>
                                    <div class="col-2">
                                        <label class="form-control-label" for="input-price">Unit Price</label>
                                        <input type="text" name="price" id="input-price" class="form-control">
                                    </div>
                                    <div class="col-2">
                                        <label class="form-control-label" for="input-qty">Quantity</label>
                                        <input type="text" name="qty" id="input-qty" class="form-control" value="0" >
                                    </div>
                                    <div class="col-2">
                                        <label class="form-control-label" for="input-tax">Tax</label>
                                        <select name="tax_percent" id="input-tax" class="form-control">
                                            <option value="0">0%</option>
                                            <option value="1">1%</option>
                                            <option value="5">5%</option>
                                            <option value="10">10%</option>
                                        </select>
                                        <input type="hidden" id="value" name="value">
                                        <input type="hidden" id="tax" name="tax">
                                    </div>
                                    <div class="col-2">
                                        <label class="form-control-label" for="input-total">Total</label>
                                        <input type="text" name="total" id="input-total" class="form-control" readonly>
                                    </div>
                                    <div class="col-2">
                                        <input type="button" id="btn-add" value="Add" class="form-control btn btn-sm btn-success mt-4" >
                                    </div>
                                </div>
                            </div>
                        </form>

                        <table class="table table-bordered table-responsive">
                            <thead class="thead-light text-center">
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Value</th>
                                <th scope="col">Tax</th>
                                <th scope="col">Total</th>
                                <th ></th>
                            </thead>                        
                            <tbody id="links-list">
                                <tr class="text-center">
                                   
                                </tr>
                            </tbody>                        
                        </table>

                        <div class="pl-lg-4">
                            <form method="POST" action="{{ route('finalize') }}" onsubmit="return valid();">
                                @csrf
                                <div class="row">
                                    <div class="col-9 text-right">Grand Total</div>
                                    <div class="col-1 p-0 text-right">
                                        <div id="grand">$0.00</div>    
                                        <input type="hidden" id="total_amount" name="total_amount">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-9 text-right mt-auto" >Discount</div>
                                    <div class="col-1 p-0">
                                        <input type="text" id="discount" name="discount" class="form-control form-control-sm text-right">
                                    </div>
                                    <div class="col-1 mt-auto">
                                        <select name="discount_type" id="discount_type">
                                            <option value="0">$</option>
                                            <option value="1">%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-9 text-right">Final Amount</div>
                                    <div class="col-1 p-0 text-right">
                                        <div id="final">$0.00</div>    
                                        <input type="hidden" id="final_amt" name="final_amount">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-9"></div>
                                    <div class="col-2">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            {{ __('Finalize Invoice') }}
                                        </button>                                  
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
$(document).ready(function() {    
    $('#input-qty,#input-price').blur(function(){
        blurFn()    
    });
    $('#input-tax').change(function(){
        blurFn()    
    });  

    $('#btn-add').click(function(e){
        e.preventDefault(); 
        var a = $("#input-item").val()
        var b = $("#input-price").val()
        var c = $("#input-qty").val()
        if (a=="" || b==0 || b=="" || c==0 || c=="")
        {
            alert("Please fill all fields");
            return false;
        }
        else{
            $.ajax({
                type: "POST",
                url: `/additem`,
                data: $("#formData").serialize(),
                dataType: 'json',
                success: function (response) {
                    var link = '<tr class="text-center" id="row_' + response.id + '"><td class="nos"></td><td>' + response.name + '</td><td>' + response.price + '</td><td>' + response.qty + '</td><td>' + response.value + '</td><td>' + response.tax + '</td><td class="text-right">$ ' + response.total  + '</td>';
                    link += '<td class="text-center"><a href="javascript:void(0)" onclick="deleteProd(' + response.id + ')" ><span aria-hidden="true">&times;</span></a></td></tr>';
                    
                    $('#links-list').prepend(link);
                    $('#total_amount').val(response.grand);
                    discount();                                 
                    $('#formData').trigger("reset");                    
                    
                    var nos = parseInt($('.nos').length);
                    $('.nos').each(function(i, obj) {
                        $(this).text( nos-- );
                    });
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });

    $('#discount').keyup(function(){
        discount()    
    });
    $('#discount_type').change(function(){
        discount()    
    });
});

function blurFn() {        
    $('#btn-add').focus();
    var qty = parseFloat($('#input-qty').val() || 0)
    var price = parseFloat($('#input-price').val() || 0)
    var tax = parseFloat($('#input-tax').val())
    if(isNaN(qty) || qty<0){
        alert("Quantity must be a positive number greater than zero !!");
        $('#input-qty').val('')
        this.focus()
        return false;
    }
    if(isNaN(price) || price<0){
        alert("Price must be a positive number greater than zero !!");
        $('#input-price').val('')
        this.focus()
        return false;
    }
    var value = qty*price;
    var tax_amt = (value*(tax/100));
    $('#value').val(value.toFixed(2));
    $('#tax').val(tax_amt.toFixed(2));
    $('#input-total').val(((qty*price)+tax_amt).toFixed(2));
}

// Clicking delete
function deleteProd(id){
    if(confirm('Are you sure to delete ?')){
        let _sid = $('#sale_id').val();
        let _url = `/destroyitem/${id}` 
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: _url,
            type: 'DELETE',
            data: {
              _token: _token
            },
            success: function(response) {
                $("#row_"+id).remove();
                $('#total_amount').val(response.grand);
                discount();

                var nos = parseInt($('.nos').length);
                $('.nos').each(function(i, obj) {
                    $(this).text( nos-- );
                });
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
}

function discount(){
    var grand = parseFloat($('#total_amount').val() || 0);
    $('#grand').html(grand>0 ? '$'+grand.toFixed(2): '$0.00');
    var discount = 0
    if(grand>0){
        var discount = parseFloat($('#discount').val() || 0);

        if(parseInt($('#discount_type').val())!=0)
            discount = (grand*(discount/100))

        if(discount>grand){
            discount = 0
            $('#discount').val('')
        }
    }
    else
        $('#discount').val('')

    var final = (grand - discount).toFixed(2);
    $('#final_amt').val(final);
    $('#final').html('$'+final);
}

function valid() {
    if(!$('#links-list .nos').length) {
        alert('Please add atleast one item!');
        return false;
    }
    else {
        return confirm('Do you want to finalize it?');
    }
}
</script>
<style type="text/css">
    tbody {
        display:block;
        height:300px;
        overflow:auto;
    }
    thead, tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }
</style>
@endpush