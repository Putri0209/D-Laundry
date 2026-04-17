@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $title ?? '' }}</h5>
                <div class="mb-3" align="right">
                    <a href="{{route('service.create')}}" class="btn btn-primary btn-sm">Create New Service</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Service Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                <tbody>
                    @foreach ($services as $service )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $service->service_name }}</td>
                        <td>Rp {{ number_format($service->price,2, ',', '.')}}</td>
                        <td>{{ $service->description }}</td>
                        <td>
                            <a href="{{ route('service.edit', $service->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
                            <form id="delete-form-{{ $service->id }}" action="{{ route('service.destroy', $service->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm delete-btn"><i class="bi bi-trash3"></i></button>
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
