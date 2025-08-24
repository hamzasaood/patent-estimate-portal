@extends('admin.layout.app')

@section('content')
<div class="container p-4">
    <h3>Add Pricing Rule</h3>
    <form action="{{ route('pricing.store') }}" method="POST">
        @csrf
        @include('admin.pricing.form')
        <button type="submit" class="btn btn-success mt-3">Save</button>
    </form>
</div>
@endsection
