@extends('layouts.app')
@section('content')
@section('content')
<div class="pagetitle">
    <h1>Data Pelanggan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Pelanggan</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <h5 class="card-title mb-4">{{ $title ?? '' }}</h5>

               {{-- Tampilkan + Search + Tambah sejajar --}}
<div class="d-flex justify-content-between align-items-center mb-3 gap-2">

    {{-- Kiri: Tampilkan + Search --}}
    <div class="d-flex align-items-center gap-2 flex-grow-1">

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
        <form method="GET" action="{{ route('customer.index') }}" class="d-flex gap-2 flex-grow-1 mx-3" id="search-form">
            <input type="hidden" name="perpage" value="{{ request('perpage', 10) }}">
            <input type="text" name="search" class="form-control form-control-sm"
                placeholder="Cari nama, no hp, atau alamat..."
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary btn-sm px-3">
                <i class="bi bi-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('customer.index', ['perpage' => request('perpage', 10)]) }}"
                    class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </form>
    </div>

    {{-- Kanan: Tambah --}}
    <a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm text-nowrap">
        <i class="bi bi-plus-lg me-1"></i>Tambah Pelanggan
    </a>
</div>

                {{-- Tabel --}}
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th >No</th>
                            <th>Nama Pelanggan</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                        <tr>
                            <td>{{ $customers->firstItem() + $loop->index }}</td>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->address }}</td>
                            <td class="text-center">
                                <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                Data pelanggan kosong
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Menampilkan {{ $customers->firstItem() }}–{{ $customers->lastItem() }}
                        dari {{ $customers->total() }} pelanggan
                    </small>
                    {{ $customers->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('perpage-select').addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('perpage', this.value);
        url.searchParams.set('page', 1); // reset ke halaman 1
        window.location.href = url.toString();
    });
</script>
@endsection
