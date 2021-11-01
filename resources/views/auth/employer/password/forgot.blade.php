

@extends('layouts.user.app')
@section('title', 'Forgot Password')
@section('content')
@push('style')
@endpush
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
                            <span>Send Code</span>
                            <form action="{{ route('employer.password.forgot') }}" method="post">
                                @csrf
                                <div class="cfield">
                                    <input type="text" name="email" id="phoneInput" value="{{ old('email') }}" placeholder="Email" />
                                    <i class="la la-user"></i>
                                </div>
                                {{-- <a href="{{ route('user.password.forgot') }}" title="">Forgot Password?</a> --}}
                                {{-- <a class="g-recaptcha" style="margin-bottom : 10px; display: block" data-sitekey="6LdXqLwcAAAAAGexX4xL9yApq3saOPFJcibqf3V1"></a> --}}
                                <button type="submit" id="cmdSubmit">Send</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<script>
    $("#cmdSubmit").click(function () {
        
        var email  = document.getElementById('phoneInput').value;
        var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        if(!re.test(email)){
        Swal.fire({
            icon: 'error',
            title: 'Thông tin không hợp lệ',
            text: 'Vui lòng nhập đúng định dạng của Email!\nExample@gmail.com',
        });
        return false;
        }
    });
</script>
@endpush