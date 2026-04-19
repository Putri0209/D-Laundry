@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $title ?? '' }}</h5>
                <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
                    <form method="GET" action="{{ route('service.index') }}" class="d-flex gap-2 flex-grow-1" style="max-width:400px">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Cari nama layanan..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary btn-sm px-3">
                            <i class="bi bi-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('service.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </form>
                    <a href="{{ route('service.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i>Tambah Layanan
                    </a>
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
