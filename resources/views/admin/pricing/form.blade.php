 <div class="row">
            <div class="mb-3">
        <label class="form-label">Jurisdiction</label>
        <select name="jurisdiction" class="form-select" required>
            <option value="">Select...</option>
            <option value="US" {{ old('jurisdiction',$pricing->jurisdiction??'')=='US'?'selected':'' }}>US</option>
            <option value="EU" {{ old('jurisdiction',$pricing->jurisdiction??'')=='EU'?'selected':'' }}>EU</option>
            <option value="CN" {{ old('jurisdiction',$pricing->jurisdiction??'')=='CN'?'selected':'' }}>China</option>
            <option value="JP" {{ old('jurisdiction',$pricing->jurisdiction??'')=='JP'?'selected':'' }}>Japan</option>
            <option value="GB" {{ old('jurisdiction',$pricing->jurisdiction??'')=='GB'?'selected':'' }}>UK</option>
        </select>
        </div>

        <div class="mb-3">
        <label class="form-label">Application Type</label>
        <select name="application_type" class="form-select" required>
            <option value="">Select...</option>
            <option value="provisional" {{ old('application_type',$pricing->application_type??'')=='provisional'?'selected':'' }}>Provisional</option>
            <option value="non_provisional" {{ old('application_type',$pricing->application_type??'')=='non_provisional'?'selected':'' }}>Non-Provisional</option>
            <option value="pct" {{ old('application_type',$pricing->application_type??'')=='pct'?'selected':'' }}>PCT</option>
            <option value="national_phase" {{ old('application_type',$pricing->application_type??'')=='national_phase'?'selected':'' }}>National Phase</option>
        </select>
        </div>

    <div class="col-md-4">
        <label>Base Fee</label>
        <input type="number" step="0.01" name="base_fee" class="form-control" value="{{ old('base_fee',$pricing->base_fee ?? '') }}">
    </div>
    <div class="col-md-4">
        <label>Priority Fee</label>
        <input type="number" step="0.01" name="priority_fee" class="form-control" value="{{ old('priority_fee',$pricing->priority_fee ?? '') }}">
    </div>
    <div class="col-md-4">
        <label>Claim Threshold</label>
        <input type="number" step="0.01" name="claims_threshold" class="form-control" value="{{ old('claims_threshold',$pricing->claims_threshold ?? '') }}">
    </div>
    <div class="col-md-4">
        <label>Per Claim Fee</label>
        <input type="number" step="0.01" name="per_claim_fee" class="form-control" value="{{ old('per_claim_fee',$pricing->per_claim_fee ?? '') }}">
    </div>
    <div class="col-md-4">
        <label>Pages Threshold</label>
        <input type="number" step="0.01" name="pages_threshold" class="form-control" value="{{ old('pages_threshold',$pricing->pages_threshold ?? '') }}">
    </div>
    <div class="col-md-4">
        <label>Per Page Fee</label>
        <input type="number" step="0.01" name="per_page_fee" class="form-control" value="{{ old('per_page_fee',$pricing->per_page_fee ?? '') }}">
    </div>
    <div class="col-md-4">
        <label>Per Drawing Fee</label>
        <input type="number" step="0.01" name="per_drawing_fee" class="form-control" value="{{ old('per_drawing_fee',$pricing->per_drawing_fee ?? '') }}">
    </div>
    <div class="col-md-4">
        <label>Per Sequence Page Fee</label>
        <input type="number" step="0.01" name="per_sequence_page_fee" class="form-control" value="{{ old('per_sequence_page_fee',$pricing->per_sequence_page_fee ?? '') }}">
    </div>
    <div class="col-md-4">
        <label>Translation Fee</label>
        <input type="number" step="0.01" name="translation_fee" class="form-control" value="{{ old('translation_fee',$pricing->translation_fee ?? '') }}">
    </div>
    <div class="col-md-4">
        <label>Expedited Fee</label>
        <input type="number" step="0.01" name="expedited_fee" class="form-control" value="{{ old('expedited_fee',$pricing->expedited_fee ?? '') }}">
    </div>
    <div class="col-md-4">
        <label>Tax %</label>
        <input type="number" step="0.01" name="tax_percentage" class="form-control" value="{{ old('tax_percentage',$pricing->tax_percentage ?? '') }}">
    </div>
    <div class="col-md-4">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active" {{ old('status',$pricing->status ?? '')=='active'?'selected':'' }}>Active</option>
            <option value="inactive" {{ old('status',$pricing->status ?? '')=='inactive'?'selected':'' }}>Inactive</option>
        </select>
    </div>
</div>
