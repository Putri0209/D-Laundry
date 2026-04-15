@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <h5 class="card-title">{{ $title ?? '' }}</h5>
            </div>
        </div>
    </div>
@endsection
