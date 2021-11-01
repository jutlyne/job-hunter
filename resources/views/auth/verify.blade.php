@extends('layouts.user.app')
@section('title', 'Verify')
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
                            <span>User Verify</span>
                            <form action="{{ route('user.verify') }}" method="post">
                                @csrf
                                <div class="cfield">
                                    <input type="text" name="code" id="phoneInput" value="{{ old('email') }}" placeholder="Code" />
                                    <i class="la la-user"></i>
                                </div>
                                <button type="submit" id="cmdSubmit">Verify</button>
                            </form>
                            <div class="extra-login">
                                <span>Or</span>
                                <div class="login-social">
                                    <a class="fb-login" href="{{ route('user.login.google') }}" title=""><i class="fab fa-google"></i></a>
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

</script>
@endpush