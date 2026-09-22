<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #111;
            margin: 0;
            padding: 0;
            background: #fff;
            font-size: 12px;
            font-weight: 500;
        }
        
        .rupee {
            font-family: 'DejaVu Sans', sans-serif !important;
            font-weight: normal !important;
        }

        .header-bg {
            background-color: #E67E22;
            height: 15px;
            width: 100%;
        }
        .footer-bg {
            background-color: #E67E22;
            height: 15px;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
        }
        .container {
            padding: 40px 50px;
            position: relative;
        }
        
        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
            color: #000;
        }
        
        /* Top Title */
        .title {
            font-size: 36px;
            font-weight: 900;
            color: #000;
            letter-spacing: 1px;
            margin-bottom: 40px;
        }
        
        /* Customer & Invoice Meta Section */
        .middle-section {
            width: 100%;
            margin-bottom: 40px;
            border-collapse: collapse;
        }
        .middle-section td {
            vertical-align: top;
        }
        
        .section-heading {
            font-size: 14px;
            color: #000;
            text-transform: uppercase;
            font-weight: 900;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 15px;
            width: 100%;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 4px 0;
            font-size: 12px;
            vertical-align: top;
        }
        .info-label {
            font-weight: 700;
            color: #000;
            width: 120px;
        }
        .info-value {
            color: #111;
            font-weight: 500;
        }
        
        /* Invoice Meta on Right */
        .invoice-meta-table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-meta-table td {
            padding: 4px 0;
            font-size: 12px;
        }
        .meta-label {
            font-weight: 700;
            color: #000;
            text-align: right;
            width: 60%;
            padding-right: 15px;
        }
        .meta-value {
            text-align: right;
            color: #111;
            font-weight: 700;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            text-align: left;
            padding: 12px 10px;
            background-color: #f0f0f0;
            border: 1px solid #000;
            font-size: 11px;
            text-transform: uppercase;
            color: #000;
            font-weight: 900;
        }
        .items-table td {
            padding: 15px 10px;
            border: 1px solid #000;
            vertical-align: top;
            font-size: 11px;
            color: #000;
        }
        .items-table th.right, .items-table td.right {
            text-align: right;
        }
        .items-table th.center, .items-table td.center {
            text-align: center;
        }
        .item-name {
            font-weight: 700;
            color: #000;
            margin-bottom: 5px;
            font-size: 12px;
        }
        .item-meta {
            color: #000;
            font-size: 11px;
            line-height: 1.5;
        }
        
        /* Totals & Payment */
        .bottom-area {
            width: 100%;
            margin-top: 20px;
        }
        .payment-info {
            padding-right: 20px;
        }
        .payment-heading {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 900;
            color: #000;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            display: inline-block;
        }
        .payment-table {
            border-collapse: collapse;
        }
        .payment-table td {
            padding: 4px 0;
            font-size: 11px;
        }
        .payment-label {
            font-weight: 700;
            color: #000;
            padding-right: 15px;
        }
        .payment-value {
            color: #111;
            font-weight: 500;
            text-transform: uppercase;
        }
        
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 10px;
            border: 1px solid #000;
            font-size: 12px;
        }
        .totals-label {
            font-weight: 700;
            color: #000;
            text-align: right;
            width: 60%;
            background-color: #f0f0f0;
        }
        .totals-val {
            text-align: right;
            font-weight: 700;
            color: #000;
        }
        .grand-total-row td {
            background-color: #e0e0e0;
        }
        .grand-total-label {
            font-size: 14px;
            font-weight: 900;
            color: #000;
        }
        .grand-total-val {
            font-size: 14px;
            font-weight: 900;
            color: #000;
        }
        
        /* Footer Area */
        .footer-thanks {
            margin-top: 50px;
            margin-bottom: 30px;
            font-size: 16px;
            font-weight: 900;
            color: #000;
            text-align: center;
        }
        
        .footer-details {
            width: 100%;
            border-top: 2px solid #000;
            padding-top: 20px;
            page-break-inside: avoid;
        }
        .company-logo-img {
            max-height: 80px;
            margin-bottom: 15px;
        }
        .company-name {
            font-size: 18px;
            font-weight: 900;
            color: #000;
            margin-bottom: 8px;
        }
        .contact-us-title {
            font-weight: 700;
            font-size: 13px;
            color: #000;
            margin-bottom: 5px;
        }
        .company-contact {
            color: #000;
            font-size: 13px;
            line-height: 1.8;
            font-weight: 500;
        }
        
        .signature {
            text-align: right;
            padding-right: 10px;
        }
        .signature-line {
            display: inline-block;
            width: 180px;
            border-bottom: 1px solid #000;
            margin-bottom: 8px;
        }
        .signature-text {
            font-size: 14px;
            font-weight: 700;
            color: #000;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 35%;
            left: 20%;
            width: 60%;
            opacity: 0.1;
            z-index: -100;
            text-align: center;
        }
        .watermark img {
            width: 80%;
            max-width: 400px;
            height: auto;
        }
    </style>
</head>
<body>

