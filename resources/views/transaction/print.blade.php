<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk - {{ $orders->order_code }}</title>
    <style>
        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            background-color: #f0f0f0;
        }

        .receipt {
            width: 300px;
            background: #fff;
            margin: 20px auto;
            padding: 20px 24px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 16px;
        }
        .header h3 {
            margin: 0 0 6px 0;
            font-size: 16px;
            letter-spacing: 1px;
        }
        .header p {
            margin: 4px 0;
            font-size: 11px;
        }

        .divider {
            border: none;
            border-top: 1px dashed #000;
            margin: 12px 0;
        }

        .info table {
            width: 100%;
            font-size: 11px;
            border-collapse: collapse;
        }
        .info td {
            padding: 3px 0;
            vertical-align: top;
        }
        .info td:first-child {
            width: 85px;
            white-space: nowrap;
        }

        .items table {
            width: 100%;
            font-size: 11px;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .items th, .items td {
            vertical-align: top;
        }
        .items th {
            text-align: left;
            border-bottom: 1px dashed #000;
            padding: 4px 0 8px;
        }
        .items td {
            padding: 5px 0;
        }
        .items th:nth-child(1), .items td:nth-child(1) { width: auto; }
        .items th:nth-child(2), .items td:nth-child(2) { width: 45px; text-align: right; white-space: nowrap; }
        .items th:nth-child(3), .items td:nth-child(3) { width: 85px; text-align: right; white-space: nowrap; }

        .totals table {
            width: 100%;
            font-size: 11px;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .totals td {
            padding: 3px 0;
            vertical-align: top;
        }
        .totals td:first-child  { width: auto; }
        .totals td:last-child   { width: 110px; text-align: right; white-space: nowrap; }

        .status-box {
            text-align: center;
            padding: 8px 12px;
            margin: 12px 0;
            font-weight: bold;
            font-size: 12px;
        }
        .status-lunas  { border: 2px solid #000; letter-spacing: 2px; }
        .status-belum  { border: 2px dashed #000; letter-spacing: 1px; }

        .footer {
            text-align: center;
            margin-top: 12px;
            font-size: 10px;
            line-height: 2;
        }

        @media print {
            html, body { background: transparent; }
            .receipt {
                width: 100%;
                max-width: 300px;
                margin: 0 auto;
                padding: 20px 24px;
                box-shadow: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
<div class="receipt">

    {{-- Header --}}
    <div class="header">
        <h3>D'Laundry</h3>
        <p>Jalan Cempaka Putih</p>
        <p>Telp: 0876568857</p>
    </div>

    <div class="divider"></div>

    {{-- Info Order --}}
    <div class="info">
        <table>
            <tr>
                <td>No. Order</td>
                <td>: {{ $orders->order_code }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ \Carbon\Carbon::parse($orders->order_date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>Est. Selesai</td>
                <td>: {{ \Carbon\Carbon::parse($orders->order_end_date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td>: {{ $orders->customer_id ? ($orders->customer->customer_name ?? '-') : ($orders->customer_name ?? '-') }}
                    @if(!$orders->customer_id) (Non-Member) @endif
                </td>
            </tr>
            <tr>
                <td>Cetak</td>
                <td>: {{ now()->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <div class="divider"></div>

    {{-- Detail Layanan --}}
    <div class="items">
        <table>
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th style="text-align:right">Qty</th>
                    <th style="text-align:right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders->details as $d)
                <tr>
                    <td>{{ $d->service->service_name ?? '-' }}</td>
                    <td style="text-align:right">{{ $d->qty }}kg</td>
                    <td style="text-align:right">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                </tr>
                @if($d->notes)
                <tr>
                    <td colspan="3" style="font-size:10px; padding-left:4px; padding-bottom:4px;">* {{ $d->notes }}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="divider"></div>

    {{-- Totals --}}
    <div class="totals">
        @php
            $subtotalVal = $orders->subtotal > 0 ? $orders->subtotal : $orders->details->sum('subtotal');
        @endphp
        <table>
            <tr>
                <td>Subtotal</td>
                <td>Rp {{ number_format($subtotalVal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Pajak (10%)</td>
                <td>Rp {{ number_format($orders->tax, 0, ',', '.') }}</td>
            </tr>
            @if($orders->discount_nominal > 0)
            <tr>
                <td>Diskon ({{ $orders->discount_percent }}%)</td>
                <td>-Rp {{ number_format($orders->discount_nominal, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr style="font-weight:bold; font-size:13px">
                <td style="border-top:1px dashed #000; padding-top:8px;">TOTAL</td>
                <td style="border-top:1px dashed #000; padding-top:8px;">Rp {{ number_format($orders->total, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    {{-- Status Pembayaran --}}
    @if($orders->payment_status == 1)
        <div class="divider"></div>
        <div class="totals">
            <table>
                <tr>
                    <td>Tunai</td>
                    <td>Rp {{ number_format($orders->order_pay, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Kembali</td>
                    <td>Rp {{ number_format($orders->order_change, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="status-box status-lunas">✓ LUNAS</div>
    @else
        <div class="status-box status-belum">⚠ BELUM DIBAYAR</div>
    @endif

    <div class="divider"></div>

    {{-- Footer --}}
    <div class="footer">
        <p style="margin: 0;">Terima kasih atas kunjungan Anda!</p>
        <p style="margin: 4px 0 0;">Harap bawa struk ini saat pengambilan</p>
    </div>

</div>
</body>
</html>
