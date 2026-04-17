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
                            <label for="name" class="form-label">Layanan</label>
                            <input type="text" class="form-control" id="service_name" name="service_name"
                                placeholder="Masukkan Layanan" required value="{{ old('service_name')}}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="price" name="price"
                                placeholder="Masukkan harga layanan" required value="{{ old('price')}}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Masukkan deskripsi" value="{{ old('description')}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
