@extends('layouts.app')
@section('content')
<div class="row">
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <h5 class="card-title mb-3">{{ $title ?? '' }}</h5>

            <form action="{{ route('transaction.store') }}" method="POST" id="main-form">
                @csrf

                <div class="row">

                    {{-- ===== KOLOM KIRI ===== --}}
                    <div class="col-lg-8">

                        {{-- Tipe Pelanggan --}}
                        <div class="mb-3">
                            <label class="fw-semibold d-block mb-2">Tipe Pelanggan</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="customer_type" id="type_member"
                                    value="member" checked onchange="toggleCustomerType()">
                                <label class="form-check-label" for="type_member">Member Terdaftar</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="customer_type" id="type_baru"
                                    value="baru" onchange="toggleCustomerType()">
                                <label class="form-check-label" for="type_baru">Data Baru / Non-Member</label>
                            </div>
                        </div>

                        <div class="row mb-3 mt-3">
                            {{-- Pilih Customer (Member) --}}
                            <div class="col-md-6" id="section_member">
                                <label class="form-label fw-semibold">Pilih Pelanggan (Member)</label>
                                <select name="customer_id" class="form-select" onchange="recalcTotal()">
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->customer_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Data Baru --}}
                            <div class="col-md-12 d-none" id="section_baru">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Nama Pelanggan</label>
                                        <input type="text" name="customer_name" class="form-control" placeholder="Nama Pelanggan" value="{{ old('customer_name') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">No. Telepon</label>
                                        <input type="text" name="customer_phone" class="form-control" placeholder="No. Telepon" value="{{ old('customer_phone') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Alamat</label>
                                        <input type="text" name="customer_address" class="form-control" placeholder="Alamat" value="{{ old('customer_address') }}">
                                    </div>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_new_member" id="is_new_member" value="1" onchange="recalcTotal()">
                                    <label class="form-check-label fw-semibold text-success" for="is_new_member">
                                        <i class="bi bi-tag-fill me-1"></i>Daftar sebagai Member Baru (Diskon 5%)
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-3 mt-3">
                                <label class="form-label fw-semibold">Tanggal Laundry</label>
                                <input type="date" name="order_date" class="form-control" value="{{ old('order_date') }}">
                            </div>
                            <div class="col-md-3 mt-3">
                                <label class="form-label fw-semibold">Estimasi Selesai</label>
                                <input type="date" name="order_end_date" class="form-control" value="{{ old('order_end_date') }}">
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Tabel Detail Layanan --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Detail Layanan</h6>
                            <button type="button" id="btn-add" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-plus-lg me-1"></i>Tambah Layanan
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" id="table-detail">
                                <thead class="table-light">
                                    <tr>
                                        <th>Layanan</th>
                                        <th style="width:130px">Harga</th>
                                        <th style="width:90px">Qty (Kg)</th>
                                        <th style="width:130px" class="text-end">Subtotal</th>
                                        <th>Catatan</th>
                                        <th style="width:44px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="service_id[]" class="form-select form-select-sm service-select">
                                                <option value="">-- Pilih --</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                                        {{ $service->service_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm price-display" readonly placeholder="Rp 0" style="background:#f8f9fa">
                                        </td>
                                        <td>
                                            <input type="number" name="qty[]" class="form-control form-control-sm qty-input" min="0.1" step="0.1" value="1">
                                        </td>
                                        <td class="text-end">
                                            <span class="subtotal-display fw-bold text-success">Rp 0</span>
                                            <input type="hidden" name="subtotal[]" class="subtotal-hidden" value="0">
                                        </td>
                                        <td>
                                            <input type="text" name="notes[]" class="form-control form-control-sm" placeholder="Opsional">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-remove p-1 lh-1">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Voucher --}}
                        <div class="mt-3">
                            <label class="form-label fw-semibold">Kode Voucher <span class="text-muted fw-normal">(Opsional)</span></label>
                            <div class="input-group" style="max-width:320px">
                                <span class="input-group-text bg-white"><i class="bi bi-ticket-perforated text-muted"></i></span>
                                <input type="text" name="voucher_code" id="voucher_code" class="form-control"
                                    placeholder="Masukkan kode voucher..." oninput="recalcTotal()">
                            </div>
                            <small class="text-muted">Setiap voucher valid memberikan diskon 10%.</small>
                        </div>

                    </div>

                    {{-- ===== KOLOM KANAN: Panel Pembayaran ===== --}}
                    <div class="col-lg-4">
                        <div class="sticky-top" style="top: 80px;">
                            <div class="card border-0 rounded-3 overflow-hidden shadow-sm">

                                <div class="card-header border-0 bg-primary text-white py-3 px-4">
                                    <h6 class="mb-0 fw-bold">
                                        <i class="bi bi-receipt me-2"></i>Ringkasan Pembayaran
                                    </h6>
                                </div>

                                <div class="card-body p-4">

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted small">Subtotal</span>
                                        <span id="display-subtotal" class="fw-semibold small">Rp 0</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted small">Pajak (10%)</span>
                                        <span id="display-tax" class="fw-semibold small">Rp 0</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted small">Diskon (<span id="discount-percent-label">0</span>%)</span>
                                        <span id="display-discount" class="fw-semibold small text-danger"> Rp 0</span>
                                    </div>

                                    <div class="border-top pt-3 mb-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">Total</span>
                                            <span id="display-grandtotal" class="fw-bold fs-5 text-success">Rp 0</span>
                                        </div>
                                    </div>

                                    <input type="hidden" name="subtotal" id="input-subtotal">
                                    <input type="hidden" name="discount_percent" id="input-discount-percent" value="0">
                                    <input type="hidden" name="discount_nominal" id="input-discount-nominal" value="0">
                                    <input type="hidden" name="tax" id="input-tax">
                                    <input type="hidden" name="total" id="input-grandtotal">

                                    {{-- Input Bayar --}}
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small text-muted text-uppercase">Jumlah Bayar</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white text-muted fw-bold">Rp</span>
                                            <input type="number" name="order_pay" id="input-pay"
                                                class="form-control form-control-lg fw-semibold"
                                                min="0" placeholder="0"
                                                value="{{ old('order_pay', '') }}"
                                                style="font-size:1.1rem">
                                        </div>
                                        <small class="text-muted">Kosongkan jika bayar saat pengambilan</small>
                                    </div>

                                    {{-- Kembalian display --}}
                                    <div class="rounded-3 p-3 mb-4" id="kembalian-box"
                                        style="background:#f8f9fa; border:1.5px solid #dee2e6; transition: all .2s ease">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-semibold small" id="kembalian-label" style="color:#6c757d">
                                                <i class="bi bi-arrow-return-left me-1"></i>Kembalian
                                            </span>
                                            <span id="display-change" class="fw-bold fs-5" style="color:#6c757d">—</span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="order_change" id="input-change" value="0">

                                    {{-- Tombol --}}
                                    <div class="d-grid gap-2">
                                        <button type="submit" id="submit-btn" class="btn btn-primary btn-lg fw-semibold">
                                            <i class="bi bi-save me-2"></i>Simpan Transaksi
                                        </button>
                                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Batal</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const servicePrices = {
        @foreach ($services as $service)
            "{{ $service->id }}": {{ $service->price }},
        @endforeach
    };

    const newMemberCustomers = [
        @foreach ($customers as $customer)
            @if(!\App\Models\TransOrder::where('customer_id', $customer->id)->exists())
                "{{ $customer->id }}",
            @endif
        @endforeach
    ];

    function formatRupiah(angka) {
        return 'Rp ' + Number(angka).toLocaleString('id-ID');
    }

    function updateRow(row) {
        const select          = row.querySelector('.service-select');
        const qtyInput        = row.querySelector('.qty-input');
        const priceDisplay    = row.querySelector('.price-display');
        const subtotalDisplay = row.querySelector('.subtotal-display');
        const subtotalHidden  = row.querySelector('.subtotal-hidden');

        const serviceId = select.value;
        const price     = servicePrices[serviceId] || 0;
        const qty       = parseFloat(qtyInput.value) || 0;
        const subtotal  = price * qty;

        priceDisplay.value          = price ? formatRupiah(price) : '';
        subtotalDisplay.textContent = formatRupiah(subtotal);
        subtotalHidden.value        = subtotal;

        recalcTotal();
    }

    function recalcTotal() {
        let subtotal = 0;
        document.querySelectorAll('#table-detail tbody tr').forEach(row => {
            subtotal += parseInt(row.querySelector('.subtotal-hidden').value) || 0;
        });

        let discountPercent = 0;
        const isBaru      = document.getElementById('type_baru').checked;
        const isMember    = document.getElementById('type_member').checked;
        const isNewMember = document.getElementById('is_new_member').checked;

        if (isBaru && isNewMember) {
            discountPercent += 5;
        } else if (isMember) {
            const selectedId = document.querySelector('select[name="customer_id"]').value;
            if (newMemberCustomers.includes(selectedId)) discountPercent += 5;
        }

        const voucherCode = document.getElementById('voucher_code').value.trim();
        if (voucherCode !== '') discountPercent += 10;

        const tax             = Math.round(subtotal * 0.10);
        const subtotalWithTax = subtotal + tax;
        const discountNominal = Math.round(subtotalWithTax * (discountPercent / 100));
        const grandTotal      = subtotalWithTax - discountNominal;

        document.getElementById('display-subtotal').textContent         = formatRupiah(subtotal);
        document.getElementById('display-tax').textContent              = formatRupiah(tax);
        document.getElementById('display-discount').textContent         = discountNominal > 0 ? '- ' + formatRupiah(discountNominal) : 'Rp 0';
        document.getElementById('discount-percent-label').textContent   = discountPercent;
        document.getElementById('display-grandtotal').textContent       = formatRupiah(grandTotal);

        document.getElementById('input-subtotal').value         = subtotal;
        document.getElementById('input-discount-percent').value = discountPercent;
        document.getElementById('input-discount-nominal').value = discountNominal;
        document.getElementById('input-tax').value              = tax;
        document.getElementById('input-grandtotal').value       = grandTotal;

        calcChange();
    }

    function toggleCustomerType() {
        const isMember = document.getElementById('type_member').checked;
        document.getElementById('section_member').classList.toggle('d-none', !isMember);
        document.getElementById('section_baru').classList.toggle('d-none', isMember);
        if (isMember) document.getElementById('is_new_member').checked = false;
        recalcTotal();
    }

    function calcChange() {
        const grandTotal = parseInt(document.getElementById('input-grandtotal').value) || 0;
        const payRaw     = document.getElementById('input-pay').value;
        const pay        = parseInt(payRaw) || 0;
        const box        = document.getElementById('kembalian-box');
        const display    = document.getElementById('display-change');
        const label      = document.getElementById('kembalian-label');
        const submitBtn  = document.getElementById('submit-btn');

        // Jika input bayar kosong = bayar nanti, tidak ada validasi
        if (payRaw === '' || pay === 0) {
            box.style.background    = '#f8f9fa';
            box.style.borderColor   = '#dee2e6';
            display.style.color     = '#6c757d';
            label.style.color       = '#6c757d';
            label.innerHTML         = '<i class="bi bi-arrow-return-left me-1"></i>Kembalian';
            display.textContent     = '—';
            document.getElementById('input-change').value = 0;
            submitBtn.disabled      = false;
            submitBtn.className     = 'btn btn-primary btn-lg fw-semibold';
            return;
        }

        const change = pay - grandTotal;
        document.getElementById('input-change').value = Math.max(0, change);

        if (change < 0) {
            // Kurang bayar — merah + disable
            box.style.background    = '#fdecea';
            box.style.borderColor   = '#ef9a9a';
            display.style.color     = '#c62828';
            label.style.color       = '#c62828';
            label.innerHTML         = '<i class="bi bi-exclamation-circle me-1"></i>Kurang Bayar';
            display.textContent     = '- ' + formatRupiah(Math.abs(change));
            submitBtn.disabled      = true;
            submitBtn.className     = 'btn btn-secondary btn-lg fw-semibold';
        } else {
            // Cukup — hijau
            box.style.background    = '#e8f5e9';
            box.style.borderColor   = '#a5d6a7';
            display.style.color     = '#2e7d32';
            label.style.color       = '#2e7d32';
            label.innerHTML         = '<i class="bi bi-arrow-return-left me-1"></i>Kembalian';
            display.textContent     = formatRupiah(change);
            submitBtn.disabled      = false;
            submitBtn.className     = 'btn btn-primary btn-lg fw-semibold';
        }
    }

    document.querySelector('#table-detail').addEventListener('change', function(e) {
        const row = e.target.closest('tr');
        if (row && (e.target.classList.contains('service-select') || e.target.classList.contains('qty-input'))) {
            updateRow(row);
        }
    });

    document.querySelector('#table-detail').addEventListener('input', function(e) {
        const row = e.target.closest('tr');
        if (row && e.target.classList.contains('qty-input')) updateRow(row);
    });

    document.getElementById('input-pay').addEventListener('input', calcChange);

    document.getElementById('btn-add').addEventListener('click', function() {
        const tbody  = document.querySelector('#table-detail tbody');
        const newRow = tbody.rows[0].cloneNode(true);
        newRow.querySelectorAll('input:not([type=hidden])').forEach(i => i.value = '');
        newRow.querySelector('input[type=number]').value      = 1;
        newRow.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
        newRow.querySelector('.subtotal-display').textContent = 'Rp 0';
        newRow.querySelector('.subtotal-hidden').value        = 0;
        newRow.querySelector('.price-display').value          = '';
        tbody.appendChild(newRow);
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove')) {
            const tbody = document.querySelector('#table-detail tbody');
            if (tbody.rows.length > 1) {
                e.target.closest('tr').remove();
                recalcTotal();
            }
        }
    });
</script>
@endsection
