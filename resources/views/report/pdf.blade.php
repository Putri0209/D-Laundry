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
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($orders as $key => $order)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $order->order_code }}</td>
                <td class="text-left">{{ $order->customer->customer_name }}</td>
                <td>{{ $order->order_date }}</td>
                <td>{{ $order->order_end_date }}</td>
                <td>Rp {{ number_format($order->total) }}</td>
                <td>
                    {{ $order->order_status == 0 ? 'Belum Diambil' : 'Sudah Diambil' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ================= TOTAL ================= --}}
    <br>
    <table>
        <tr>
            <td class="text-left"><strong>Total Pendapatan</strong></td>
            <td><strong>Rp {{ number_format($orders->sum('total')) }}</strong></td>
        </tr>
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
