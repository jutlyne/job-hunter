@extends('layouts.employer.app')
@section('title', '')
@section('breadcrumb', 'Recruitments')

@push('style')
    
@endpush

@section('content')
<div style="min-height: 92px">
    <div id="paypal-button-container"></div>
</div> 
@endsection

@push('script')
<script
    src="https://www.paypal.com/sdk/js?client-id=AYlT_a1znWnZU7S6XJcIMqmMXozQn715ekMeZX6ENT-GBKv_rzsksvdOL0dyKjbjd7w02zJq6F1tRphV">
</script>
@endpush
