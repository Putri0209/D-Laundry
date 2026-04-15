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
                    <form action="{{ route('level.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Level Name</label>
                            <input type="text" class="form-control" id="level_name" name="level_name"
                                placeholder="Enter Level Name" required value="{{ old('level_name')}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
