@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <h5 class="card-title">{{ $title ?? 'Pickup Laundry' }}</h5>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Summary Badge --}}
                <div class="mb-3">
                    <span class="badge bg-warning text-dark fs-6">
                        <i class="bi bi-hourglass-split me-1"></i>
                        {{ $orders->total() }} laundry belum diambil
                    </span>
                </div>

                {{-- Tampilkan + Search sejajar --}}
                <div class="d-flex align-items-center mb-3 gap-2">

                    {{-- Per Page --}}
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small text-nowrap">Tampilkan</span>
                        <select class="form-select form-select-sm" style="width:75px" id="perpage-select">
                            @foreach([10, 20, 30] as $pp)
                                <option value="{{ $pp }}" {{ request('perpage', 10) == $pp ? 'selected' : '' }}>
                                    {{ $pp }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-muted small">data</span>
                    </div>

                    {{-- Search --}}
                    <form method="GET" action="{{ route('pickup.index') }}" class="d-flex gap-2 flex-grow-1 mx-3" id="search-form">
                        <input type="hidden" name="perpage" value="{{ request('perpage', 10) }}">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Cari nama atau kode order..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary btn-sm px-3">
                            <i class="bi bi-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('pickup.index', ['perpage' => request('perpage', 10)]) }}"
                                class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Tabel --}}
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Kode Order</th>
                            <th>Tgl Laundry</th>
                            <th>Est. Selesai</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $orders->firstItem() + $loop->index }}</td>
                                <td>
                                    {{ $order->customer_id ? $order->customer->customer_name : $order->customer_name }}
                                    @if(!$order->customer_id)
                                        <span class="badge bg-secondary ms-1" style="font-size:.7rem">Non-Member</span>
                                    @endif
                                </td>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}</td>
                                <td> {{\Carbon\Carbon::parse($order->order_end_date)->format('d-m-Y')}}
                                </td>
                                <td>
                                    @if($order->payment_status == 0)
                                        <span class="badge bg-danger">Belum Bayar</span>
                                    @else
                                        <span class="badge bg-success">Lunas</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">Belum Diambil</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('pickup.show', $order->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye me-1"></i>Detail & Proses
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

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }}
                        dari {{ $orders->total() }} pickup
                    </small>
                    {{ $orders->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('perpage-select').addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('perpage', this.value);
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    });
</script>
@endsection
