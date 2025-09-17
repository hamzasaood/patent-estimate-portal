@extends('layouts.app')
@section('title','Payment Successful')

@section('content')
<div class="container text-center my-5">
  <h1 class="text-success">✅ Payment Successful!</h1>
  <p>Your quote #{{ $quote->id }} has been paid.</p>
  <a href="{{ route('quotes.show.quick', $quote) }}" class="btn btn-primary">View Quote</a>
</div>
@endsection
