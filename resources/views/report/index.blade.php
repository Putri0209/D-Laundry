@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <h5 class="card-title">Laporan Transaksi Laundry</h5>

            {{-- Filter --}}
            <form method="GET" action="">
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end justify-content-between">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-funnel me-1"></i>Filter
                            </button>
                            <a href="{{ route('report.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                            </a>
                        </div>
                        <a href="{{ route('report.pdf', request()->query()) }}"
                            class="btn btn-danger" target="_blank" title="Export PDF">
                            <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                        </a>
                    </div>
                </div>
            </form>

            {{-- Periode --}}
            <div class="mb-3 text-muted small">
                <i class="bi bi-calendar-range me-1"></i>
                <strong>Periode:</strong>
                @if(request('start_date') && request('end_date'))
                    {{ \Carbon\Carbon::parse(request('start_date'))->format('d-m-Y') }}
                    s/d
                    {{ \Carbon\Carbon::parse(request('end_date'))->format('d-m-Y') }}
                @else
                    Semua Data
                @endif
            </div>

            {{-- Summary Cards --}}
            @php
                $totalPendapatan  = $orders->where('payment_status', 1)->sum('total');
                // $totalBelumBayar  = $orders->where('payment_status', 0)->sum('total');
                // $totalTransaksi   = $orders->count();
                // $sudahDiambil     = $orders->where('order_status', 1)->count();
                // $belumDiambil     = $orders->where('order_status', 0)->count();
            @endphp

            {{-- <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 rounded-3 h-100" style="background:#e8f5e9">
                        <div class="card-body p-3">
                            <div class="text-muted small mb-1">Total Pendapatan (Lunas)</div>
                            <div class="fw-bold fs-5 text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 rounded-3 h-100" style="background:#fdecea">
                        <div class="card-body p-3">
                            <div class="text-muted small mb-1">Piutang (Belum Bayar)</div>
                            <div class="fw-bold fs-5 text-danger">Rp {{ number_format($totalBelumBayar, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 rounded-3 h-100" style="background:#e3f2fd">
                        <div class="card-body p-3">
                            <div class="text-muted small mb-1">Total Transaksi</div>
                            <div class="fw-bold fs-5 text-primary">{{ $totalTransaksi }} order</div>
                            <div class="small text-muted mt-1">
                                <span class="text-success">{{ $sudahDiambil }} selesai</span>
                                &nbsp;·&nbsp;
                                <span class="text-warning">{{ $belumDiambil }} pending</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- Tabel --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Order</th>
                            <th>Pelanggan</th>
                            <th>Tanggal Order</th>
                            {{-- <th>Est. Selesai</th> --}}
                            <th class="text-center">Pengambilan</th>
                            <th class="text-center">Pembayaran</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>
                                {{ $order->customer_id ? $order->customer->customer_name : $order->customer_name }}
                                @if(!$order->customer_id)
                                    <span class="badge bg-secondary ms-1" style="font-size:.7rem">Non-Member</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}</td>
                            {{-- <td>{{ \Carbon\Carbon::parse($order->order_end_date)->format('d-m-Y') }}</td> --}}

                            <td class="text-center">
                                @if($order->order_status == 0)
                                    <span class="badge bg-warning text-dark">Belum Diambil</span>
                                @else
                                    <span class="badge bg-success">Sudah Diambil</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($order->payment_status == 0)
                                    <span class="badge bg-danger">Belum Bayar</span>
                                @else
                                    <span class="badge bg-success">Lunas</span>
                                @endif
                            </td>
                             <td class="">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                Tidak ada data transaksi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($orders->count() > 0)
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="6" class="text-end">Total Pendapatan (Lunas)</td>
                            <td class="fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
