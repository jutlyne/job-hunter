@extends('layouts.user.app')
@section('title', 'Create New Password')
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
                                <span>Create New Password</span>
                                <form action="{{ route('user.social.password.create') }}" method="post">
                                  @csrf
                                    <div class="cfield">
                                        <input id="new-password" class="form-control" value="{{ old('password') }}" name="password" type="password" placeholder="New Password" />
                                        <i class="la la-user"></i>
                                    </div>
                                    <button type="submit" id="cmdSubmit">Create</button>
                                </form>
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