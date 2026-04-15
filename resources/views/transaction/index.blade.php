@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $title ?? '' }}</h5>
                <div class="mb-3" align="right">
                    <a href="{{route('transaction.create')}}" class="btn btn-primary btn-sm">Create New Transaction</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer</th>
                            <th>Order Code</th>
                            <th>Order Date</th>
                            <th>Order End Date</th>
                            <th>Order Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                <tbody>
                    @foreach ($orders as $order )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->customer->customer_name}}</td>
                        <td>{{ $order->order_code }}</td>
                        <td>{{ $order->order_date}}</td>
                        <td>{{ $order->order_end_date}}</td>
                        <td>{{ $order->order_status}}</td>
                        <td>
                            <a href="{{ route('transaction.edit', $transaction->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form id="delete-form-{{ $transaction->id }}" action="{{ route('transaction.destroy', $transaction->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
@endsection
