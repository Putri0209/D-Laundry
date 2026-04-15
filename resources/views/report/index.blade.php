@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Laporan Transaksi Laundry</h5>

            {{-- ================= FILTER ================= --}}
            <form method="GET" action="">
                <div class="row mb-3">

                    <div class="col-md-4">
                        <label>Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>

                    <div class="col-md-4">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>

                    <div class="col-md-4 d-flex align-items-end justify-content-between">

                        <div>
                            <button type="submit" class="btn btn-primary me-2">
                                Filter
                            </button>

                            <a href="{{ route('report.index') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>

                        {{-- 🔥 BUTTON PDF --}}
                        <a href="{{ route('report.pdf', request()->query()) }}"
                           class="btn btn-danger"
                           target="_blank"
                           title="Print PDF">
                            <i class="bi bi-file-earmark-pdf"></i>
                        </a>

                    </div>
                </div>
            </form>

            {{-- ================= PERIODE ================= --}}
            <div class="mb-3">
                <strong>Periode: </strong>
                @if(request('start_date') && request('end_date'))
                    {{ request('start_date') }} s/d {{ request('end_date') }}
                @else
                    Semua Data
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Tanggal</th>
                            <th>Selesai</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->customer->customer_name }}</td>
                            <td>{{ $order->order_date }}</td>
                            <td>{{ $order->order_end_date }}</td>
                            <td>Rp {{ number_format($order->total) }}</td>
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
                            <td colspan="7" class="text-center text-muted">
                                Tidak ada data
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
