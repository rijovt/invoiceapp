@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    {{ __('Dashboard') }}
                    <a href="{{ route('create') }}" class="btn btn-sm btn-primary float-right">New Invoice</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <table class="table">
                            <thead class="thead-light">
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Total Amount</th>
                                <th>User</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ date('d-m-y', strtotime($invoice->created_at ?? $invoice->created_at)) }}</td>
                                        <td>{{ $invoice->invoice_no }}</td>
                                        <td>{{ $invoice->final_amount }}</td>
                                        <td>{{ $invoice->user->name }}</td>
                                        <td><a href="{{ route('print', ['id' => $invoice]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Print Bill">
                                           print
                                        </a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
