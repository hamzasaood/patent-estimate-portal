<div class="row g-3">

  {{-- Region --}}
  <div class="mb-3 col-md-4">
    <label class="form-label">Region</label>
    <select name="region" class="form-select" required>
      <option value="">Select...</option>
      <option value="US" {{ old('region',$pricing->region ?? '')=='US' ? 'selected' : '' }}>US</option>
      <option value="EU" {{ old('region',$pricing->region ?? '')=='EU' ? 'selected' : '' }}>EU</option>
      <option value="CN" {{ old('region',$pricing->region ?? '')=='CN' ? 'selected' : '' }}>China</option>
      <option value="JP" {{ old('region',$pricing->region ?? '')=='JP' ? 'selected' : '' }}>Japan</option>
      <option value="GB" {{ old('region',$pricing->region ?? '')=='GB' ? 'selected' : '' }}>UK</option>
    </select>
    @error('region') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Service --}}
  <div class="mb-3 col-md-4">
    <label class="form-label">Service</label>
    <select name="service" class="form-select" required>
      <option value="">Select...</option>
      <option value="pct_national_phase" {{ old('service',$pricing->service ?? '')=='pct_national_phase' ? 'selected' : '' }}>PCT National Phase Filing</option>
      <option value="direct_filing" {{ old('service',$pricing->service ?? '')=='direct_filing' ? 'selected' : '' }}>Direct Filing / Paris Convention</option>
      <option value="trademark" {{ old('service',$pricing->service ?? '')=='trademark' ? 'selected' : '' }}>Trademark</option>
      <option value="design" {{ old('service',$pricing->service ?? '')=='design' ? 'selected' : '' }}>Design</option>
      <option value="ep_validation" {{ old('service',$pricing->service ?? '')=='ep_validation' ? 'selected' : '' }}>EP Validation</option>
      <option value="recordal" {{ old('service',$pricing->service ?? '')=='recordal' ? 'selected' : '' }}>Recordal / Assignment</option>
      <option value="provisional_refusal" {{ old('service',$pricing->service ?? '')=='provisional_refusal' ? 'selected' : '' }}>Provisional Refusal</option>
    </select>
    @error('service') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Country --}}
  <div class="mb-3 col-md-4">
    <label class="form-label">Country</label>
    <input type="text" name="country" class="form-control" value="{{ old('country', $pricing->country ?? '') }}" placeholder="e.g. United States" required>
    @error('country') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Language --}}
  <div class="mb-3 col-md-4">
    <label class="form-label">Language</label>
    <input type="text" name="language" class="form-control" value="{{ old('language', $pricing->language ?? '') }}" placeholder="e.g. English" required>
    @error('language') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Filing Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Filing Fee</label>
    <input type="number" step="0.01" name="filing_fee" class="form-control" value="{{ old('filing_fee', $pricing->filing_fee ?? '') }}" required>
    @error('filing_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Translation Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Translation Fee</label>
    <input type="number" step="0.01" name="translation_fee" class="form-control" value="{{ old('translation_fee', $pricing->translation_fee ?? '') }}" required>
    @error('translation_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Official Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Official Fee</label>
    <input type="number" step="0.01" name="official_fee" class="form-control" value="{{ old('official_fee', $pricing->official_fee ?? '') }}" required>
    @error('official_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Excess Claims Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Excess Claims Fee (per claim)</label>
    <input type="number" step="0.01" name="excess_claim_fee" class="form-control" value="{{ old('excess_claim_fee', $pricing->excess_claim_fee ?? '') }}" required>
    @error('excess_claim_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Claims Threshold --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Claims Threshold</label>
    <input type="number" step="1" name="claims_threshold" class="form-control" value="{{ old('claims_threshold', $pricing->claims_threshold ?? 0) }}" required>
    @error('claims_threshold') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Excess Pages Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Excess Pages Fee (per page)</label>
    <input type="number" step="0.01" name="excess_page_fee" class="form-control" value="{{ old('excess_page_fee', $pricing->excess_page_fee ?? '') }}" required>
    @error('excess_page_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Pages Threshold --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Pages Threshold</label>
    <input type="number" step="1" name="pages_threshold" class="form-control" value="{{ old('pages_threshold', $pricing->pages_threshold ?? 0) }}" required>
    @error('pages_threshold') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Priority Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Priority Fee (per priority)</label>
    <input type="number" step="0.01" name="priority_fee" class="form-control" value="{{ old('priority_fee', $pricing->priority_fee ?? '') }}" required>
    @error('priority_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Priority Threshold --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Priority Threshold</label>
    <input type="number" step="1" name="priority_threshold" class="form-control" value="{{ old('priority_threshold', $pricing->priority_threshold ?? 0) }}" required>
    @error('priority_threshold') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Drawing Fee (small) --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Drawing Fee (small)</label>
    <input type="number" step="0.01" name="drawing_fee_small" class="form-control" value="{{ old('drawing_fee_small', $pricing->drawing_fee_small ?? '') }}" required>
    @error('drawing_fee_small') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Drawing Small Threshold --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Drawing Small Threshold</label>
    <input type="number" step="1" name="drawing_small_threshold" class="form-control" value="{{ old('drawing_small_threshold', $pricing->drawing_small_threshold ?? 0) }}" required>
    @error('drawing_small_threshold') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Drawing Fee (large) --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Drawing Fee (large)</label>
    <input type="number" step="0.01" name="drawing_fee_large" class="form-control" value="{{ old('drawing_fee_large', $pricing->drawing_fee_large ?? '') }}" required>
    @error('drawing_fee_large') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Drawing Large Threshold --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Drawing Large Threshold</label>
    <input type="number" step="1" name="drawing_large_threshold" class="form-control" value="{{ old('drawing_large_threshold', $pricing->drawing_large_threshold ?? 0) }}" required>
    @error('drawing_large_threshold') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Per Sequence Page Fee --}}
  <div class="col-md-4 mb-3">
    <label class="form-label">Per Sequence Page Fee</label>
    <input type="number" step="0.01" name="per_sequence_page_fee" class="form-control" value="{{ old('per_sequence_page_fee', $pricing->per_sequence_page_fee ?? 0) }}" required>
    @error('per_sequence_page_fee') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Special Rules --}}
  <div class="col-md-12 mb-3">
    <label class="form-label">Special Rules / Notes</label>
    <textarea name="special_rules" class="form-control" rows="3" required>{{ old('special_rules', $pricing->special_rules ?? '') }}</textarea>
    @error('special_rules') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Tax --}}
  <div class="col-md-3 mb-3">
    <label class="form-label">Tax %</label>
    <input type="number" step="0.01" name="tax_percentage" class="form-control" value="{{ old('tax_percentage', $pricing->tax_percentage ?? 0) }}" required>
    @error('tax_percentage') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

  {{-- Status --}}
  <div class="col-md-3 mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
      <option value="active" {{ (old('status', $pricing->status ?? '')=='active') ? 'selected' : '' }}>Active</option>
      <option value="inactive" {{ (old('status', $pricing->status ?? '')=='inactive') ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
  </div>

</div>
