@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h5 class="card-title">{{ $title ?? 'Data Transaksi' }}</h5>

                    <div class="mb-3 text-end">
                        <a href="{{ route('transaction.create') }}" class="btn btn-primary btn-sm">
                            Create New Transaction
                        </a>
                    </div>

                    <div class="mb-3">
                        <form method="GET" action="{{ route('transaction.index') }}">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search customer / order code..." value="{{ request('search') }}">

                                <button type="submit" class="">Search</button>

                                <a href="{{ route('transaction.index') }}" class="btn btn-secondary">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Customer</th>
                                <th>Order Code</th>
                                <th>Order Date</th>
                                <th>Order End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->customer->customer_name }}</td>
                                    <td>{{ $order->order_code }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>{{ $order->order_end_date }}</td>

                                    <td>
                                        @if ($order->order_status == 0)
                                            <span class="badge bg-warning">Belum Diambil</span>
                                        @else
                                            <span class="badge bg-success">Sudah Diambil</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('transaction.show', $order->id) }}"
                                            class="btn btn-primary btn-sm">
                                            Detail
                                        </a>

                                        <form action="{{ route('transaction.destroy', $order->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" onclick="return confirm('Yakin hapus data?')"
                                                class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Data Kosong
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
