<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Quote #{{ $quote->id }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; line-height:1.5; }
    .header { text-align: center; margin-bottom: 25px; }
    .header img { max-height: 70px; margin-bottom:10px; }
    .header h2 { margin: 0; font-size: 20px; color:#2d3e50; }
    .sub { font-size: 12px; color:#555; }

    h3 { background:#4f708e; color:#fff; padding:6px 10px; font-size:14px; margin-top:25px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { border: 1px solid #ccc; padding: 6px 8px; font-size: 12px; }
    th { background:#f4f6f8; text-align:left; }

    .total-row th, .total-row td { font-weight:bold; background:#2d3e50; color:#fff; font-size:13px; }
    .footer { text-align: center; font-size: 11px; color:#555; margin-top: 30px; }
  </style>
</head>
<body>

  {{-- Header --}}
  <div class="header">
    @if($quote->firm_logo)
      <img src="{{ public_path($quote->firm_logo) }}" alt="Firm Logo">
    @else
      <img src="{{ public_path('images/emuna-logo.png') }}" alt="Emuna IP">
    @endif
    <h2>Patent Estimate</h2>
    <p class="sub">Quote #{{ $quote->id }} | Date: {{ $quote->created_at->format('d M Y') }}</p>
  </div>

  {{-- Application Details --}}
  <h3>Application Details</h3>
  <table>
    <tr><th>Service</th><td>{{ ucfirst(str_replace('_',' ',$quote->service)) }}</td></tr>
    <tr><th>Region</th><td>{{ strtoupper($quote->region) }}</td></tr>
    <tr><th>Application Number</th><td>{{ $quote->application_number ?? '-' }}</td></tr>
    <tr><th>Title</th><td>{{ $quote->title ?? '-' }}</td></tr>
    <tr><th>Applicant</th><td>{{ $quote->applicant ?? '-' }}</td></tr>
    <tr><th>Reference Number</th><td>{{ $quote->reference_number ?? '-' }}</td></tr>
    <tr><th>Priority Date</th><td>{{ optional($quote->priority_date)->format('Y-m-d') ?? '-' }}</td></tr>
    <tr><th>Filing Date</th><td>{{ optional($quote->filing_date)->format('Y-m-d') ?? '-' }}</td></tr>
    <tr><th>Claims</th><td>{{ $quote->claims }}</td></tr>
    <tr><th>Pages</th><td>{{ $quote->pages }}</td></tr>
    <tr><th>Drawings</th><td>{{ $quote->drawings }}</td></tr>
  </table>

  {{-- Cost Breakdown --}}
  <h3>Cost Breakdown</h3>
  <table>
    
    <tr>
      <th>Filing Fee</th>
      <td>${{ number_format($quote->filing_fee, 2) }}</td>
    </tr>
    <tr>
      <th>Translation Fee</th>
      <td>${{ number_format($quote->translation_fee, 2) }}</td>
    </tr>
    <tr>
      <th>Official Fee</th>
      <td>${{ number_format($quote->official_fee, 2) }}</td>
    </tr>
    <tr><th>Extras</th><td>${{ number_format($quote->extra_fee, 2) }}</td></tr>
    <tr><th>Tax</th><td>${{ number_format($quote->tax, 2) }}</td></tr>
    @if($quote->is_white_label && $quote->firm_fees)
      <tr><th>Firm Fee</th><td>${{ number_format($quote->firm_fees, 2) }}</td></tr>
      <tr class="total-row"><th>Total</th><td>${{ number_format($quote->total_with_firm, 2) }}</td></tr>
    @else
      <tr class="total-row"><th>Total</th><td>${{ number_format($quote->total, 2) }}</td></tr>
    @endif
  </table>

  {{-- Special Instructions --}}
  @if($quote->special_instructions)
    <h3>Special Instructions</h3>
    <p>{{ $quote->special_instructions }}</p>
  @endif

  {{-- Footer --}}
  <div class="footer">
    Thank you for working with <span style="color:#4f708e;">Emuna IP</span>.<br>
    This is a system-generated estimate and may be subject to adjustments.
  </div>

</body>
</html>
