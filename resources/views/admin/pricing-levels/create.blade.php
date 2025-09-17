@extends('admin.layout.app')

@section('content')
<div class="container">
    <h2>Create Pricing Level</h2>

    <form action="{{ route('pricing-levels.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kind/Type</label>
            <select name="kind" class="form-select" required>
      <option value="">Select...</option>
      <option value="pf">Patent Filling Fee Level</option>
      <option value="tf">Translation Fee Level</option>
      
    </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Adjustment %</label>
            <input type="number" name="adjustment_percent" value="{{ old('adjustment_percent') }}" class="form-control" step="0.01" required>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('pricing-levels.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
