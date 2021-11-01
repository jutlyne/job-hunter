@extends('layouts.user.app')

@push('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endpush
@section('title', 'User Profile')
@section('content')
    @include('layouts.user.info')
    <section>
        <div class="block no-padding">
            <div class="container">
                <div class="row no-gape">
                    @include('layouts.user.leftbar')
                    <div class="col-lg-9 column">
                        <div class="padding-left">
                            <div class="manage-jobs-sec">
                                <h3>Change Password</h3>
                                @if (session('success'))
                                    <p class="text-success text-center">
                                        {{ session('success') }}
                                    </p>
                                @endif
                                @if (session('error'))
                                    <p class="text-danger text-center">
                                        {{ session('error') }}
                                    </p>
                                @endif
                                <div class="change-password">
                                    <form action="{{ route('user.password.change') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <span class="pf-title">Old Password</span>
                                                <div class="pf-field">
                                                    <input name="old_password" type="password" minlength="6" required />
                                                </div>
                                                <span class="pf-title">New Password</span>
                                                <div class="pf-field">
                                                    <input name="password" id="password" type="password" minlength="6" required />
                                                </div>
                                                <span class="pf-title">Confirm Password</span>
                                                <div class="pf-field">
                                                    <input name="password_confirmation" id="confirm-password" minlength="6" type="password" required />
                                                    <span class="pf-title d-none" id="error" style="margin: 5px 0; color: red">Do not match the new password</span>
                                                  </div>
                                                <button type="submit" id="btn-submit" class="d-none">Update</button>
                                            </div>
                                            <div class="col-lg-6">
                                                <i class="la la-key big-icon"></i>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        function delay(callback, ms) {
            var timer = 0;
            return function() {
                var context = this,
                    args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }
        $(document).ready(function() {
            $('#confirm-password').keyup(delay(function(e) {
                var curren = $('#password').val();
                var confirm = $(this).val();
                if (curren == confirm) {
                  $('#btn-submit').removeClass('d-none');
                  $('#error').addClass('d-none');
                } else {
                  $('#error').removeClass('d-none');
                  $('#btn-submit').addClass('d-none');
                }
            }, 800))
        })
    </script>
@endpush
