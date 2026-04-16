@extends('layouts.app')

@section('content')
<div class="row">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Pickup Laundry</h5>

            {{-- ALERT --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- HEADER --}}
            <div class="mb-3">
                <p><b>Customer:</b> {{ $order->customer->customer_name }}</p>
                <p><b>Order Code:</b> {{ $order->order_code }}</p>

                <p><b>Status Pembayaran:</b>
                    @if($order->payment_status == 0)
                        <span class="badge bg-danger">Belum Bayar</span>
                    @else
                        <span class="badge bg-success">Lunas</span>
                    @endif
                </p>

                <p><b>Status Order:</b>
                    @if($order->order_status == 0)
                        <span class="badge bg-warning">Belum Diambil</span>
                    @else
                        <span class="badge bg-success">Sudah Diambil</span>
                    @endif
                </p>
            </div>

            <hr>

            {{-- DETAIL --}}
            <h6>Detail Layanan</h6>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $d)
                    <tr>
                        <td>{{ $d->service->service_name }}</td>
                        <td>{{ $d->qty }}</td>
                        <td>Rp {{ number_format($d->subtotal) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- TOTAL --}}
            <div class="mt-3">
                <h5>Total: Rp {{ number_format($order->total) }}</h5>
            </div>

            <hr>

            {{-- ================= LOGIC PICKUP ================= --}}

            {{-- ❌ BELUM BAYAR --}}
            @if($order->payment_status == 0)

                <div class="alert alert-danger">
                    Harap lakukan pembayaran terlebih dahulu
                </div>

                <a href="{{ route('transaction.show', $order->id) }}"
                   class="btn btn-warning">
                    Bayar Sekarang
                </a>

            {{-- ✔ SUDAH BAYAR --}}
            @elseif($order->order_status == 0)

                <form action="{{ route('pickup.updateStatus', $order->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Catatan Pickup</label>
                        <input type="text" name="notes" class="form-control"
                               placeholder="Contoh: Diambil oleh kakaknya">
                    </div>

                    <button type="submit"
                        onclick="return confirm('Yakin laundry sudah diambil?')"
                        class="btn btn-primary">
                        Sudah Diambil
                    </button>
                </form>

            {{-- ✔ SUDAH DIAMBIL --}}
            @else
                <div class="alert alert-success">
                    <b>Sudah Diambil</b><br>
                    {{ \Carbon\Carbon::parse($pickup->pickup_date)->format('d-m-Y H:i') }}
                    <br>
                    Catatan: {{ $pickup->notes ?? '-' }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
