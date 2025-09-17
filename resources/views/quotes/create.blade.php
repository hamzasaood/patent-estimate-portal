@extends('layouts.app')
@section('title','Get Patent Estimate')

@section('content')

@php
  $pricingRules = \App\Models\PricingLogic::where('status','active')->get();
  $pfLevel = auth()->user()->pfLevel->adjustment_percent ?? 0; // Patent Fee level %
  $tfLevel = auth()->user()->tfLevel->adjustment_percent ?? 0; // Translation Fee level %
@endphp

<script>
  let pricingRules = @json($pricingRules);
  let pfLevel = {{ $pfLevel }};
  let tfLevel = {{ $tfLevel }};
</script>

<style>
  body { background-color: #f5f8fa; }
  h1, h5 { color: #4f708e; font-weight: 700; letter-spacing: .5px; }
  .step-indicator span {
    width: 44px; border-radius: 40%; background: #dbe5ec;
    color: #4f708e ; font-weight: 600; font-size: 16px;
    display: inline-block; margin-bottom: 6px;
  }
  .step-indicator .bg-primary { background: #4f708e !important; color:#fff !important; }
  .step-indicator .bg-success { background: #198754 !important; color:#fff !important; }
  .card { border:none; border-radius:16px; box-shadow:0 4px 14px rgba(0,0,0,0.05);}
  .btn { border-radius: 10px; font-weight: 600; padding: .6rem 1.4rem; }
  .btn-primary { background:#4f708e; border-color:#4f708e; }
  .btn-primary:hover { background:#3a566c; border-color:#3a566c; }
  .btn-success { background:#198754; border-color:#198754; }
  .btn-success:hover { background:#146c43; border-color:#146c43; }
  #estimateTotal, #finalGrandTotal { color:#4f708e; font-weight:700; font-size:1.7rem; }
  .progress-wrapper { height:6px; background:#e1e8ef; border-radius:3px; overflow:hidden; }
  .progress-bar { height:100%; background:linear-gradient(90deg,#4f708e,#3a566c); width:0%; transition:width .4s; }
</style>

<div class="container">
  <h1 class="h3 fw-bold mb-4">Patent Estimate Form</h1>

  {{-- Stepper --}}
  <div class="d-flex justify-content-between mb-4">
    <div class="step-indicator"><span class="badge bg-primary">1</span><br><small>Application Details</small></div>
    <div class="step-indicator"><span class="badge bg-secondary">2</span><br><small>Fees & Options</small></div>
    <div class="step-indicator"><span class="badge bg-secondary">3</span><br><small>Summary</small></div>
    <div class="step-indicator"><span class="badge bg-secondary">4</span><br><small>White Label</small></div>
    <div class="step-indicator"><span class="badge bg-secondary">5</span><br><small>Payment</small></div>
  </div>

  {{-- Progress bar --}}
  <div class="progress-wrapper mb-4">
    <div class="progress-bar" id="stepProgress"></div>
  </div>

  <form id="quoteForm" method="POST" action="{{ route('quotes.store.quick') }}" enctype="multipart/form-data">
    @csrf

    {{-- STEP 1 --}}
    <div class="step step-1">
      <div class="card mb-4">
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Application Number</label>
              <input type="text" class="form-control" name="application_number" id="application_number">
              <small id="wipoStatus" class="text-muted"></small>
            </div>
            <div class="col-md-6">
              <label class="form-label">Application Title</label>
              <input type="text" class="form-control" name="title">
            </div>
            <div class="col-md-6">
              <label class="form-label">Reference Number</label>
              <input type="text" class="form-control" name="reference_number">
            </div>
            <div class="col-md-6">
              <label class="form-label">Applicant Name</label>
              <input type="text" class="form-control" name="applicant">
            </div>
            <div class="col-md-6">
              <label class="form-label">Region</label>
              <select class="form-select" name="region" required>
                <option value="">Select...</option>
                <option value="US">US</option>
                <option value="EU">EU</option>
                <option value="CN">CN</option>
                <option value="JP">JP</option>
                <option value="GB">UK</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Service</label>
              <select class="form-select" name="service" required>
                <option value="">Select Service...</option>
                <option value="pct_national_phase">PCT National Phase Filing</option>
                <option value="direct_filing">Direct Filing / Paris Convention</option>
                <option value="trademark">Trademark</option>
                <option value="design">Design</option>
                <option value="ep_validation">EP Validation</option>
                <option value="recordal">Recordal / Assignment</option>
                <option value="provisional_refusal">Provisional Refusal</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Number of Claims</label>
              <input type="number" class="form-control" name="claims" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Number of Pages</label>
              <input type="number" class="form-control" name="pages" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Number of Drawings</label>
              <input type="number" class="form-control" name="drawings">
            </div>
            <div class="col-md-12">
              <label class="form-label">Special Instructions</label>
              <textarea class="form-control" name="special_instructions" rows="3"></textarea>
            </div>
            <div class="col-md-12">
              <label class="form-label">Attachments</label>
              <input type="file" class="form-control" name="attachment">
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
      <div class="card mb-4">
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
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="fw-bold mb-3">Estimate Summary</h5>
          <div id="estimateSummary" class="mb-3"></div>
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
      <div class="card mb-4">
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
          <button type="button" class="btn btn-primary btn-next" data-next="5">Next</button>
        </div>
      </div>
    </div>

    {{-- STEP 5 --}}
    <div class="step step-5 d-none">
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="fw-bold mb-3">Finalize & Payment</h5>
          <div class="mb-3">
            <div class="alert alert-info d-flex justify-content-between align-items-center">
              <div>
                <strong>Grand Total (USD)</strong><br>
                <small class="text-muted">Includes filing, official, extras, tax, and firm fees if enabled</small>
              </div>
              <div class="fs-4 fw-bold" id="finalGrandTotal">$0.00</div>
            </div>
          </div>
          <ul class="small text-muted">
            <li><strong>Click to Instruct</strong> — submits without payment (status: quoted).</li>
            <li><strong>Click to Prepay</strong> — redirects to Stripe Checkout; after payment (status: paid).</li>
          </ul>
        </div>
        <div class="card-footer d-flex justify-content-between">
          <button type="button" class="btn btn-outline-secondary btn-prev" data-prev="4">Back</button>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success btn-lg" id="btnInstruct">Click to Instruct</button>
            <button type="button" class="btn btn-primary btn-lg" id="btnPrepay">Click to Prepay</button>
          </div>
        </div>
      </div>
    </div>

  </form>
</div>

{{-- JS --}}
<script>
$(document).ready(function(){

  function showStep(step){
    $(".step").addClass("d-none");
    $(".step-"+step).removeClass("d-none");
    updateStepper(step); updateProgress(step);
  }

  function updateStepper(step){
    $(".step-indicator span").removeClass("bg-primary").addClass("bg-secondary");
    $(".step-indicator").each(function(index){
      if(index+1 < step) $(this).find("span").removeClass("bg-secondary").addClass("bg-success");
      else if(index+1 === step) $(this).find("span").removeClass("bg-secondary").addClass("bg-primary");
    });
  }

  function updateProgress(step){
    const totalSteps = 5;
    const percentage = ((step - 1) / (totalSteps - 1)) * 100;
    $("#stepProgress").css("width", percentage + "%");
  }

  $(".btn-next").click(function(){ showStep($(this).data("next")); });
  $(".btn-prev").click(function(){ showStep($(this).data("prev")); });

  function getPricingRule(){
    let region = $("[name='region']").val();
    let service = $("[name='service']").val();
    return pricingRules.find(r => r.region === region && r.service === service) || null;
  }

  function calculateEstimate(){
  let claims = parseInt($("[name='claims']").val()||0);
  let pages  = parseInt($("[name='pages']").val()||0);
  let drawings = parseInt($("[name='drawings']").val()||0);
  let expedited = $("[name='expedited']").val();
  let translation = $("[name='translation']").val();
  let priority = $("[name='priority']").val();

  let rule = getPricingRule();
  if(!rule){
    $("#estimateSummary").html(`<p class="text-danger">⚠ No pricing rule found.</p>`);
    $("#estimateTotal").text(`$0.00`);
    $("#finalGrandTotal").text(`$0.00`);
    return;
  }

  // Apply PF/TF levels
  let filingFee = parseFloat(rule.filing_fee) + (parseFloat(rule.filing_fee) * (pfLevel/100));
  let officialFee = parseFloat(rule.official_fee);
  let translationFee = 0;

  if(translation !== 'none'){
    translationFee = pages * (
      parseFloat(rule.translation_fee) + (parseFloat(rule.translation_fee) * (tfLevel/100))
    );
  }

  // Extras (everything except translation)
  let extras = 0;
  if(claims > rule.claims_threshold) extras += (claims - rule.claims_threshold) * parseFloat(rule.excess_claim_fee);
  if(pages > rule.pages_threshold) extras += (pages - rule.pages_threshold) * parseFloat(rule.excess_page_fee);
  if(drawings > rule.drawing_small_threshold) extras += (drawings - rule.drawing_small_threshold) * parseFloat(rule.drawing_fee_small);
  if(drawings > rule.drawing_large_threshold) extras += (drawings - rule.drawing_large_threshold) * parseFloat(rule.drawing_fee_large);
  if(expedited==='yes') extras += parseFloat(rule.expedited_fee||0);
  if(priority==='yes') extras += parseFloat(rule.priority_fee||0);

  let subtotal = filingFee + officialFee + translationFee + extras;
  let tax = subtotal * (parseFloat(rule.tax_percentage||0)/100);
  let total = subtotal + tax;

  let firmFees = 0; 
  if($("#isWhiteLabel").is(":checked"))
  { 
    firmFees = parseFloat($("[name='firm_fees']").val() || 0); 

  } 
  let grandTotal = total + firmFees;

  $("#estimateSummary").html(`
    <p><strong>Filing Fee:</strong> $${filingFee.toFixed(2)}</p>
    <p><strong>Official Fee:</strong> $${officialFee.toFixed(2)}</p>
    <p><strong>Translation Fee:</strong> $${translationFee.toFixed(2)}</p>
    <p><strong>Extras:</strong> $${extras.toFixed(2)}</p>
    <p><strong>Tax (${tax}%):</strong> $${tax.toFixed(2)}</p>
    ${firmFees > 0 ? `<p><strong>Your Firm Fees:</strong> $${firmFees.toFixed(2)}</p>` : ''}
   
    
  `);

  $("#estimateTotal").text(`$${grandTotal.toFixed(2)}`);
  $("#finalGrandTotal").text(`$${grandTotal.toFixed(2)}`);
}


  $("input,select").on("input change", calculateEstimate);
  showStep(1); calculateEstimate();

  $("#isWhiteLabel").on("change", function(){
    $("#whiteLabelFields").toggle(this.checked);
  });

  const STORE_URL  = "{{ route('quotes.store.quick') }}";
  const PREPAY_URL = "{{ route('quotes.prepay') }}";

  $("#btnInstruct").on("click", function(){ $("#quoteForm").attr("action", STORE_URL); });
  $("#btnPrepay").on("click", function(){ $("#quoteForm").attr("action", PREPAY_URL).submit(); });


  function refreshFinalGrandTotal(){
     $("#finalGrandTotal").text($("#estimateTotal").text()); 
    }

  $(".btn-next").on("click", function(){
     const next = $(this).data("next"); if(next === 5) refreshFinalGrandTotal(); 
    });


});
</script>
@endsection
