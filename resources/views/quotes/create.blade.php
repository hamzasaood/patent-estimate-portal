@extends('layouts.app')
@section('title','Get Patent Estimate')

@section('content')
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
  </div>

  <form id="quoteForm" method="POST" action="{{ route('quotes.store') }}">
    @csrf

    {{-- STEP 1 --}}
    <div class="step step-1">
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <div class="row g-3">
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
            <div class="col-md-6">
              <label class="form-label">Application Number</label>
              <input type="text" class="form-control" name="application_number">
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
          <button type="submit" class="btn btn-success">Save & Generate PDF</button>
        </div>
      </div>
    </div>

  </form>
</div>
@endsection

@push('scripts')
<script>
$(function(){
  // Navigation
  $(".btn-next").click(function(){
    let next = $(this).data("next");
    $(".step").addClass("d-none");
    $(".step-"+next).removeClass("d-none");
  });
  $(".btn-prev").click(function(){
    let prev = $(this).data("prev");
    $(".step").addClass("d-none");
    $(".step-"+prev).removeClass("d-none");
  });

  // Instant Estimate
  $("input,select").on("change", function(){
    calculateEstimate();
  });

  function calculateEstimate(){
    let claims = parseInt($("[name='claims']").val()||0);
    let pages  = parseInt($("[name='pages']").val()||0);
    let drawings = parseInt($("[name='drawings']").val()||0);
    let expedited = $("[name='expedited']").val();
    let translation = $("[name='translation']").val();
    let priority = $("[name='priority']").val();

    let base = 1000; // demo base
    let extras = 0;

    if(claims>20) extras += (claims-20)*30;
    if(pages>25) extras += (pages-25)*5;
    if(drawings>0) extras += drawings*12;
    if(expedited==='yes') extras += 450;
    if(priority==='yes') extras += 120;
    if(translation!=='none') extras += pages*3;

    let tax = Math.round((base+extras)*0.05);
    let total = base+extras+tax;

    $("#estimateSummary").html(`
      <p><strong>Base Fee:</strong> $${base}</p>
      <p><strong>Extras:</strong> $${extras}</p>
      <p><strong>Tax (5%):</strong> $${tax}</p>
    `);
    $("#estimateTotal").text(`$${total}`);
  }

  // Trigger initial
  calculateEstimate();
});

$("#btnWipo").click(function(){
  let appNo = $("[name='application_number']").val();
  if(!appNo) return alert("Enter application number first");
  $.get(`/api/wipo/${appNo}`, function(data){
    alert("Autofilled from WIPO: "+data.title);
    // Fill fields:
    $("[name='title']").val(data.title);
    $("[name='applicant']").val(data.applicant);
  });
});

</script>
@endpush
