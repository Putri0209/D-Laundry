@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <h5 class="card-title mb-4">Detail Pickup</h5>

            {{-- ALERT --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- HEADER INFO --}}
            <div class="row g-2 mb-4">
                <div class="col-md-3">
                    <div class="bg-light rounded-3 p-3">
                        <div class="text-muted small mb-1">Customer</div>
                        <div class="fw-bold">
                            {{ $order->customer_id ? $order->customer->customer_name : $order->customer_name }}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-light rounded-3 p-3">
                        <div class="text-muted small mb-1">Kode Order</div>
                        <div class="fw-bold">{{ $order->order_code }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-light rounded-3 p-3">
                        <div class="text-muted small mb-2">Status Pembayaran</div>
                        @if($order->payment_status == 0)
                            <span class="badge bg-danger px-2 py-1">
                                <i class="bi bi-x-circle me-1"></i>Belum Bayar
                            </span>
                        @else
                            <span class="badge bg-success px-2 py-1">
                                <i class="bi bi-check-circle me-1"></i>Lunas
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-light rounded-3 p-3">
                        <div class="text-muted small mb-2">Status Laundry</div>
                        @if($order->order_status == 0)
                            <span class="badge bg-warning text-dark px-2 py-1">
                                <i class="bi bi-hourglass-split me-1"></i>Belum Diambil
                            </span>
                        @else
                            <span class="badge bg-success px-2 py-1">
                                <i class="bi bi-bag-check me-1"></i>Sudah Diambil
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <hr>

            {{-- DETAIL LAYANAN --}}
            <h6 class="fw-bold mb-3">Detail Layanan</h6>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Layanan</th>
                        <th style="width:150px">Qty (Kg)</th>
                        <th style="width:140px" class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $d)
                    <tr>
                        <td>{{ $d->service->service_name }}</td>
                        <td>{{ $d->qty }}</td>
                        <td class="text-end fw-semibold">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-active">
                        <td colspan="2" class="text-end fw-bold">Total</td>
                        <td class="text-end fw-bold fs-6 text-success">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <hr>

            {{-- ================= LOGIC PICKUP ================= --}}

            {{-- ❌ BELUM BAYAR --}}
            @if($order->payment_status == 0)

                <div class="alert alert-danger d-flex align-items-start gap-3">
                    <i class="bi bi-exclamation-triangle-fill fs-4 mt-1 flex-shrink-0"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Pembayaran Belum Diselesaikan</h6>
                        <p class="mb-2">Laundry ini belum dibayar. Selesaikan pembayaran sebelum proses pickup dapat dilakukan.</p>
                        <a href="{{ route('transaction.show', $order->id) }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-cash-coin me-1"></i>Bayar Sekarang
                        </a>
                    </div>
                </div>

            {{-- ✔ SUDAH BAYAR, BELUM DIAMBIL --}}
            @elseif($order->order_status == 0)

                <h6 class="fw-bold mb-3">Proses Pickup</h6>
                <form action="{{ route('pickup.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Pickup</label>
                            <input type="datetime-local" name="pickup_date" class="form-control"
                                value="{{ now()->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Catatan Pickup</label>
                            <input type="text" name="notes" class="form-control"
                                placeholder="Contoh: Diambil oleh kakaknya">
                        </div>
                    </div>
                    <button type="submit"
                        onclick="return confirm('Yakin laundry sudah diambil?')"
                        class="btn btn-primary">
                        <i class="bi bi-bag-check me-1"></i>Konfirmasi Pickup
                    </button>
                </form>

            {{-- ✔ SUDAH DIAMBIL --}}
            @else
                <div class="alert alert-success d-flex align-items-start gap-3">
                    <i class="bi bi-bag-check-fill fs-4 mt-1 flex-shrink-0"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Laundry Sudah Diambil</h6>
                        <p class="mb-1">
                            <span class="text-muted small">Tanggal & Waktu Ambil</span><br>
                            {{ \Carbon\Carbon::parse($pickup->pickup_date)->format('d-m-Y H:i') }}
                        </p>
                        <p class="mb-0">
                            <span class="text-muted small">Catatan</span><br>
                            {{ $pickup->notes ?? '-' }}
                        </p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
