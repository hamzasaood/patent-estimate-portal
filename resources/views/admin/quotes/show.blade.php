@extends('admin.layout.app')

@section('content')
<div class="container-fluid p-4">
    <h3 class="mb-4">Quote Details</h3>

    <div class="card shadow-sm p-4">
        <h5>General Info</h5>
        <p><strong>User:</strong> {{ $quote->user->name ?? 'Guest' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($quote->status) }}</p>
        <p><strong>Total:</strong> {{ number_format($quote->total,2) }}</p>

        <h5>Application Details</h5>
        <ul>
            <li>Type: {{ $quote->application_type }}</li>
            <li>Jurisdiction: {{ $quote->jurisdiction }}</li>
            <li>Application #: {{ $quote->application_number }}</li>
            <li>Title: {{ $quote->title }}</li>
            <li>Applicant: {{ $quote->applicant }}</li>
            <li>Claims: {{ $quote->claims }}</li>
            <li>Pages: {{ $quote->pages }}</li>
            <li>Drawings: {{ $quote->drawings }}</li>
            <li>Sequence Pages: {{ $quote->sequence_pages }}</li>
        </ul>

        <h5>Dates</h5>
        <ul>
            <li>Priority Date: {{ optional($quote->priority_date)->format('d M Y') }}</li>
<li>Filing Date: {{ optional($quote->filing_date)->format('d M Y') }}</li>
<li>Deadline (30m): {{ optional($quote->deadline_30m)->format('d M Y') }}</li>
<li>Deadline (31m): {{ optional($quote->deadline_31m)->format('d M Y') }}</li>

        </ul>

        <h5>Fees</h5>
        <ul>
            <li>Base Fee: {{ $quote->base_fee }}</li>
            <li>Extra Fee: {{ $quote->extra_fee }}</li>
            <li>Tax: {{ $quote->tax }}</li>
            <li>Total: {{ $quote->total }}</li>
        </ul>

        @if($quote->fees_breakdown)
        <h5>Fee Breakdown</h5>
        <ul>
            @foreach($quote->fees_breakdown as $key => $val)
                <li>{{ ucfirst($key) }}: {{ $val }}</li>
            @endforeach
        </ul>
        @endif
    </div>

    <a href="{{ route('quotes.index') }}" class="btn btn-secondary mt-3">Back to list</a>
</div>
@endsection
