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
                    <form action="{{ route('service.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Service Name</label>
                            <input type="text" class="form-control" id="service_name" name="service_name"
                                placeholder="Enter Service Name" required value="{{ old('service_name')}}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price"
                                placeholder="Enter Service Price" required value="{{ old('price')}}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Enter Description Service" value="{{ old('description')}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
