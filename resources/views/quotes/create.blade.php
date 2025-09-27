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
                    <!-- Added countries / regions -->
    <option value="Albania">Albania</option>
    <option value="Algeria">Algeria</option>
    <option value="Angola">Angola</option>
    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
    <option value="Argentina">Argentina</option>
    <option value="ARIPO">ARIPO</option>
    <option value="Armenia">Armenia</option>
    <option value="Australia">Australia</option>
    <option value="Austria">Austria</option>
    <option value="Azerbaijan">Azerbaijan</option>
    <option value="Bahrain">Bahrain</option>
    <option value="Barbados">Barbados</option>
    <option value="Belarus">Belarus</option>
    <option value="Belgium">Belgium</option>
    <option value="Belize">Belize</option>
    <option value="Benin">Benin</option>
    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
    <option value="Botswana">Botswana</option>
    <option value="Brazil">Brazil</option>
    <option value="Brunei Darussalam">Brunei Darussalam</option>
    <option value="Bulgaria">Bulgaria</option>
    <option value="Burkina Faso">Burkina Faso</option>
    <option value="Cabo Verde">Cabo Verde</option>
    <option value="Cambodia">Cambodia</option>
    <option value="Cameroon">Cameroon</option>
    <option value="Canada">Canada</option>
    <option value="Central African Republic">Central African Republic</option>
    <option value="Chad">Chad</option>
    <option value="Chile">Chile</option>
    <option value="China">China</option>
    <option value="Colombia">Colombia</option>
    <option value="Comoros">Comoros</option>
    <option value="Congo">Congo</option>
    <option value="Costa Rica">Costa Rica</option>
    <option value="Côte d’Ivoire">Côte d’Ivoire</option>
    <option value="Croatia">Croatia</option>
    <option value="Cyprus">Cyprus</option>
    <option value="Czechia">Czechia</option>
    <option value="Denmark">Denmark</option>
    <option value="Djibouti">Djibouti</option>
    <option value="Dominica">Dominica</option>
    <option value="Dominican Republic">Dominican Republic</option>
    <option value="Ecuador">Ecuador</option>
    <option value="Egypt">Egypt</option>
    <option value="El Salvador">El Salvador</option>
    <option value="Equatorial Guinea">Equatorial Guinea</option>
    <option value="Estonia">Estonia</option>
    <option value="Eswatini">Eswatini</option>
    <option value="Eurasia">Eurasia</option>
    <option value="Europe">Europe</option>
    <option value="Finland">Finland</option>
    <option value="France">France</option>
    <option value="Gabon">Gabon</option>
    <option value="Gambia">Gambia</option>
    <option value="Georgia">Georgia</option>
    <option value="Germany">Germany</option>
    <option value="Ghana">Ghana</option>
    <option value="Greece">Greece</option>
    <option value="Grenada">Grenada</option>
    <option value="Guatemala">Guatemala</option>
    <option value="Guinea">Guinea</option>
    <option value="Guinea-Bissau">Guinea-Bissau</option>
    <option value="Honduras">Honduras</option>
    <option value="Hungary">Hungary</option>
    <option value="Iceland">Iceland</option>
    <option value="India">India</option>
    <option value="Indonesia">Indonesia</option>
    <option value="Ireland">Ireland</option>
    <option value="Israel">Israel</option>
    <option value="Italy">Italy</option>
    <option value="Jamaica">Jamaica</option>
    <option value="Japan">Japan</option>
    <option value="Jordan">Jordan</option>
    <option value="Kazakhstan">Kazakhstan</option>
    <option value="Kenya">Kenya</option>
    <option value="Kuwait">Kuwait</option>
    <option value="Kyrgyzstan">Kyrgyzstan</option>
    <option value="Lao PDR">Lao People’s Democratic Republic</option>
    <option value="Latvia">Latvia</option>
    <option value="Lesotho">Lesotho</option>
    <option value="Liberia">Liberia</option>
    <option value="Liechtenstein">Liechtenstein</option>
    <option value="Lithuania">Lithuania</option>
    <option value="Luxembourg">Luxembourg</option>
    <option value="Madagascar">Madagascar</option>
    <option value="Malawi">Malawi</option>
    <option value="Malaysia">Malaysia</option>
    <option value="Mali">Mali</option>
    <option value="Malta">Malta</option>
    <option value="Mauritania">Mauritania</option>
    <option value="Mauritius">Mauritius</option>
    <option value="Mexico">Mexico</option>
    <option value="Monaco">Monaco</option>
    <option value="Mongolia">Mongolia</option>
    <option value="Montenegro">Montenegro</option>
    <option value="Morocco">Morocco</option>
    <option value="Mozambique">Mozambique</option>
    <option value="Namibia">Namibia</option>
    <option value="Netherlands">Netherlands</option>
    <option value="New Zealand">New Zealand</option>
    <option value="Nicaragua">Nicaragua</option>
    <option value="Niger">Niger</option>
    <option value="Nigeria">Nigeria</option>
    <option value="North Macedonia">North Macedonia</option>
    <option value="Norway">Norway</option>
    <option value="OAPI">OAPI</option>
    <option value="Oman">Oman</option>
    <option value="Panama">Panama</option>
    <option value="Papua New Guinea">Papua New Guinea</option>
    <option value="Peru">Peru</option>
    <option value="Philippines">Philippines</option>
    <option value="Poland">Poland</option>
    <option value="Portugal">Portugal</option>
    <option value="Qatar">Qatar</option>
    <option value="Republic of Korea">Republic of Korea</option>
    <option value="Republic of Moldova">Republic of Moldova</option>
    <option value="Romania">Romania</option>
    <option value="Russia">Russian Federation</option>
    <option value="Rwanda">Rwanda</option>
    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
    <option value="Saint Lucia">Saint Lucia</option>
    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
    <option value="Samoa">Samoa</option>
    <option value="San Marino">San Marino</option>
    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
    <option value="Saudi Arabia">Saudi Arabia</option>
    <option value="Senegal">Senegal</option>
    <option value="Serbia">Serbia</option>
    <option value="Seychelles">Seychelles</option>
    <option value="Sierra Leone">Sierra Leone</option>
    <option value="Singapore">Singapore</option>
    <option value="Slovakia">Slovakia</option>
    <option value="Slovenia">Slovenia</option>
    <option value="South Africa">South Africa</option>
    <option value="Spain">Spain</option>
    <option value="Sri Lanka">Sri Lanka</option>
    <option value="Sudan">Sudan</option>
    <option value="Sweden">Sweden</option>
    <option value="Switzerland">Switzerland</option>
    <option value="Tajikistan">Tajikistan</option>
    <option value="Thailand">Thailand</option>
    <option value="Togo">Togo</option>
    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
    <option value="Tunisia">Tunisia</option>
    <option value="Turkey">Turkey</option>
    <option value="Turkmenistan">Turkmenistan</option>
    <option value="Uganda">Uganda</option>
    <option value="Ukraine">Ukraine</option>
    <option value="United Arab Emirates">United Arab Emirates</option>
    <option value="United Kingdom">United Kingdom</option>
    <option value="Tanzania">United Republic of Tanzania</option>
    <option value="United States of America">USA</option>
    <option value="Uruguay">Uruguay</option>
    <option value="Uzbekistan">Uzbekistan</option>
    <option value="Vietnam">Vietnam</option>
    <option value="Zambia">Zambia</option>
    <option value="Zimbabwe">Zimbabwe</option>

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
              <label class="form-label">number of priority claims</label>
              <select class="form-select" name="priority">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                
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




