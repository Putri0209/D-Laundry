@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif
                    <h5 class="card-title">{{ $title ?? '' }}</h5>
                    <form action="{{ route('customer.update', $customer->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                value="{{ $customer->customer_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="phone" name="phone"
                                value="{{ $customer->phone }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ $customer->address }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
