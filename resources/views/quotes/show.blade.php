@extends('layouts.app')
@section('title','Estimate #'.$groupId)

@section('content')
@php
  $q0 = $quotes->first();
  // safe fallbacks
  $applicant = $q0->applicant ?? 'SH GROUP A/S';
  $title = $q0->title ?? 'TWISTLOCK AND A METHOD FOR OPERATING A TWISTLOCK';
  $application_number = $q0->application_number ?? 'PCT/EP2024/056819';
  $language = $q0->language ?? ($q0->translation ?? 'English');
  $priority_date = optional($q0->priority_date)->format('d-M-Y') ?? '29-Mar-2023';
  $intl_filing = optional($q0->filing_date)->format('d-M-Y') ?? '14-Mar-2024';
  $deadline_30m = $q0->deadline_30m ?? '29-Sep-2025';
  $deadline_31m = $q0->deadline_31m ?? '29-Oct-2025';
  $pages = $q0->pages ?? 32;
  $claims = $q0->claims ?? 18;
  $drawings = $q0->drawings ?? 6;
@endphp

<style>
/* Page styling to mimic the PDF layout */
.estimate-header {
  display: grid;
  grid-template-columns: 220px 120px 1fr 220px 180px;
  gap: 0;
  align-items: stretch;
  border-collapse: collapse;
  margin-bottom: 18px;
}
.estimate-header > div {
  padding: 6px 10px;
  border: 1px solid #3d6a86;
  background: #3d6a86;
  color:#fff;
  font-weight:600;
  font-size:0.9rem;
  text-align:center;
}
.estimate-header .logo {
  background:#fff;
  border:1px solid #3d6a86;
  overflow:hidden;
  display:flex;
  align-items:center;
  justify-content:center;
}
.estimate-header .logo img { max-height:60px; }

.estimate-subheader {
  display:grid;
  grid-template-columns: repeat(5, 1fr);
  gap:0;
  margin-bottom:18px;
}
.estimate-subheader .cell {
  border:1px solid #3d6a86;
  padding:8px 10px;
  background:#c8dfea;
  color:#1f3b4a;
  font-weight:600;
  font-size:0.9rem;
  text-align:center;
}

.app-details {
  width:100%;
  border-collapse: collapse;
  margin-bottom:20px;
}
.app-details td { padding:8px 10px; border:1px solid #cfdfe7; vertical-align:top; }
.app-details .label { background:#e6f2f7; width:260px; font-weight:700; color:#1f4e63; }

.fees-table {
  width:100%;
  border-collapse: collapse;
  margin-bottom:14px;
}
.fees-table th, .fees-table td {
  border:1px solid #2d5568;
  padding:10px 8px;
  vertical-align:middle;
}
.fees-table thead th {
  background:#2d5568;
  color:#fff;
  font-weight:700;
}
.fees-table tfoot td { padding:10px; font-weight:700; background:#f1f6f8; border-top:2px solid #2d5568; }

.small-note { font-size:0.85rem; color:#556b74; line-height:1.4; }
.foot-legal { font-size:0.78rem; color:#616f74; margin-top:18px; line-height:1.35; }

#quotePdf {
  font-size: 13px;
  font-family: 'Arial', sans-serif;
  line-height: 1.4;
}

#quotePdf h5 {
  font-size: 15px;
  font-weight: 700;
  margin-bottom: 10px;
}

/* Tables smaller & consistent */
#quotePdf .fees-table th,
#quotePdf .fees-table td,
#quotePdf .app-details td {
  font-size: 13px;
  padding: 6px 5px;
}

/* Notes */
#quotePdf .small-note, 
#quotePdf .foot-legal {
  font-size: 11.5px;
}

/* Hide only in PDF export */
@media print {
  #downloadPdf { display: none !important; }
  #downloadExcel { display: none !important; }
}
@media print {
  #quotePdf {
    padding: 15% 15% 20% 20%; /* inner padding */
    font-size: 11px;
  }

  /* Ensure header table fits exactly in A4 width */
  #quotePdf table {
    table-layout: fixed;
    width: 100% !important;
    border-collapse: collapse;
  }

  #quotePdf td, 
  #quotePdf th {
    word-wrap: break-word;
    font-size: 11px !important;
  }

  /* Force header cells to not shrink */
  #quotePdf .header-cell {
    min-width: 100px;
  }
}


