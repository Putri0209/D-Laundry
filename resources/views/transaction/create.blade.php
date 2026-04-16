@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card">
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

                <h5 class="card-title">{{ $title ?? '' }}</h5>

                <form action="{{ route('transaction.store') }}" method="POST">
                    @csrf

                    {{-- Header Order --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Order Code</label>
                                <input type="text" class="form-control" value="ORD-{{ now()->format('YmdHis') }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label>Order Date</label>
                                <input type="date" name="order_date" class="form-control"
                                    value="{{ old('order_date') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Customer</label>
                                <select name="customer_id" class="form-control">
                                    <option value="">--Select Customer--</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->customer_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Order End Date</label>
                                <input type="date" name="order_end_date" class="form-control"
                                    value="{{ old('order_end_date') }}">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6>Detail Layanan</h6>

                    {{-- Tabel Detail --}}
                    <table class="table" id="table-detail">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Qty (Kg)</th>
                                <th class="text-end">Subtotal</th>
                                <th>Notes</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="service_id[]" class="form-control service-select">
                                        <option value="">--Select Service--</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                                {{ $service->service_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control price-display" readonly placeholder="Rp 0"
                                        style="background:#f8f9fa; min-width:120px">
                                </td>
                                <td>
                                    <input type="number" name="qty[]" class="form-control qty-input" min="0.1"
                                        step="0.1" value="1" style="width:80px">
                                </td>
                                <td class="text-end">
                                    <span class="subtotal-display fw-bold text-success">Rp 0</span>
                                    <input type="hidden" name="subtotal[]" class="subtotal-hidden" value="0">
                                </td>
                                <td>
                                    <input type="text" name="notes[]" class="form-control">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm btn-remove">✕</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="button" id="btn-add" class="btn btn-outline-primary btn-sm mb-4">
                        + Add Service
                    </button>

                    <hr>

                    {{-- Pembayaran --}}
                    <div class="row">
                        <div class="col-md-5 offset-md-7">
                            <table class="table table-sm">
                                <tr>
                                    <td class="fw-semibold">Subtotal</td>
                                    <td class="text-end fw-bold fs-5 text-success" id="display-subtotal">Rp 0</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Tax (10%)</td>
                                    <td class="text-end fw-bold fs-5 text-success" id="display-tax">Rp 0</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Total</td>
                                    <td class="text-end fw-bold fs-5 text-success" id="display-grandtotal">Rp 0</td>
                                </tr>
                            </table>

                            <input type="hidden" name="subtotal" id="input-subtotal">
                            <input type="hidden" name="tax" id="input-tax">
                            <input type="hidden" name="total" id="input-grandtotal">

                            <div class="mb-3">
                                <label class="fw-semibold">Payment (Rp)</label>
                                <input type="number" name="order_pay" id="input-pay" class="form-control form-control-lg"
                                    min="0" placeholder="0" value="{{ old('order_pay', 0) }}">
                            </div>

                            <div class="mb-3">
                                <label class="fw-semibold">Change (Rp)</label>
                                <input type="number" name="order_change" id="input-change"
                                    class="form-control form-control-lg fw-bold" readonly value="0"
                                    style="background:#f4faf6">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        // Data Harga
        const servicePrices = {
            @foreach ($services as $service)
                "{{ $service->id }}": {{ $service->price }},
            @endforeach
        };

        function formatRupiah(angka) {
            return 'Rp ' + Number(angka).toLocaleString('id-ID');
        }

        // subtotal
        function updateRow(row) {
            const select = row.querySelector('.service-select');
            const qtyInput = row.querySelector('.qty-input');
            const priceDisplay = row.querySelector('.price-display');
            const subtotalDisplay = row.querySelector('.subtotal-display');
            const subtotalHidden = row.querySelector('.subtotal-hidden');

            const serviceId = select.value;
            const price = servicePrices[serviceId] || 0;
            const qty = parseFloat(qtyInput.value) || 0;
            const subtotal = price * qty;


            priceDisplay.value = price ? formatRupiah(price) : '';
            subtotalDisplay.textContent = formatRupiah(subtotal);
            subtotalHidden.value = subtotal;

            recalcTotal();
        }

        // Recalculate Total
        function recalcTotal() {
            let subtotal = 0;
            document.querySelectorAll('#table-detail tbody tr').forEach(row => {
                subtotal += parseInt(row.querySelector('.subtotal-hidden').value) || 0;
            });

            const tax = Math.round(subtotal * 0.10);
            const grandTotal = subtotal + tax;

            document.getElementById('display-subtotal').textContent = formatRupiah(subtotal);
            document.getElementById('display-tax').textContent = formatRupiah(tax);
            document.getElementById('display-grandtotal').textContent = formatRupiah(grandTotal);

            document.getElementById('input-subtotal').value = subtotal;
            document.getElementById('input-tax').value = tax;
            document.getElementById('input-grandtotal').value = grandTotal;

            calcChange();
        }

        // Kembalian
        function calcChange() {
            const grandTotal = parseInt(document.getElementById('input-grandtotal').value) || 0;
            const pay = parseInt(document.getElementById('input-pay').value) || 0;
            const change = pay - grandTotal;

            const changeInput = document.getElementById('input-change');
            changeInput.value = Math.max(0, change);
            changeInput.style.color = change < 0 ? '#dc2626' : '#16a34a';
        }

        // Select - qty
        document.querySelector('#table-detail').addEventListener('change', function(e) {
            const row = e.target.closest('tr');
            if (row && (e.target.classList.contains('service-select') ||
                    e.target.classList.contains('qty-input'))) {
                updateRow(row);
            }
        });

        document.querySelector('#table-detail').addEventListener('input', function(e) {
            const row = e.target.closest('tr');
            if (row && e.target.classList.contains('qty-input')) {
                updateRow(row);
            }
        });

        //    Jumlah Bayar
        document.getElementById('input-pay').addEventListener('input', calcChange);

        // Tambah layanan
        document.getElementById('btn-add').addEventListener('click', function() {
            const tbody = document.querySelector('#table-detail tbody');
            const firstRow = tbody.rows[0];
            const newRow = firstRow.cloneNode(true);

            newRow.querySelectorAll('input:not([type=hidden])').forEach(i => i.value = '');
            newRow.querySelector('input[type=number]').value = 1;
            newRow.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
            newRow.querySelector('.subtotal-display').textContent = 'Rp 0';
            newRow.querySelector('.subtotal-hidden').value = 0;
            newRow.querySelector('.price-display').value = '';

            tbody.appendChild(newRow);
        });

        // Hapus layanan
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-remove')) {
                const tbody = document.querySelector('#table-detail tbody');
                if (tbody.rows.length > 1) {
                    e.target.closest('tr').remove();
                    recalcTotal();
                }
            }
        });
    </script>
@endsection
