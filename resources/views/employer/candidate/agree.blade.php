@extends('layouts.employer.app')
@section('title', 'Applies Manage')
@section('breadcrumb', 'Recruitments')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <style>
        td {
            max-width: 80px;
            max-height: 60px;
        }

        td span {
            width: 100%;
            overflow: hidden;
            display: -webkit-inline-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .pagination {
            justify-content: center;
        }

        @media only screen and (min-width: 576px) {
            .modal-dialog {
                max-width: 650px;
            }
        }

    </style>
@endpush

@section('content')
    <div class="card">
        
    </div>
@endsection

@push('script')
    <script src={{ asset('js/select2.min.js') }}></script>
    <script>
        $(function() {
            $('.js-example-basic-multiple').select2();
        })

        $(document).on("click", ".btn-danger", function(e) {
            if (!confirm('Deleted data will not be recoverable ?')) {
                e.preventDefault();
            }
        });
        $(document).on("click", ".btn-info", function(e) {
            url = $(this).attr('data-url');
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    profile = data.profile;
                    $('#education').html(profile.education);
                    $('#exp').html(profile.experience);
                    $('#lang').html(profile.language);
                    $('#quote').html(profile.quote);

                    $('#myModal').modal('show');
                },
                error: function(e) {
                    console.log(e.message);
                }
            });
        });
    </script>
@endpush
