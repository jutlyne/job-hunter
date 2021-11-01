@extends('layouts.user.app')
@section('title', 'Login')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
@endpush

@section('content')
    <section>
        <div class="block no-padding  gray">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="inner2">
                            <div class="inner-title2">
                                <h3>Login</h3>
                                <span>Keep up to date with the latest news</span>
                            </div>
                            <div class="page-breacrumbs">
                                <ul class="breadcrumbs">
                                    <li><a href="#" title="">Home</a></li>
                                    <li><a href="#" title="">Pages</a></li>
                                    <li><a href="#" title="">Login</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="block remove-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="account-popup-area signin-popup-box static">
                            <div class="account-popup">
                                <h3>User Login</h3>
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
                                <form action="{{ route('user.login') }}" method="post">
                                    @csrf
                                    <div class="cfield">
                                        <input type="text" name="email" id="phoneInput" value="{{ old('email') }}" placeholder="Email" />
                                        <i class="la la-user"></i>
                                    </div>
                                    <div class="cfield">
                                        <input type="password" name="password" id="passwordInput" placeholder="********" />
                                        <i class="la la-key"></i>
                                    </div>
                                    <p class="remember-label">
                                        <input type="checkbox" name="remember" id="remember"><label for="cb1">Remember me</label>
                                    </p>
                                    <a href="{{ route('user.password.forgot') }}" title="">Forgot Password?</a>
                                    {{-- <a class="g-recaptcha" style="margin-bottom : 10px; display: block" data-sitekey="6LdXqLwcAAAAAGexX4xL9yApq3saOPFJcibqf3V1"></a> --}}
                                    <button type="submit" id="cmdSubmit">Login</button>
                                </form>
                                <div class="extra-login">
                                    <span>Or</span>
                                    <div class="login-social">
                                        <a class="fb-login" href="{{ route('user.login.google') }}" title=""><i class="fab fa-google"></i></a>
                                        <a class="tw-login" href="#" title=""><i class="fab fa-facebook"></i></a>
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
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-RXf+QSDCUQs5uwRKaDoXt55jygZZm2V++WUZduaU/Ui/9EGp3f/2KZVahFZBKGH0s774sd3HmrhUy+SgOFQLVQ==" crossorigin="anonymous"></script>
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
