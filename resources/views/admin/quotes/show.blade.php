@extends('admin.layout.app')

@section('content')
<style>
@media print {
  #downloadPdf { display: none !important; }
  #downloadExcel { display: none !important; }
}

</style>
<div class="container">
<div class="container-fluid py-4" id="invoicePdf">

  {{-- Header --}}
  <table class="w-100 mb-4" style="border-collapse: collapse; table-layout: fixed;">
    <tr>
      {{-- Logo --}}
      <td style="width:220px; border:1px solid #3d6a86; text-align:center; background:#fff;">
        @if($q0->firm_logo)
          <img src="{{ asset($q0->firm_logo) }}" alt="logo" style="max-height:60px;">
        @else
          <img src="{{ asset('/logo.png') }}" alt="Logo" style="max-height:60px;">
        @endif
      </td>

      {{-- Cost Estimate --}}
      <td style="width:120px; border:1px solid #3d6a86; background:#8ea9bb; color:#1f3b4a; font-weight:600; text-align:center;">
        COST ESTIMATE
      </td>

      {{-- Client Name --}}
      <td style="border:1px solid #3d6a86; background:#cfe6ee; color:#113842; text-align:center;">
        <div style="font-weight:700; font-size:11px;">Client Name:</div>
        <div style="font-size:11px;">{{ $q0->applicant ?? ($user->name ?? 'Client') }}</div>
      </td>

      {{-- Service --}}
      <td style="border:1px solid #3d6a86; background:#cfe6ee; color:#113842; text-align:center;">
        <div style="font-weight:700; font-size:11px;">{{ ucfirst(str_replace('_',' ',$q0->service)) }}</div>
        <div style="font-size:11px;">Entry</div>
      </td>

      {{-- Emuna Ref --}}
      <td style="width:220px; border:1px solid #3d6a86; background:#cfe6ee; color:#113842; text-align:center;">
        <div style="font-weight:700;">Emuna IP Ref:</div>
        <div style="font-size:11px;">{{ $groupId }}</div>
      </td>

      {{-- Client Ref --}}
      <td style="width:180px; border:1px solid #3d6a86; background:#cfe6ee; color:#113842; text-align:center;">
        <div style="margin-top:6px; font-weight:700;">Client Ref:</div>
        <div style="font-size:11px;">{{ $q0->reference_number ?? '-' }}</div>
      </td>
    </tr>
  </table>

  {{-- Application Details --}}
  <h5 style="color:#2d5568; font-weight:700; margin-bottom:12px;">Application Details</h5>
  <table class="table table-bordered" style="font-size:11px;">
    <tbody>
      <tr>
        <td class="fw-bold">Estimate Date</td>
        <td>{{ $q0->created_at->format('d M Y') }}</td>
        <td class="fw-bold">Revised Date</td>
        <td>-</td>
      </tr>
      <tr>
        <td class="fw-bold">Application Number</td>
        <td>{{ $q0->application_number ?? '-' }}</td>
        <td class="fw-bold">Applicant</td>
        <td>{{ $q0->applicant ?? '-' }}</td>
      </tr>
      <tr>
        <td class="fw-bold">Title</td>
        <td colspan="3">{{ $q0->title ?? '-' }}</td>
      </tr>
      <tr>
        <td class="fw-bold">Language</td>
        <td>{{ $q0->language ?? ($q0->translation ?? '-') }}</td>
        <td class="fw-bold">Pages</td>
        <td>{{ $q0->pages ?? '-' }}</td>
      </tr>
      <tr>
        <td class="fw-bold">Priority Date</td>
        <td>{{ optional($q0->priority_date)->format('d M Y') ?? '-' }}</td>
        <td class="fw-bold">Claims</td>
        <td>{{ $q0->claims ?? '-' }}</td>
      </tr>
      <tr>
        <td class="fw-bold">International Filing Date</td>
        <td>{{ optional($q0->filing_date)->format('d M Y') ?? '-' }}</td>
        <td class="fw-bold">Drawings</td>
        <td>{{ $q0->drawings ?? 0 }}</td>
      </tr>
      <tr>
        <td class="fw-bold">30-Month Deadline</td>
        <td>{{ $q0->deadline_30m ?? '-' }}</td>
        <td class="fw-bold">31-Month Deadline</td>
        <td>{{ $q0->deadline_31m ?? '-' }}</td>
      </tr>
      <tr>
        
        <td class="fw-bold">Pirority Claims</td>
        <td colspan="3">{{ $q0->priority ?? '-' }}</td>
      </tr>
    </tbody>
  </table>

  {{-- Fees Table --}}
  <h5 style="color:#2d5568; font-weight:700; margin:18px 0 10px;">Filing and Translation Fees</h5>
  <table class="table table-bordered" style="font-size:11px;">
    <thead class="table-dark">
      <tr>
        <th>Country</th>
        <th>Language</th>
        <th>Filing Fee</th>
        <th>Translation Fee</th>
        <th>Official Fee</th>
        <th class="text-end">Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($quotes as $q)
      <tr>
        <td>{{ $q->region }}</td>
        <td>{{ $q->language ?? ($q->translation ?? '-') }}</td>
        <td>${{ number_format($q->filing_fee ?? 0, 2) }}</td>
        <td>
          @if($q->translation_fee > 0)
            ${{ number_format($q->translation_fee,2) }}
          @else
            -
          @endif
        </td>
        <td>${{ number_format($q->official_fee ?? 0, 2) }}</td>
        <td class="text-end">
          ${{ number_format($q->is_white_label && $q->total_with_firm ? $q->total_with_firm : $q->total, 2) }}
        </td>
      </tr>
      @endforeach
    </tbody>
    <tfoot class="table-light">
      <tr>
        <td colspan="5" class="text-end">Total Estimate:</td>
        <td class="text-end">${{ number_format($grandTotal, 2) }}</td>
      </tr>
    </tfoot>
  </table>
   {{-- Notes --}}
  <p class="small text-muted mt-2">
    {!! $q0->notes ?? '* Official fees include government charges, exchange rate adjustments, and disbursements.' !!}
    Translation fees are estimates — final amounts may vary based on actual text length.  
    This estimate does not guarantee patentability. Rush fees may apply if deadlines are tight.';
    
    
  </p>
</div>
 

  {{-- Export Buttons --}}
  <div class="text-end mt-4 no-print">
    <button id="downloadPdf" class="btn btn-danger me-2">📄 Download PDF</button>
    <button id="downloadExcel" class="btn btn-success">📊 Download Excel</button>
  </div>
</div>

{{-- Scripts --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<script>
document.getElementById('downloadPdf').addEventListener('click', function () {
    const element = document.getElementById('invoicePdf');
    const opt = {
        margin: [0.2, 0.2, 0.2, 0.2],
        filename: 'Invoice_Group_{{ $groupId }}.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 3, useCORS: true, scrollY: 0 },
        jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' }
    };
    html2pdf().set(opt).from(element).save();
});

document.getElementById('downloadExcel').addEventListener('click', function () {
    let wb = XLSX.utils.book_new();
    let ws = XLSX.utils.table_to_sheet(document.querySelector("table.table-bordered"));
    XLSX.utils.book_append_sheet(wb, ws, "Invoice");
    XLSX.writeFile(wb, "Invoice_Group_{{ $groupId }}.xlsx");
});
</script>
@endsection