</style>


<div id="quotePdf">
<div class="container py-4">

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

  {{-- Fancy top header similar to PDF --}}
  {{-- Fancy top header similar to PDF --}}
<table class="w-100 mb-4" style="border-collapse: collapse; table-layout: fixed; width:100%;">
  <tr>
    <!-- Logo -->
    <td style="width:100px; border:1px solid #3d6a86; text-align:center; background:#fff; vertical-align:middle;">
      @if($q0->firm_logo)
        <img src="{{ asset($q0->firm_logo) }}" alt="logo" style="max-height:50px; max-width:90px;">
      @else
        <img src="{{ asset('/logo.png') }}" alt="Emuna IP Logo" style="max-height:50px; max-width:90px;">
      @endif
    </td>

    <!-- Cost Estimate -->
    <td style="width:100px; border:1px solid #3d6a86; background:#8ea9bb; color:#1f3b4a; font-weight:600; text-align:center; vertical-align:middle; font-size:12px;">
      COST ESTIMATE
    </td>

    <!-- Client Name -->
    <td style="width:100px; border:1px solid #3d6a86; background:#cfe6ee; color:#113842; text-align:center; vertical-align:middle;">
      <div style="font-weight:700; font-size:11px;">Client Name:</div>
      <div style="font-size:11px;">{{ $applicant }}</div>
    </td>

    <!-- Service -->
    <td style="width:100px; border:1px solid #3d6a86; background:#cfe6ee; color:#113842; text-align:center; vertical-align:middle;">
      <div style="font-weight:700; font-size:11px;">{{ ucfirst(str_replace('_',' ',$q0->service ?? 'PCT National Phase')) }}</div>
      <div style="font-size:11px;">Entry</div>
    </td>

    <!-- Emuna Ref -->
    <td style="width:100px; border:1px solid #3d6a86; background:#cfe6ee; color:#113842; text-align:center; vertical-align:middle;">
      <div style="font-weight:700; font-size:11px;">Emuna IP Ref:</div>
      <div style="font-size:11px;">{{ $groupId }}</div>
    </td>

    <!-- Client Ref -->
    <td style="width:100px; border:1px solid #3d6a86; background:#cfe6ee; color:#113842; text-align:center; vertical-align:middle;">
      <div style="font-weight:700; font-size:11px;">Client Ref:</div>
      <div style="font-size:11px;">{{ $q0->reference_number ?? 'P169375WO' }}</div>
    </td>
  </tr>
