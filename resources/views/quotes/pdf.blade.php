<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Quote #{{ $quote->id }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
    .header { text-align: center; margin-bottom: 20px; }
    .header img { max-height: 80px; }
    h2 { margin: 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    table, th, td { border: 1px solid #ccc; }
    th, td { padding: 8px; text-align: left; }
    .total { font-weight: bold; font-size: 14px; }
  </style>
</head>
<body>
  <div class="header">
    @if($quote->firm_logo)
      <img src="{{ public_path($quote->firm_logo) }}" alt="Firm Logo">
    @else
      <h2>Patent Estimate</h2>
    @endif
    <p>Quote #{{ $quote->id }}</p>
  </div>

  <h3>Application Details</h3>
  <table>
    <tr><th>Application Type</th><td>{{ ucfirst($quote->application_type) }}</td></tr>
    <tr><th>Jurisdiction</th><td>{{ strtoupper($quote->jurisdiction) }}</td></tr>
    <tr><th>Application Number</th><td>{{ $quote->application_number ?? '-' }}</td></tr>
    <tr><th>Title</th><td>{{ $quote->title ?? '-' }}</td></tr>
    <tr><th>Applicant</th><td>{{ $quote->applicant ?? '-' }}</td></tr>
    <tr><th>Priority Date</th><td>{{ optional($quote->priority_date)->format('Y-m-d') ?? '-' }}</td></tr>
    <tr><th>Filing Date</th><td>{{ optional($quote->filing_date)->format('Y-m-d') ?? '-' }}</td></tr>
    <tr><th>Claims</th><td>{{ $quote->claims }}</td></tr>
    <tr><th>Pages</th><td>{{ $quote->pages }}</td></tr>
    <tr><th>Drawings</th><td>{{ $quote->drawings }}</td></tr>
  </table>

  <h3>Cost Breakdown</h3>
  <table>
    <tr><th>Base Fee</th><td>${{ number_format($quote->base_fee, 2) }}</td></tr>
    <tr><th>Extras</th><td>${{ number_format($quote->extra_fee, 2) }}</td></tr>
    <tr><th>Tax</th><td>${{ number_format($quote->tax, 2) }}</td></tr>
    <tr class="total"><th>Total</th><td>${{ number_format($quote->total, 2) }}</td></tr>
  </table>
</body>
</html>
