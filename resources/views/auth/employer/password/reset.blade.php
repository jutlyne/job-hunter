@extends('layouts.user.app')
@section('title', 'Set Password')
@section('content')
    <section>
        <div class="block remove-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="account-popup-area signin-popup-box static">
                            <div class="account-popup">
                                <span>
                                    @if (session('msg'))
                                    <p class="text-success text-center">
                                        {{ session('msg') }}
                                    </p>
                                    @endif
                                    @if (session('error'))
                                        <p class="text-danger text-center">
                                            {{ session('error') }}
                                        </p>
                                    @endif
                                </span>
                                <span>New Password</span>
                                <form method="POST" action="{{ route('employer.password.reset') }}">
                                    @csrf
                                    @if (!isset($code))
                                    <div class="cfield">
                                        <input type="text" value="{{ old('reset_password_code') }}" name="reset_password_code" id="phoneInput" placeholder="Code" />
                                        <i class="la la-user"></i>
                                    </div>
                                    @else
                                    <div class="cfield" style="display: none">
                                        <input type="text" value="{{ isset($code) ? $code : '' }}" name="email" id="phoneInput" placeholder="Code" />
                                        <i class="la la-user"></i>
                                    </div>
                                    @endif
                                    <div class="cfield">
                                        <input id="new-password" class="form-control" value="{{ old('password') }}" name="password" type="password" placeholder="New Password" />
                                        <i class="la la-user"></i>
                                    </div>
                                    <button type="submit" id="cmdSubmit">Change</button>
                                </form>
                                <div class="extra-login">
                                    <span>Or</span>
                                    <div class="login-social">
                                        <a class="fb-login" href="#" title=""><i class="fa fa-facebook"></i></a>
                                        <a class="tw-login" href="#" title=""><i class="fa fa-twitter"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- LOGIN POPUP -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
      const togglePassword = document.getElementById("toggle-password");
      togglePassword.addEventListener("click", toggleClicked);

      function toggleClicked() {
        const password = document.getElementById("new-password");
        if (this.checked) {
          password.type = "text";
        } else {
          password.type = "password";
        }
      }
    </script>
@endpush