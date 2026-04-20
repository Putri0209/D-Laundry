@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <h5 class="card-title mb-4">Detail Transaksi</h5>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">

                {{-- ===== KOLOM KIRI ===== --}}
                <div class="col-lg-8">

                    {{-- Header Info --}}
                    <div class="row g-2 mb-4">
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3">
                                <div class="text-muted small mb-1">Pelanggan</div>
                                <div class="fw-bold">
                                    {{ $order->customer_id ? $order->customer->customer_name : $order->customer_name }}
                                    {{-- @if(!$order->customer_id)
                                        <span class="badge bg-secondary ms-1" style="font-size:.7rem">Non-Member</span>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3">
                                <div class="text-muted small mb-1">Kode Order</div>
                                <div class="fw-bold">{{ $order->order_code }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3">
                                <div class="text-muted small mb-1">Tanggal Laundry</div>
                                <div class="fw-bold">{{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
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
                    </div>

                    <hr>

                    {{-- Detail Layanan --}}
                    <h6 class="fw-bold mb-3">Detail Layanan</h6>
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Layanan</th>
                                <th style="width:90px">Qty (Kg)</th>
                                <th style="width:130px">Harga</th>
                                <th style="width:130px" class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->details as $d)
                            <tr>
                                <td>{{ $d->service->service_name }}</td>
                                <td>{{ $d->qty }}</td>
                                <td>Rp {{ number_format($d->service->price, 0, ',', '.') }}</td>
                                <td class="text-end fw-semibold">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

                {{-- ===== KOLOM KANAN: Ringkasan & Pembayaran ===== --}}
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 80px;">
                        <div class="card border-0 rounded-3 overflow-hidden shadow-sm">

                            <div class="card-header border-0 bg-primary text-white py-3 px-4">
                                <h6 class="mb-0 fw-bold">
                                    <i class="bi bi-receipt me-2"></i>Ringkasan Pembayaran
                                </h6>
                            </div>

                            <div class="card-body p-4">

                                {{-- @php
                                    $subtotalVal = $order->subtotal > 0 ? $order->subtotal : $order->details->sum('subtotal');
                                @endphp

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Subtotal</span>
                                    <span class="fw-semibold small">Rp {{ number_format($subtotalVal, 0, ',', '.') }}</span>
                                </div> --}}
                                {{-- <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Pajak (10%)</span>
                                    <span class="fw-semibold small">Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                                </div>
                                @if($order->discount_nominal > 0)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Diskon ({{ $order->discount_percent }}%)</span>
                                    <span class="fw-semibold small text-danger">- Rp {{ number_format($order->discount_nominal, 0, ',', '.') }}</span>
                                </div>
                                @endif --}}

                                {{-- <div class="border-top pt-3 mb-4"> --}}
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Total</span>
                                        <span class="fw-bold fs-5 text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <input type="hidden" id="input-total" value="{{ $order->total }}">

                                {{-- BELUM BAYAR --}}
                                @if($order->payment_status == 0)

                                    <form action="{{ route('transaction.pay', $order->id) }}" method="POST" id="pay-form">
                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold small text-muted text-uppercase">Jumlah Bayar</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-white text-muted fw-bold">Rp</span>
                                                <input type="number" name="order_pay" id="input-pay"
                                                    class="form-control form-control-lg fw-semibold"
                                                    min="{{ $order->total }}" placeholder="0"
                                                    style="font-size:1.1rem" required>
                                            </div>
                                        </div>

                                        <div class="rounded-3 p-3 mb-3" id="kembalian-box"
                                            style="background:#f8f9fa; border:1.5px solid #dee2e6; transition:all .2s ease">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-semibold small" id="kembalian-label" style="color:#6c757d">
                                                    <i class="bi bi-arrow-return-left me-1"></i>Kembalian
                                                </span>
                                                <span id="display-change" class="fw-bold fs-5" style="color:#6c757d">—</span>
                                            </div>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" id="submit-btn" class="btn btn-secondary btn-lg fw-semibold" disabled>
                                                <i class="bi bi-check-circle me-2"></i>Konfirmasi Pembayaran
                                            </button>
                                        </div>

                                    </form>

                                {{-- SUDAH BAYAR --}}
                                @else
                                    <div class="rounded-3 p-3 mb-3" style="background:#e8f5e9; border:1.5px solid #a5d6a7">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted small">Jumlah Dibayar</span>
                                            <span class="fw-bold small text-success">Rp {{ number_format($order->order_pay, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted small">Kembalian</span>
                                            <span class="fw-bold small text-success">Rp {{ number_format($order->order_change, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <div class="alert alert-success py-2 mb-0 text-center">
                                        <i class="bi bi-check-circle-fill me-2"></i><strong>Pembayaran Lunas</strong>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- end row --}}

        </div>
    </div>
</div>

<script>
function formatRupiah(angka) {
    return 'Rp ' + Number(angka).toLocaleString('id-ID');
}

const inputPay  = document.getElementById('input-pay');
const submitBtn = document.getElementById('submit-btn');

if (inputPay) {
    inputPay.addEventListener('input', function () {
        const total   = parseInt(document.getElementById('input-total').value) || 0;
        const pay     = parseInt(this.value) || 0;
        const change  = pay - total;
        const box     = document.getElementById('kembalian-box');
        const display = document.getElementById('display-change');
        const label   = document.getElementById('kembalian-label');

        if (!this.value) {
            box.style.background  = '#f8f9fa';
            box.style.borderColor = '#dee2e6';
            display.style.color   = '#6c757d';
            label.style.color     = '#6c757d';
            label.innerHTML       = '<i class="bi bi-arrow-return-left me-1"></i>Kembalian';
            display.textContent   = '—';
            submitBtn.disabled    = true;
            submitBtn.className   = 'btn btn-secondary btn-lg fw-semibold';
        } else if (change < 0) {
            box.style.background  = '#fdecea';
            box.style.borderColor = '#ef9a9a';
            display.style.color   = '#c62828';
            label.style.color     = '#c62828';
            label.innerHTML       = '<i class="bi bi-exclamation-circle me-1"></i>Kurang Bayar';
            display.textContent   = '- ' + formatRupiah(Math.abs(change));
            submitBtn.disabled    = true;
            submitBtn.className   = 'btn btn-secondary btn-lg fw-semibold';
        } else {
            box.style.background  = '#e8f5e9';
            box.style.borderColor = '#a5d6a7';
            display.style.color   = '#2e7d32';
            label.style.color     = '#2e7d32';
            label.innerHTML       = '<i class="bi bi-arrow-return-left me-1"></i>Kembalian';
            display.textContent   = formatRupiah(change);
            submitBtn.disabled    = false;
            submitBtn.className   = 'btn btn-success btn-lg fw-semibold';
        }
    });
}
</script>
@endsection