@php
    $base64Logo = null;
    if($settings && $settings->logo && file_exists(public_path($settings->logo))) {
        $type = pathinfo(public_path($settings->logo), PATHINFO_EXTENSION);
        $data = file_get_contents(public_path($settings->logo));
        $base64Logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
@endphp

@if($base64Logo)
<div class="watermark">
    <img src="{{ $base64Logo }}" alt="Watermark">
</div>
@endif

<div class="header-bg"></div>

<div class="container">
    
    <h1 class="title">INVOICE</h1>

    <table class="middle-section">
        <tr>
            <td style="width: 50%; padding-right: 20px;">
                <div class="section-heading" style="width: 80%;">BILLED TO</div>
                <table class="info-table">
                    <tr>
                        <td class="info-label">Name:</td>
                        <td class="info-value" style="font-weight: 900; font-size: 14px;">{{ $order->customer_name }}</td>
                    </tr>
                    @if($order->customer_mobile)
                    <tr>
                        <td class="info-label">Phone No:</td>
                        <td class="info-value">+91- {{ $order->customer_mobile }}</td>
                    </tr>
                    @endif
                    @if($order->customer_email)
                    <tr>
                        <td class="info-label">Email Id:</td>
                        <td class="info-value">{{ $order->customer_email }}</td>
                    </tr>
                    @endif
                    @if($order->address_type)
                    <tr>
                        <td class="info-label">Address Type:</td>
                        <td class="info-value" style="text-transform: uppercase;">{{ $order->address_type }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="info-label">Address:</td>
                        <td class="info-value">
                            {{ $order->address }}
                        </td>
                    </tr>
                    @if($order->city_name || $order->state_name)
                    <tr>
                        <td class="info-label">City, State:</td>
                        <td class="info-value">
                            {{ $order->city_name }}@if($order->city_name && $order->state_name), @endif{{ $order->state_name }} - {{ $order->pincode }}
                        </td>
                    </tr>
                    @endif
                </table>
            </td>
            
            <td style="width: 50%;">
                <div class="section-heading" style="width: 100%; text-align: right;">INVOICE DETAILS</div>
                <table class="invoice-meta-table">
                    <tr>
                        <td class="meta-label">Invoice No:</td>
                        <td class="meta-value">{{ $order->order_code }}</td>
                    </tr>
                    <tr>
                        <td class="meta-label">Date:</td>
                        <td class="meta-value">{{ $date }}</td>
                    </tr>
                    <tr>
                        <td class="meta-label">Status:</td>
                        <td class="meta-value" style="text-transform: uppercase;">
                            {{ $order->status }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 50%;">Item Description</th>
                <th class="center" style="width: 10%;">Qty</th>
                <th class="right" style="width: 20%;">Unit Price</th>
                <th class="right" style="width: 20%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            @php 
                $parts = explode('<br><small', $item['name']); 
                $mainName = $parts[0];
                $metaHtml = isset($parts[1]) ? '<small' . $parts[1] : '';
            @endphp
            <tr>
                <td>
                    <div class="item-name">{!! $mainName !!}</div>
                    @if($metaHtml)
                    <div class="item-meta">{!! $metaHtml !!}</div>
                    @endif
                </td>
                <td class="center" style="font-weight: 700;">{{ $item['quantity'] }}</td>
                <td class="right"><span class="rupee">&#8377;</span>{{ number_format($item['unit_price'], 2) }}</td>
                <td class="right" style="font-weight: 700;"><span class="rupee">&#8377;</span>{{ number_format($item['total'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="bottom-area">
        <tr>
            <td style="width: 50%; vertical-align: top;" class="payment-info">
                <div class="payment-heading">Payment Information</div>
                <table class="payment-table">
                    <tr>
                        <td class="payment-label">Type:</td>
                        <td class="payment-value" style="font-weight: 700;">{{ ucfirst(str_replace('_', ' ', $order->order_type)) }}</td>
                    </tr>

                     <tr>
                        <td class="payment-label">Status:</td>
                        <td class="payment-value" style="font-weight: 700;">{{ $order->status }}</td>
                    </tr>

                </table>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <table class="totals-table">
                    <tr>
                        <td class="totals-label">Subtotal</td>
                        <td class="totals-val"><span class="rupee">&#8377;</span>{{ number_format($subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="totals-label">Tax (0%)</td>
                        <td class="totals-val"><span class="rupee">&#8377;</span>0.00</td>
                    </tr>
                    <tr class="grand-total-row">
                        <td class="totals-label grand-total-label">Grand Total</td>
                        <td class="totals-val grand-total-val"><span class="rupee">&#8377;</span>{{ number_format($total, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="footer-thanks">Thank you for your business!</div>

    <table class="footer-details">
        <tr>
            <td style="width: 55%; vertical-align: bottom; padding-right: 15px;">
                @if($base64Logo)
                    <div>
                        <img class="company-logo-img" src="{{ $base64Logo }}" alt="Logo">
                    </div>
                @endif
                
                @if($settings)
                    <div class="company-name">{{ $settings->company_name }}</div>
                    <div class="company-contact">
                        @if($settings->email_id) {{ $settings->email_id }} ,@if($settings->phone_no) +91-{{ ltrim(str_replace('+91', '', $settings->phone_no), '-') }}<br> @endif  @endif
                        
                        @if($settings->address) {{ $settings->address }} @endif
                    </div>
                @endif
            </td>
            <td style="width: 45%; vertical-align: bottom;">
                <div class="signature">
                    <span class="signature-line"></span><br>
                    <span class="signature-text">Authorized Signatory</span>
                </div>
            </td>
        </tr>
    </table>

</div>

<div class="footer-bg"></div>

</body>
</html>