</table>


  {{-- Application Details table --}}
  <h5 style="color:#2d5568; font-weight:700; margin-bottom:12px;">Application Details</h5>
  <table class="app-details">
    <tbody>
      <tr>
        <td class="label">Estimate Date</td>
        <td>{{ $q0->created_at->format('d-M-Y') }}</td>
        <td class="label">Revised Date</td>
        <td>-</td>
      </tr>
      <tr>
        <td class="label">Application Number</td>
        <td>{{ $application_number }}</td>
        <td class="label">Applicant</td>
        <td>{{ $applicant }}</td>
      </tr>
      <tr>
        <td class="label">Title</td>
        <td colspan="3">{{ $title }}</td>
      </tr>
      <tr>
        <td class="label">Language</td>
        <td>{{ $language }}</td>
        <td class="label">Pages</td>
        <td>{{ $pages }}</td>
      </tr>
      <tr>
        <td class="label">Priority Date</td>
        <td>{{ $priority_date }}</td>
        <td class="label">Claims</td>
        <td>{{ $claims }}</td>
      </tr>
      <tr>
        <td class="label">International Filing Date</td>
        <td>{{ $intl_filing }}</td>
        <td class="label">Pages of Drawings</td>
        <td>{{ $drawings }}</td>
      </tr>
      <tr>
        <td class="label">30-Month Deadline</td>
        <td>{{ $deadline_30m }}</td>
        <td class="label">31-Month Deadline</td>
        <td>{{ $deadline_31m }}</td>
      </tr>
    </tbody>
  </table>

  {{-- Filing and Translation Fees table --}}
  <h5 style="color:#2d5568; font-weight:700; margin:18px 0 10px;">Filing and Translation Fees</h5>

  <table class="fees-table">
    <thead>
      <tr>
        <th style="width:22%;">Country</th>
        <th style="width:18%;">Language</th>
        <th style="width:18%;">Filing Fee</th>
        <th style="width:18%;">Translation Fees**</th>
        <th style="width:18%;">Official Fee*</th>
        <th style="width:16%;" class="text-end">Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($quotes as $q)
      <tr>
        <td>{{ $q->region }}</td>
        <td>{{ $q->language ?? ($q->translation ?? '-') }}</td>
        <td>${{ number_format($q->filing_fee ?? 0, 2) }}</td>
        <td>
          @if(isset($q->translation_fee) && $q->translation_fee > 0)
            ${{ number_format($q->translation_fee, 2) }}
          @else
            -
          @endif
        </td>
        <td>${{ number_format($q->official_fee ?? 0, 2) }}</td>
        <td class="text-end">
          @if($q->is_white_label && $q->total_with_firm)
            ${{ number_format($q->total,2) }}
          @else
            ${{ number_format($q->total ?? 0, 2) }}
          @endif
        </td>
      </tr>

      @php

      if($q->is_white_label && $q->total_with_firm)
        {
      $firm_fee = $q->firm_fees;
      }
      @endphp
      @endforeach
    </tbody>
    <tfoot>
      @if($q->is_white_label && $q->total_with_firm)
      <tr>
        <td colspan="5" class="text-end">Firm Fee:</td>
        <td class="text-end">${{ number_format($firm_fee, 2) }}</td>
      </tr>
      @endif
      <tr>
        <td colspan="5" class="text-end">Total Estimate:</td>
        <td class="text-end">${{ number_format($grandTotal, 2) }}</td>
      </tr>
    </tfoot>
  </table>

  {{-- Notes and small text like PDF --}}
  <p class="small-note mt-2">
    <strong>*Official fees</strong> are inclusive of all government fees, exchange rate fees and other miscellaneous processing fees and disbursements. Please note that official fees are subject to change at any time by the local patent offices.
  </p>

  <div class="foot-legal">
    Please note that the above costs have been calculated on the basis of currently available information and with the assumption that required documents will be submitted by the respective deadlines. This estimate is simply a projection of costs and makes no claim of patentability. All fees listed are USD. Please note, rush fees may apply based on when instructions are received.
  </div>

  <p class="small-note mt-3">
    <strong>Translation fees</strong> are an approximation, and accurate fees can only be determined based on a Microsoft Word version of the English specification. When the specification is not in English, the English translation is to be provided by the client.
    <br><small>**When filing in regions with the same language, a single translation may be used.</small>
  </p>

  <div class="text-end mt-4">
  <button id="downloadPdf" class="btn btn-danger px-4">
    <i class="bi bi-file-earmark-pdf"></i> Download PDF
  </button>
  <button id="downloadExcel" class="btn btn-success px-4">
    <i class="bi bi-file-earmark-excel"></i> Download Excel
  </button>

</div>

</div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>


<script>
document.getElementById('downloadPdf').addEventListener('click', function () {
    const element = document.getElementById('quotePdf');
    const btn = document.getElementById('downloadPdf'); 
    const btn1 = document.getElementById('downloadExcel');


    
    // Hide button before export
    btn.style.display = 'none';
    btn1.style.display = 'none';

    const opt = {
        margin:       [0.2, 0.2, 0.2, 0.2],
        filename:     'Estimate_{{ $groupId }}.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 3, useCORS: true, scrollY: 0 },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
    };

    html2pdf().set(opt).from(element).save().then(() => {
        // Show button again after download
        btn.style.display = 'inline-block';
        btn1.style.display = 'inline-block';
    });
});
document.getElementById('downloadExcel').addEventListener('click', function () {
   

    let wb = XLSX.utils.book_new();
    let ws = XLSX.utils.table_to_sheet(document.querySelector("#quotePdf"));
    XLSX.utils.book_append_sheet(wb, ws, "Invoice");
    XLSX.writeFile(wb, "Invoice_Group_{{ $groupId }}.xlsx");
});


</script>
@endsection
