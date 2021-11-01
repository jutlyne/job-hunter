@extends('layouts.user.app')
@section('title', 'Employer Login')
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
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form action="{{ route('employer.login') }}" method="POST">
                                        @csrf
                                        <div class="cfield">
                                            <input type="text" name="email" value="{{ old('email') }}" placeholder="Email" />
                                            <i class="la la-user"></i>
                                        </div>
                                        <div class="cfield">
                                            <input type="password" name="password" placeholder="********" />
                                            <i class="la la-key"></i>
                                        </div>
                                        <p class="remember-label">
                                            <input type="checkbox" name="remember" id="cb1"><label for="cb1">Remember me</label>
                                        </p>
                                        <a href="{{ route('employer.password.forgot') }}" title="">Forgot Password?</a>
                                        <button type="submit">Login</button>
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
if (localStorage.key('os-user')) {
    document.getElementById('device_id').value = localStorage.getItem('os-user');
}
</script>
@endpush
