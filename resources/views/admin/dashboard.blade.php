@extends('layouts.admin.app')
@section('style')
    <link rel="stylesheet" href="{{ mix('tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}">
    <style>
        .overlow {
            height: 480px;
            overflow-x: scroll;
        }
    </style>
@endsection
@section('content')
    <div id="loadItem">
        <div class="d-none">
            @foreach ($count as $item)
                <input class="month" type="text" value="{{ $item + 10 }}">
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-7 card overlow">
                <div id="chart"></div>
            </div>
            <div class="col-md-5 card overlow" style="text-align: center">
                <div class="">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Time Login</th>
                                <th>Browser</th>
                                <th>Operating system</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($login_log as $item)
                                <tr>
                                    <td>{{ $item->user_name }}</td>
                                    <td>{{ $item->date_time }}</td>
                                    <td>{{ $item->browser }}</td>
                                    <td>{{ $item->os }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ mix('js/moment.js') }}"></script>
    <script src="{{ mix('tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // window.location.reload()
        const d = new Date();
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
            "November", "December"
        ];
        month = d.getMonth()
        year = d.getUTCFullYear()
        const count = [],
            category = []
        var els = $('.month'),
            i = 0
        for (i; i < 5; i++) {
            if ($(els[i]).val()) {
                count[i] = $(els[i]).val()
            } else {
                count[i] = 5
            }
            const m = months[month - i];
            if (m) {
                category[i] = m + ' - ' + year;
            } else {
                category[i] = months[12 - i] + ' - ' + (year - 1);
            }
        }
        categories = category.reverse();
        data = count.reverse();
        categories = category.filter(function( element ) {
            return element !== undefined;
        });

        var options = {
            series: [{
                name: "login log",
                data: data
            }],
            chart: {
                type: 'bar',
                height: 380
            },
            xaxis: {
                categories: categories
            },
            title: {
                text: 'Login log for 5 months',
                align: 'left',
                style: {
                    color: '#444'
                }
            },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>
@endpush