<script>
$(document).ready(function(){

  // Autofill from WIPO samples
  $("#application_number").on("blur", function(){
    let appNo = $(this).val();
    if(!appNo) return;

    $("#wipoStatus").text("🔎 Fetching from WIPO samples...");
    $.get(`/wipo/fetch?appNo=${encodeURIComponent(appNo)}`, function(res) {
        if(res.error){
            $("#wipoStatus").text("❌ No record found.");
            return;
        }

        $("#wipoStatus").text("✅ Data fetched!");

        if(res.title) $("[name='title']").val(res.title);
        if(res.applicant) $("[name='applicant']").val(res.applicant);
        if(res.claims) $("[name='claims']").val(res.claims).trigger("input");
        if(res.pages) $("[name='pages']").val(res.pages).trigger("input");
        if(res.drawings) $("[name='drawings']").val(res.drawings).trigger("input");
        if(res.region) $("[name='region']").val(res.region.toUpperCase());
        if(res.filing_date) $("#estimateSummary").prepend(`<p><strong>Filing Date:</strong> ${res.filing_date}</p>`);
        if(res.priority_date) $("#estimateSummary").prepend(`<p><strong>Priority Date:</strong> ${res.priority_date}</p>`);
    }).fail(function(){
        $("#wipoStatus").text("❌ Request failed.");
    });
  });

});
</script>

@endsection
