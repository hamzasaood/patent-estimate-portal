@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Title --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Quote #{{ $quote->id }} Details</h2>
        <a href="{{ route('quotes.index') }}" class="btn btn-outline-secondary">
            ← Back to Quotes
        </a>
    </div>

    {{-- Status & Totals --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h6 class="text-uppercase text-muted fw-semibold">Status</h6>
                    <span class="badge fs-6 px-4 py-2 mt-2
                        @if($quote->status=='paid') bg-success
                        @elseif($quote->status=='pending') bg-warning text-dark
                        @elseif($quote->status=='quoted') bg-info
                        @else bg-secondary @endif">
                        {{ ucfirst($quote->status) }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h6 class="text-uppercase text-muted fw-semibold">System Total</h6>
                    <h3 class="fw-bold text-primary mt-2">${{ number_format($quote->total,2) }}</h3>
                </div>
            </div>
        </div>
        @if($quote->is_white_label)
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h6 class="text-uppercase text-muted fw-semibold">With Firm Fees</h6>
                    <h3 class="fw-bold text-success mt-2">${{ number_format($quote->total_with_firm,2) }}</h3>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Application Details --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="fw-bold text-dark mb-0">📄 Application Details</h5>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-6"><span class="text-muted">Service:</span> <strong>{{ ucfirst(str_replace('_',' ',$quote->service)) }}</strong></div>
            <div class="col-md-6"><span class="text-muted">Region:</span> <strong>{{ strtoupper($quote->region) }}</strong></div>
            <div class="col-md-6"><span class="text-muted">Application #:</span> <strong>{{ $quote->application_number ?? '-' }}</strong></div>
            <div class="col-md-6"><span class="text-muted">Reference #:</span> <strong>{{ $quote->reference_number ?? '-' }}</strong></div>
            <div class="col-md-6"><span class="text-muted">Title:</span> <strong>{{ $quote->title ?? '-' }}</strong></div>
            <div class="col-md-6"><span class="text-muted">Applicant:</span> <strong>{{ $quote->applicant ?? '-' }}</strong></div>
            <div class="col-md-4"><span class="text-muted">Claims:</span> <strong>{{ $quote->claims }}</strong></div>
            <div class="col-md-4"><span class="text-muted">Pages:</span> <strong>{{ $quote->pages }}</strong></div>
            <div class="col-md-4"><span class="text-muted">Drawings:</span> <strong>{{ $quote->drawings ?? 0 }}</strong></div>
        </div>
    </div>

    {{-- Dates --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="fw-bold text-dark mb-0">📅 Key Dates</h5>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-3"><span class="text-muted">Priority Date:</span><br><strong>{{ optional($quote->priority_date)->format('d M Y') }}</strong></div>
            <div class="col-md-3"><span class="text-muted">Filing Date:</span><br><strong>{{ optional($quote->filing_date)->format('d M Y') }}</strong></div>
            <div class="col-md-3"><span class="text-muted">Deadline (30m):</span><br><strong>{{ optional($quote->deadline_30m)->format('d M Y') }}</strong></div>
            <div class="col-md-3"><span class="text-muted">Deadline (31m):</span><br><strong>{{ optional($quote->deadline_31m)->format('d M Y') }}</strong></div>
        </div>
    </div>

    {{-- Fees --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="fw-bold text-dark mb-0">💰 Fees Summary</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <tbody>
                    <tr><td>Filing Fee</td><td class="text-muted">${{ number_format($quote->filing_fee,2) }}</td></tr>
                    <tr><td>Translation Fee</td><td class="text-muted">${{ number_format($quote->translation_fee,2) }}</td></tr>
                    <tr><td>Official Fee</td><td class="text-muted">${{ number_format($quote->official_fee,2) }}</td></tr>
                    <tr><td class="text-muted">Extra Fee</td><td class="fw-bold">${{ number_format($quote->extra_fee,2) }}</td></tr>
                    <tr><td class="text-muted">Tax</td><td class="fw-bold">${{ number_format($quote->tax,2) }}</td></tr>
                    <tr class="table-light">
                        <td class="fw-bold">Total</td>
                        <td class="fw-bold text-primary">${{ number_format($quote->total,2) }}</td>
                    </tr>
                </tbody>
            </table>

            @if($quote->fees_breakdown)
            <h6 class="fw-bold mt-3">Detailed Breakdown</h6>
            <ul class="list-group">
                @foreach($quote->fees_breakdown as $key => $val)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ ucfirst(str_replace('_',' ',$key)) }}</span>
                        <strong>${{ number_format($val,2) }}</strong>
                    </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>

    {{-- Special Instructions --}}
    @if($quote->special_instructions)
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="fw-bold text-dark mb-0">📝 Special Instructions</h5>
        </div>
        <div class="card-body">
            <p class="mb-0">{{ $quote->special_instructions }}</p>
        </div>
    </div>
    @endif

    {{-- Attachment --}}
    @if($quote->attachment)
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="fw-bold text-dark mb-0">📎 Attachment</h5>
        </div>
        <div class="card-body">
            <a href="{{ asset($quote->attachment) }}" target="_blank" class="btn btn-outline-primary">
                View / Download Attachment
            </a>
        </div>
    </div>
    @endif

    {{-- White Label Info --}}
    @if($quote->is_white_label)
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="fw-bold text-dark mb-0">🏢 White Label Info</h5>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-4"><span class="text-muted">Firm Fees:</span><br><strong>${{ number_format($quote->firm_fees,2) }}</strong></div>
            <div class="col-md-4"><span class="text-muted">Firm ID:</span><br><strong>{{ $quote->firm_id }}</strong></div>
            <div class="col-md-4">
                <span class="text-muted">Firm Logo:</span><br>
                @if($quote->firm_logo)
                    <img src="{{ asset($quote->firm_logo) }}" alt="Firm Logo" class="img-thumbnail mt-2" style="max-height:90px;">
                @else
                    <span class="text-muted">No logo uploaded</span>
                @endif
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
