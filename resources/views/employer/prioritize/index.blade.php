@extends('layouts.employer.app')
@section('title', '')
@section('breadcrumb', 'Recruitments')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }} ">
@endpush

@section('content')
    <table class="table table-responsive-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Prioritize</th>
                <th>Priority expiration at</th>
                @if ($employer->prioritize == \App\Enums\Prioritize::IN_ACTIVE)
                    <th style="width: 25%" class="table-paypal">Priority activation with 10 USD per month</th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $employer->id }}</td>
                <td><span>{{ $employer->name }}</span></td>
                <td><span>{{ $employer->phone }}</span></td>
                <td><span id="status">{{ \App\Enums\Prioritize::toSelectArray()[$employer->prioritize] }}</span></td>
                <td><span>{{ $employer->prioritize_at ? date('d/m/Y H:i', strtotime($employer->prioritize_at . '+1 months')) : '--' }}</span>
                </td>
                @if ($employer->prioritize == \App\Enums\Prioritize::IN_ACTIVE)
                    <td class="table-paypal">
                        <button class="btn btn-paypal" id="paypal-button"></button>
                    </td>
                @endif
            </tr>
        </tbody>
    </table>

@endsection

@push('script')
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

    <script>
        paypal.Button.render({
            // Configure environment
            env: 'sandbox',
            client: {
                sandbox: 'AYlT_a1znWnZU7S6XJcIMqmMXozQn715ekMeZX6ENT-GBKv_rzsksvdOL0dyKjbjd7w02zJq6F1tRphV',
                production: 'EODPMdWH2dXWtNnV8lznfn8rdSbIDiJtxprLvxs0qT9DHXCg7-jTfy95z0Y1tZodG8WxzkmXuFpHk_Kl'
            },
            // Customize button (optional)
            locale: 'en_US',
            style: {
                size: 'small',
                color: 'gold',
                shape: 'pill',
                layout: 'horizontal',
                shape: 'rect',
                label: 'buynow',
                tagline: 'false'
            },

            // Enable Pay Now checkout flow (optional)
            commit: true,

            // Set up a payment
            payment: function(data, actions) {
                return actions.payment.create({
                    transactions: [{
                        amount: {
                            total: '10',
                            currency: 'USD'
                        }
                    }]
                });
            },
            // Execute the payment
            onAuthorize: function(data, actions) {
                return actions.payment.execute().then(function() {
                    // Show a confirmation message to the buyer
                    change();
                    Swal.fire({
                        icon: 'success',
                        title: 'Priority activation successful',
                        text: `You have successfully activated the priority mode, your job postings will be at the top`,
                    })
                });
            }
        }, '#paypal-button');

        function change() {
            $.ajax({
                url: "{{ route('employer.change.prioritize') }}",
                type: "get",
                data: {},
                success: function(data) {
                    $('#status').text('On Prioritize');
                    $('.table-paypal').remove();
                }
            });
        }
    </script>
@endpush
