@extends('admin.layout.app')

@section('content')
<div class="container">
    <h2>Edit Pricing Level</h2>

    <form action="{{ route('pricing-levels.update',$pricingLevel) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name',$pricingLevel->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kind/Type</label>
            <select name="kind" class="form-select" required>
      <option value=""  >Select...</option>
      <option value="pf" {{ old('kind',$pricingLevel->kind ?? '')=='pf' ? 'selected' : '' }}>Patent Filling Fee Level (Direct/PCT)</option>
      <option value="tf" {{ old('kind',$pricingLevel->kind ?? '')=='tf' ? 'selected' : '' }}>Translation Fee Level (Direct/PCT)</option>

      <option value="pfep" {{ old('kind',$pricingLevel->kind ?? '')=='pfep' ? 'selected' : '' }}>Patent Filling Fee Level (EP_Validation)</option>
      <option value="tfep" {{ old('kind',$pricingLevel->kind ?? '')=='tfep' ? 'selected' : '' }}>Translation Fee Level (EP_Validation)</option>
      
    </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Adjustment %</label>
            <input type="number" name="adjustment_percent" value="{{ old('adjustment_percent',$pricingLevel->adjustment_percent) }}" class="form-control" step="0.01" required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('pricing-levels.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
