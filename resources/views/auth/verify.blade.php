@extends('layouts.user.app')

@section('content')
    <section class="container" id="register">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <nav class="breadcrumb" aria-label="breadcrumbs">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Tạo tài khoản</li>
                    </ul>
                </nav>

                <div class="card card-body mb-5">
                    <a href="/policy" target="_blank">Điều khoản</a>
                    <hr>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('user.verify') }}">
                        @csrf
                        <div class="form-group">
                                @if(auth('user')->user()->phone_verified_at == null && auth('user')->user()->phone[0] != 0) 
                                    <span class="text-danger">Vui lòng cập nhật lại số điện thoại để tiến hành xác thực</span>
                                @else
                                <label for="">
                                     Code
                                </label>
                                <input name="code" class="form-control" type="text" required autocomplete="off" @if(auth('user')->user()->phone_verified_at == null && auth('user')->user()->phone[0] != 0) disabled @endif>
                                @endif
                        </div>
                        @if(auth('user')->user()->phone_verified_at != null || auth('user')->user()->phone[0] == 0)
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary" type="submit">xác nhận</button>
                            <button class="btn btn-link" id="send-code" onclick="sendCode();" type="button">Nhận mã</button>
                        </div>
                        @else
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-primary" href="/profile">Cập nhật SĐT</a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
      function sendCode()
      {
        $('#send-code').attr('disabled','disabled');
        const formData = new FormData();
        formData.append('_token', '{!! csrf_token() !!}');
          
        fetch('{{ route('user.send') }}', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(result => {
          console.log('Success:', result);
        })
        .catch(error => {
          console.error('Error:', error);
        });
      }
    </script>
@endpush