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
                    <form action="{{ route('service.update', $service->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="" class="form-label">Service Name</label>
                            <input type="text" class="form-control" id="service_name" name="service_name"
                                value="{{ $service->service_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price"
                                value="{{ $service->price }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                value="{{ $service->description }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
