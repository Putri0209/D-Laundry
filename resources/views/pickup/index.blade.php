@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h5 class="card-title">{{ $title ?? 'Pickup Laundry' }}</h5>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Summary Badge --}}
                    <div class="mb-3">
                        <span class="badge bg-warning text-dark fs-6">
                            <i class="bi bi-hourglass-split"></i>
                            {{ $orders->count() }} laundry belum diambil
                        </span>
                    </div>

                    {{-- Search --}}
                    <div class="mb-3">
                        <form method="GET" action="{{ route('pickup.index') }}">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari nama customer / kode order..."
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                                <a href="{{ route('pickup.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </form>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead class="table-warning">
                            <tr>
                                <th>No</th>
                                <th>Customer</th>
                                <th>Kode Order</th>
                                <th>Tanggal Order</th>
                                <th>Estimasi Selesai</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->customer->customer_name }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $order->order_code }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}</td>
                                    <td>
                                        @php
                                            $endDate = \Carbon\Carbon::parse($order->order_end_date);
                                            $isOverdue = $endDate->isPast();
                                        @endphp
                                        <span class="{{ $isOverdue ? 'text-danger fw-bold' : '' }}">
                                            {{ $endDate->format('d-m-Y') }}
                                            @if ($isOverdue)
                                                <span class="badge bg-danger ms-1">Terlambat</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">Belum Diambil</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pickup.show', $order->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye"></i> Detail & Proses
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-check-circle-fill text-success fs-4 d-block mb-2"></i>
                                        Semua laundry sudah diambil!
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
