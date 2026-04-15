@extends('layouts.app')

@section('content')

<div class="container">

    <h5 class="mb-4">Dashboard Laundry</h5>

    {{-- ================= SUMMARY CARDS ================= --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total Transaksi</small>
                        <h4 class="fw-bold mt-2">{{ $totalTransaksi }}</h4>
                    </div>
                    <i class="bi bi-receipt fs-2 text-primary"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total Pendapatan</small>
                        <h4 class="fw-bold mt-2 text-success">
                            Rp {{ number_format($totalPendapatan) }}
                        </h4>
                    </div>
                    <i class="bi bi-cash-stack fs-2 text-success"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Belum Diambil</small>
                        <h4 class="fw-bold mt-2 text-warning">
                            {{ $belumDiambil }}
                        </h4>
                    </div>
                    <i class="bi bi-clock-history fs-2 text-warning"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Sudah Diambil</small>
                        <h4 class="fw-bold mt-2 text-primary">
                            {{ $sudahDiambil }}
                        </h4>
                    </div>
                    <i class="bi bi-check-circle fs-2 text-primary"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= TABLE TRANSAKSI TERBARU ================= --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h6 class="card-title mb-3">Transaksi Terbaru</h6>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Customer</th>
                            <th>Order Code</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($latestOrders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->customer->customer_name }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->order_date }}</td>
                            <td>
                                @if($order->order_status == 0)
                                    <span class="badge bg-warning">Belum Diambil</span>
                                @else
                                    <span class="badge bg-success">Sudah Diambil</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada transaksi
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
