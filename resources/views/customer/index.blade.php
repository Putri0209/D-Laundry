@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $title ?? '' }}</h5>
                <div class="mb-3" align="right">
                    <a href="{{route('customer.create')}}" class="btn btn-primary btn-sm">Create New Customer</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:50px">No</th>
                            <th>Nama Pelanggan</th>
                            <th style="width:160px">No HP</th>
                            <th>Alamat</th>
                            <th style="width:100px" class="text-center">Aksi</th>
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
                                Tidak ada pelanggan ditemukan.
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
