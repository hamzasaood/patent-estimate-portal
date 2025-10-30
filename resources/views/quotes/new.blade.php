 summaryHtml += `


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
  border:1px solid #54748c;
  padding:10px 8px;
  vertical-align:middle;
}
.fees-table thead th {
  background:#54748c;
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
   <table class="w-100 mb-4" style="border-collapse: collapse; table-layout: fixed; width:100%;">
  <tr style="height:15px; width:100%; border:1px solid #54748c; background:#54748c; color:#fff;">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
  <tr style="height: 60px;">
    <!-- Logo -->
    <td style="width:100px; border:1px solid #3d6a86; text-align:center; background:#fff; vertical-align:middle;">
      
        <img src="{{ asset('/logo.png') }}" alt="Emuna IP Logo" style="max-height:60px; max-width:100px;">
      
    </td>

    <!-- Cost Estimate -->
    <td style="width:100px; border:1px solid #3d6a86; background:#72627a; color:#1f3b4a; font-weight:600; text-align:center; vertical-align:middle; font-size:12px;">
      COST ESTIMATE
    </td>

    <!-- Client Name -->
    <td style="width:100px; border:1px solid #3d6a86; background:#cfe6ee; color:#113842; text-align:center; vertical-align:middle;">
      <div style="font-weight:700; font-size:11px;">Client Name:</div>
      <div style="font-size:11px;">${applicant}</div>
    </td>

    <!-- Service -->
    <td style="width:100px; border:1px solid #3d6a86; background:#cfe6ee; color:#113842; text-align:center; vertical-align:middle;">
      <div style="font-weight:700; font-size:11px;">${service.replace(/_/g, " ").toUpperCase()}</div>
      <div style="font-size:11px;">Entry</div>
    </td>

    <!-- Emuna Ref -->
    <td style="width:100px; border:1px solid #3d6a86; background:#cfe6ee; color:#113842; text-align:center; vertical-align:middle;">
      <div style="font-weight:700; font-size:11px;">Emuna IP Ref:</div>
      <div style="font-size:11px;">${groupId}</div>
    </td>

    <!-- Client Ref -->
    <td style="width:100px; border:1px solid #3d6a86; background:#cfe6ee; color:#113842; text-align:center; vertical-align:middle;">
      <div style="font-weight:700; font-size:11px;">Client Ref:</div>
      <div style="font-size:11px;">${reference_number ?? 'P169375WO' }</div>
    </td>
  </tr>
  <tr style="height:15px; width:100%; border:1px solid #54748c; background:#54748c; color:#fff;">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
</table>
    <!-- Application Details -->
    <h5 style="color:#2d5568; font-weight:700; margin-bottom:12px;">Application Details</h5>
  <table class="app-details">
    <tbody>
      <tr>
        <td class="label">Estimate Date</td>
        <td>${ formattedDate }</td>
        <td class="label">Revised Date</td>
        <td>-</td>
      </tr>
      <tr>
        <td class="label">Application Number</td>
        <td>${ application_number }</td>
        <td class="label">Applicant</td>
        <td>${ applicant }</td>
      </tr>
      <tr>
        <td class="label">Title</td>
        <td colspan="3">${ title }</td>
      </tr>
      <tr>
        <td class="label">Language</td>
        <td>${ rule.language }</td>
        <td class="label">Pages</td>
        <td>${ pages }</td>
      </tr>
      <tr>
        <td class="label">Priority Date</td>
        <td>${ priority_date }</td>
        <td class="label">Claims</td>
        <td>${ claims }</td>
      </tr>
      <tr>
        <td class="label">International Filing Date</td>
        <td>${ filing_date }</td>
        <td class="label">Pages of Drawings</td>
        <td>${ drawings }</td>
      </tr>
      <tr>
        <td class="label">30-Month Deadline</td>
        <td>${ deadline_30 }</td>
        <td class="label">31-Month Deadline</td>
        <td>${ deadline_31 }</td>
      </tr>
    </tbody>
  </table>

    <!-- Filing and Translation Fees -->
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
      
      <tr>
        <td>${rule.region}</td>
        <td>${rule.language ?? (rule.translation ?? '-')}</td>
        <td>${ numFormat(filingFee) }</td>
        <td>
        ${ translationFee > 0 ? numFormat(translationFee) : '-' }
        </td>
        <td>${ numFormat(officialFee ?? 0) }</td>
        <td class="text-end">
          ${ numFormat(rowTotal) }
        </td>
      </tr>

      
      
    </tbody>


    <tfoot>
      if(firm_fee > 0)
      {
      <tr>
        <td colspan="5" class="text-end">Firm Fee:</td>
        <td class="text-end">${numFormat(firm_fee, 2)}</td>
      </tr>
    }
      
      <tr>
        <td colspan="5" class="text-end">Total Estimate:</td>
        <td class="text-end" id="finalGrandTotal"></td>
      </tr>
    </tfoot>
    
  </table>

`;