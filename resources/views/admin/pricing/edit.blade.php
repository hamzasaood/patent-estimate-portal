@extends('admin.layout.app')

@section('content')
<div class="container p-4">
    
    <h3>Edit Pricing Rule</h3>
    <form action="{{ route('pricing-logics.update', $pricing_logic) }}" method="POST">

        @csrf @method('PUT')
        @include('admin.pricing.form')
        <button type="submit" class="btn btn-success mt-3">Update</button>
    </form>
</div>
@endsection
