@extends('layouts.app')
@section('title','Get Patent Estimate')

@section('content')

@php
  $pricingRules = \App\Models\PricingLogic::where('status','active')->get();
@endphp

<script>
  let pricingRules = @json($pricingRules);
</script>


<div class="container">

  <h1 class="h3 fw-bold mb-4">Patent Estimate Form</h1>

  {{-- Stepper --}}
<div class="d-flex justify-content-between mb-4">
  <div class="step-indicator text-center flex-fill">
    <span class="badge bg-primary">1</span><br>
    <small>Application Details</small>
  </div>
  <div class="step-indicator text-center flex-fill">
    <span class="badge bg-secondary">2</span><br>
    <small>Fees & Options</small>
  </div>
  <div class="step-indicator text-center flex-fill">
    <span class="badge bg-secondary">3</span><br>
    <small>Summary & Estimate</small>
  </div>
  <div class="step-indicator text-center flex-fill">
    <span class="badge bg-secondary">4</span><br>
    <small>White Label</small>
  </div>
</div>


  <form id="quoteForm" method="POST" action="{{ route('quotes.store.quick') }}" enctype="multipart/form-data">
    @csrf

    {{-- STEP 1 --}}
    <div class="step step-1">
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <div class="row g-3">
             <div class="col-md-6">
              <label class="form-label">Application Number</label>
              <input type="text" class="form-control" name="application_number" id="application_number">
              <small id="wipoStatus" class="text-muted"></small>
            </div>

            

            <div class="col-md-6">
              <label class="form-label">Application Type</label>
              <select class="form-select" name="application_type" required>
                <option value="">Select...</option>
                <option value="provisional">Provisional</option>
                <option value="non_provisional">Non-Provisional</option>
                <option value="pct">PCT</option>
                <option value="national_phase">National Phase</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Jurisdiction</label>
              <select class="form-select" name="jurisdiction" required>
                <option value="">Select...</option>
                <option value="us">US</option>
                <option value="eu">EU</option>
                <option value="cn">CN</option>
                <option value="jp">JP</option>
                <option value="gb">UK</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Claims</label>
              <input type="number" class="form-control" name="claims" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Pages</label>
              <input type="number" class="form-control" name="pages" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Drawings</label>
              <input type="number" class="form-control" name="drawings">
            </div>
           

          </div>
        </div>
        <div class="card-footer text-end">
          <button type="button" class="btn btn-primary btn-next" data-next="2">Next</button>
        </div>
      </div>
    </div>

    {{-- STEP 2 --}}
    <div class="step step-2 d-none">
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Expedited?</label>
              <select class="form-select" name="expedited">
                <option value="no">No</option>
                <option value="yes">Yes</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Translation Needed?</label>
              <select class="form-select" name="translation">
                <option value="none">None</option>
                <option value="en">To English</option>
                <option value="from_en">From English</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Priority Claim?</label>
              <select class="form-select" name="priority">
                <option value="no">No</option>
                <option value="yes">Yes</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
          <button type="button" class="btn btn-outline-secondary btn-prev" data-prev="1">Back</button>
          <button type="button" class="btn btn-primary btn-next" data-next="3">Next</button>
        </div>
      </div>
    </div>

    {{-- STEP 3 --}}
    <div class="step step-3 d-none">
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <h5 class="fw-bold mb-3">Estimate Summary</h5>
          <div id="estimateSummary" class="mb-3">
            <!-- JS will fill -->
          </div>
          <div class="d-flex justify-content-between fs-5 fw-bold">
            <span>Total Estimate (USD):</span>
            <span id="estimateTotal">$0</span>
          </div>
        </div>
        <div class="card-footer d-flex justify-content-between">
          <button type="button" class="btn btn-outline-secondary btn-prev" data-prev="2">Back</button>
          <button type="button" class="btn btn-primary btn-next" data-next="4">Next</button>
        </div>

      </div>
    </div>


    {{-- STEP 4 --}} 
<div class="step step-4 d-none">
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h5 class="fw-bold mb-3">White Label Options (Optional)</h5>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="is_white_label" id="isWhiteLabel" value="1">
        <label class="form-check-label" for="isWhiteLabel">Enable White Label Quote</label>
      </div>

      <div id="whiteLabelFields" style="display:none;">
        <div class="mb-3">
          <label class="form-label">Your Firm’s Additional Fees (USD)</label>
          <input type="number" step="0.01" class="form-control" name="firm_fees">
        </div>
        <div class="mb-3">
          <label class="form-label">Upload Your Firm Logo</label>
          <input type="file" class="form-control" name="firm_logo" accept="image/*">
        </div>
      </div>
    </div>

    <div class="card-footer d-flex justify-content-between">
      <button type="button" class="btn btn-outline-secondary btn-prev" data-prev="3">Back</button>
      <button type="submit" class="btn btn-success">Save & Generate PDF</button>
    </div>
  </div>
