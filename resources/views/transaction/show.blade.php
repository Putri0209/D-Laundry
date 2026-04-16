@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Detail Transaksi</h5>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            {{-- Header Detail --}}
            <div class="mb-3">
                <p><b>Customer:</b> {{ $order->customer->customer_name }}</p>
                <p><b>Order Code:</b> {{ $order->order_code }}</p>
                <p><b>Tanggal Order:</b> {{ $order->order_date }}</p>
                <p><b>Tanggal Selesai:</b> {{ $order->order_end_date }}</p>

                <p><b>Status:</b>
                    @if($order->order_status == 0)
                        <span class="badge bg-warning">Belum Diambil</span>
                    @else
                        <span class="badge bg-success">Sudah Diambil</span>
                    @endif
                </p>
            </div>

            <hr>

            {{-- Detail --}}
            <h6>Detail Layanan</h6>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $d)
                    <tr>
                        <td>{{ optional($d->service)->service_name ?? '-' }}</td>
                        <td>{{ $d->qty }}</td>
                        <td>Rp {{ number_format(optional($d->service)->price ?? 0) }}</td>
                        <td>Rp {{ number_format($d->subtotal) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Total --}}
            <div class="mt-3">
                <strong>Total: Rp {{ number_format($order->total) }}</strong>
            </div>

            <hr>

            {{-- ================= PROSES PICKUP ================= --}}

@if($order->order_status == 0)
    <strong>Proses Pickup</strong>

    <form action="{{ route('transaction.updateStatus', $order->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Notes Pickup</label>
            <input type="text" name="notes" class="form-control"
                   placeholder="Contoh: Diambil oleh kakaknya">
        </div>

        <button type="submit"
            onclick="return confirm('Yakin laundry sudah diambil?')"
            class="btn btn-primary">
            Sudah Diambil
        </button>
    </form>

@else
    <div class="alert alert-success">
        <h6 class="mb-2">Laundry Sudah Diambil</h6>

        <p class="mb-1">
            <b>Tanggal Ambil:</b><br>
            {{ \Carbon\Carbon::parse($order->pickup->pickup_date)->format('d-m-Y H:i') }}
        </p>

        <p class="mb-0">
            <b>Catatan:</b><br>
            {{ $order->pickup->notes ?? '-' }}
        </p>
    </div>
@endif

        </div>
    </div>
</div>
@endsection
