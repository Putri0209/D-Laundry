@extends('layouts.app')

@section('content')
<div class="card">
<div class="card-body">

<h5 class="card-title">Detail Transaksi</h5>

{{-- ================= HEADER (DISABLE) ================= --}}
<div class="row">
    <div class="col-md-6 mb-3">
        <label>Pelanggan</label>
        <input type="text" class="form-control"
            value="{{ $order->customer_id ? $order->customer->customer_name : $order->customer_name . ' (Non-Member)' }}" disabled>
    </div>

    <div class="col-md-6 mb-3">
        <label>Tanggal Laundry</label>
        <input type="date" class="form-control"
            value="{{ $order->order_date }}" disabled>
    </div>
</div>

<hr>

{{-- ================= DETAIL (READ ONLY TABLE) ================= --}}
<h6>Detail Layanan</h6>

<table class="table table-bordered" id="table-detail">
    <thead>
        <tr>
            <th>Layanan</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->details as $d)
        <tr>
            <td>
                <input type="text" class="form-control"
                    value="{{ $d->service->service_name }}" disabled>
            </td>

            <td>
                <input type="number" class="form-control"
                    value="{{ $d->qty }}" disabled>
            </td>

            <td>
                <input type="text" class="form-control"
                    value="Rp {{ number_format($d->service->price) }}" disabled>
            </td>

            <td>
                <input type="text" class="form-control"
                    value="Rp {{ number_format($d->subtotal) }}" disabled>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- ================= TOTAL ================= --}}
<div class="row mt-3">

    {{-- SUBTOTAL --}}
    <div class="col-md-6">
        <p>Subtotal</p>
    </div>
    <div class="col-md-6 text-end">
       Rp {{ number_format($order->subtotal > 0 ? $order->subtotal : $order->details->sum('subtotal')) }}
    </div>

    @if($order->discount_nominal > 0)
    {{-- DISCOUNT --}}
    <div class="col-md-6">
        <p>Diskon ({{ $order->discount_percent }}%)</p>
    </div>
    <div class="col-md-6 text-end text-danger">
        <p>Rp {{ number_format($order->discount_nominal) }}</p>
    </div>
    @endif

    {{-- TAX --}}
    <div class="col-md-6">
        <p>Pajak (10%)</p>
    </div>
    <div class="col-md-6 text-end">
        <p>Rp {{ number_format($order->tax) }}</p>
    </div>

    {{-- TOTAL --}}
    <div class="col-md-6">
        <h6>Total</h6>
    </div>
    <div class="col-md-6 text-end">
        <h5 id="display-total">Rp {{ number_format($order->total) }}</h5>
        <input type="hidden" id="input-total" value="{{ $order->total }}">
    </div>

</div>

<hr>

{{-- ================= PEMBAYARAN ================= --}}
@if($order->payment_status == 0)

<form action="{{ route('transaction.pay', $order->id) }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-md-4">
            <label>Jumlah Bayar</label>
            <input type="number" name="order_pay" id="input-pay"
                class="form-control" placeholder="Masukkan uang">
        </div>

        <div class="col-md-4">
            <label>Kembalian</label>
            <input type="text" id="input-change"
                class="form-control" readonly>
        </div>
    </div>

    <button class="btn btn-success mt-3">
        Bayar
    </button>
</form>

@else
<div class="alert alert-success mt-3 ">
    <b>LUNAS</b><br>
    {{-- Bayar: Rp {{ number_format($order->order_pay) }}<br>
    Kembalian: Rp {{ number_format($order->order_change) }} --}}
</div>
@endif

</div>
</div>
<script>
function formatRupiah(angka) {
    return 'Rp ' + Number(angka).toLocaleString('id-ID');
}

document.getElementById('input-pay')?.addEventListener('input', function() {
    const total = parseInt(document.getElementById('input-total').value) || 0;
    const pay = parseInt(this.value) || 0;
    const change = pay - total;

    const changeInput = document.getElementById('input-change');

    changeInput.value = formatRupiah(Math.max(0, change));
    changeInput.style.color = change < 0 ? 'red' : 'green';
});

document.querySelector('form')?.addEventListener('submit', function(e) {
    const total = parseInt(document.getElementById('input-total').value) || 0;
    const pay = parseInt(document.getElementById('input-pay').value) || 0;

    if (pay < total) {
        e.preventDefault();
        alert('Pembayaran kurang! Nominal yang dibayarkan tidak boleh kurang dari total tagihan.');
    }
});
</script>
@endsection


