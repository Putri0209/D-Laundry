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
                    <form action="{{ route('customer.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name"
                                placeholder="Masukkan nama pelanggan" required value="{{ old('customer_name')}}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">No Hp</label>
                            <input type="number" class="form-control" id="phone" name="phone"
                                placeholder="Masukkan nomor handphone" required value="{{ old('phone')}}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Masukkan alamat" value="{{ old('address')}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
