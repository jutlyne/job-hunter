@extends('layouts.user.app')
@section('title', 'Select Login')

@section('content')
    <section>
        <div class="block remove-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="account-popup-area signin-popup-box static">
                            <div class="account-popup">
                                <h3>User Login</h3>
                                <span>Click To Login With User</span>
                                <div class="select-user">
                                    <span><a href="{{ route('user.show_login', ['redirect' => '/profile']) }}">Candidate</a></span>
                                    <span><a href="{{ route('employer.show_login', ['redirect' => '/']) }}">Employer</a></span>
                                </div>
                            </div>
                        </div><!-- LOGIN POPUP -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
