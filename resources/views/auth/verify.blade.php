@extends('layouts.user.app')
@section('title', 'Verify')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }} ">
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
                                        <input type="text" name="code" id="phoneInput" placeholder="Code" />
                                        <i class="la la-user"></i>
                                    </div>
                                    <a class="resend" href="">Resend Verify Code</a>
                                    <button type="submit" id="cmdSubmit">Verify</button>
                                </form>
                                <div class="extra-login">
                                    <span>Or</span>
                                    <div class="login-social">
                                        <a class="fb-login" href="{{ route('user.login.google') }}" title=""><i
                                                class="fab fa-google"></i></a>
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
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script>
        $('.resend').on('click', function(e) {
            e.preventDefault();
            const _this = $(this);
            _this.hide(200);
            url = `{{ route('user.verify.resent') }}`;
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    _token: $('meta[name=csrf-token]').attr('content')
                },
                success: function(data) {
                    if (data) {
                        Swal.fire({
                            title: 'Successfully',
                            icon: 'success',
                        })
                    }
                    _this.show(200);
                },
                error: function() {
                    alert('Có lỗi xảy ra');
                }
            })
        })
    </script>
@endpush