</div>


  </form>
</div>


<script>
  
$(document).ready(function(){
  function showStep(step){
    $(".step").addClass("d-none");             // hide all
    $(".step-" + step).removeClass("d-none");  // show current
    updateStepper(step);
  }

  function updateStepper(step){
    $(".step-indicator span").removeClass("bg-primary").addClass("bg-secondary");
    $(".step-indicator small").removeClass("fw-bold text-primary");
    
    $(".step-indicator").each(function(index){
      if(index+1 < step){
        $(this).find("span").removeClass("bg-secondary").addClass("bg-success");
      } else if(index+1 === step){
        $(this).find("span").removeClass("bg-secondary").addClass("bg-primary");
        $(this).find("small").addClass("fw-bold text-primary");
      }
    });
  }

  // Navigation
  $(".btn-next").click(function(){
    let next = $(this).data("next");
    showStep(next);
  });
  $(".btn-prev").click(function(){
    let prev = $(this).data("prev");
    showStep(prev);
  });

  // Instant Estimate
  $("input,select").on("input change", function(){
    calculateEstimate();
  });

  function getPricingRule(){
  let jurisdiction = $("[name='jurisdiction']").val();
  let appType = $("[name='application_type']").val();

  return pricingRules.find(r => 
    r.jurisdiction === jurisdiction && r.application_type === appType
  ) || null;
}

// Navigation is already set up with data-next / data-prev

// Toggle white label fields
$("#isWhiteLabel").on("change", function(){
  $("#whiteLabelFields").toggle(this.checked);
});

// Update estimate to also preview firm fees if enabled
function calculateEstimate(){
  let claims = parseInt($("[name='claims']").val()||0);
  let pages  = parseInt($("[name='pages']").val()||0);
  let drawings = parseInt($("[name='drawings']").val()||0);
  let expedited = $("[name='expedited']").val();
  let translation = $("[name='translation']").val();
  let priority = $("[name='priority']").val();

  let rule = getPricingRule();

  if(!rule){
    $("#estimateSummary").html(`<p class="text-danger">⚠ No pricing rule found for this combination.</p>`);
    $("#estimateTotal").text(`$0.00`);
    return;
  }

  let base = parseFloat(rule.base_fee);
  let extras = 0.0;

  if(claims > rule.claims_threshold) extras += (claims - rule.claims_threshold) * parseFloat(rule.per_claim_fee);
  if(pages > rule.pages_threshold) extras += (pages - rule.pages_threshold) * parseFloat(rule.per_page_fee);
  if(drawings > 0) extras += drawings * parseFloat(rule.per_drawing_fee);
  if(expedited==='yes') extras += parseFloat(rule.expedited_fee);
  if(priority==='yes') extras += parseFloat(rule.priority_fee);
  if(translation!=='none') extras += pages * parseFloat(rule.translation_fee);

  let tax = ((base+extras) * (rule.tax_percentage/100));
  let total = base+extras+tax;

  // If white-label preview is active
  let firmFees = 0;
  if($("#isWhiteLabel").is(":checked")){
    firmFees = parseFloat($("[name='firm_fees']").val() || 0);
  }

  let grandTotal = total + firmFees;

  $("#estimateSummary").html(`
    <p><strong>Base Fee:</strong> $${base.toFixed(2)}</p>
    <p><strong>Extras:</strong> $${extras.toFixed(2)}</p>
    <p><strong>Tax (${rule.tax_percentage}%):</strong> $${tax.toFixed(2)}</p>
    ${firmFees>0 ? `<p><strong>Your Firm Fees:</strong> $${firmFees.toFixed(2)}</p>` : ""}
  `);

  $("#estimateTotal").text(`$${grandTotal.toFixed(2)}`);
}




  // Initial load
  showStep(1);
  calculateEstimate();





  // WIPO Fetch

  $("#application_number").on("blur", function(){
  let appNo = $(this).val();
  if(!appNo) return;

  $("#wipoStatus").text("🔎 Fetching from WIPO...");
  $.get(`/wipo/fetch/${appNo}`, function(res){
      if(res.error){
          $("#wipoStatus").text("❌ Could not fetch data.");
          return;
      }

      $("#wipoStatus").text("✅ Data fetched successfully!");

      // Autofill form
      if(res.jurisdiction) $("[name='jurisdiction']").val(res.jurisdiction.toLowerCase());
      if(res.title) $("#estimateSummary").prepend(`<p><strong>Title:</strong> ${res.title}</p>`);
      if(res.applicant) $("#estimateSummary").prepend(`<p><strong>Applicant:</strong> ${res.applicant}</p>`);
      if(res.filing_date) $("#estimateSummary").prepend(`<p><strong>Filing Date:</strong> ${res.filing_date}</p>`);
  }).fail(function(){
      $("#wipoStatus").text("❌ API request failed.");
  });
});

});



</script>

@endsection



