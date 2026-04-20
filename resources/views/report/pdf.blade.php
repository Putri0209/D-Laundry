<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi Laundry</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .title {
            text-align: center;
            margin-bottom: 10px;
        }

        .title h2 {
            margin: 0;
        }

        .periode {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-left {
            text-align: left;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>

<body>

    {{-- ================= TITLE ================= --}}
    <div class="title">
        <h2>LAPORAN TRANSAKSI LAUNDRY</h2>
    </div>

    {{-- ================= PERIODE ================= --}}
    <div class="periode">
        <strong>Periode:</strong>
        @if(request('start_date') && request('end_date'))
            {{ request('start_date') }} s/d {{ request('end_date') }}
        @else
            Semua Data
        @endif
    </div>

    {{-- ================= TABLE ================= --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Order Code</th>
                <th>Customer</th>
                <th>Tanggal</th>
                <th>Selesai</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($orders as $key => $order)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $order->order_code }}</td>
                <td class="text-left">{{ $order->customer_id ? $order->customer->customer_name : $order->customer_name }}</td>
                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($order->order_end_date)->format('d-m-Y') }}</td>
                <td>
                    {{ $order->payment_status == 0 ? 'Belum Dibayar' : 'Lunas' }}
                </td>
                <td>Rp {{ number_format($order->total) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>

        {{-- ================= TOTAL ================= --}}
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"><strong>Total Pendapatan (Lunas)</strong></td>
                <td colspan="2"><strong>Rp {{ number_format($orders->where('payment_status', 1)->sum('total')) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    {{-- ================= FOOTER ================= --}}
    <div class="footer">
        <p>{{ date('d-m-Y') }}</p>
        <br><br><br>
        <p><strong>Pimpinan</strong></p>
    </div>

    {{-- ================= AUTO PRINT ================= --}}
    <script>
        window.onload = function() {
            window.print();
        }
    </script>

</body>
</html>
