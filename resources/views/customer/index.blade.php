@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $title ?? '' }}</h5>
                <div class="mb-3" align="right">
                    <a href="{{route('customer.create')}}" class="btn btn-primary btn-sm">Create New Customer</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                <tbody>
                    @foreach ($customers as $customer )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $customer->customer_name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>
                            <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form id="delete-form-{{ $customer->id }}" action="{{ route('customer.destroy', $customer->id) }}" method="post" class="d-inline">
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
