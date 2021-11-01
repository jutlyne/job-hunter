@extends('layouts.admin.app')
@section('title', 'Admin')
@section('breadcrumb', 'Admin')
@section('content')

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
     .about, .project, .skills, .contact{
  font-family: 'Poppins', sans-serif;
}
section .title{
  position: relative;
  text-align: center;
  font-size: 40px;
  font-weight: 500;
  margin-bottom: 60px;
  padding-bottom: 20px;
  font-family: 'Ubuntu',sans-serif;
}
section .title::before{
  position: absolute;
  bottom: 0;
  left: 50%;
  width: 180px;
  height: 3px;
  background: #111;
  transform: translateX(-50%);
}
.about .title::before{
  content: "";
}
section .title::after{
  position: absolute;
  bottom: -12px;
  font-size: 20px;
  color: crimson;
  left: 50%;
  padding: 5px;
  background: #bdc3c7;
  transform: translateX(-50%);
}
.about .title::after{
  content: "Who i am";
}
.about .about-content, .contact .contact-content{
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
}
.about .about-content .left{
  width: 45%;
}
.about .about-content .left img{
  height: 400px;
  width: 400px;
  object-fit: cover;
  border-radius: 5px;
}
.about .about-content .right{
  width: 55%;
}
.about .about-content .right .text{
  font-size: 25px;
  font-weight: 600;
  margin-bottom: 10px;
}
.about .about-content .right .text span{
  color: crimson;
}
.about .about-content .right p{
  text-align: justify;
}
.about .about-content .right a{
  display: inline-block;
  background: crimson;
  color: #fff;
  font-size: 20px;
  padding: 10px 30px;
  margin-top: 20px;
  border-radius: 5px;
  font-weight: 500;
  border: 2px solid crimson;
  transition: all .3s ease;
}
.about .about-content .right a:hover{
  color: crimson;
  background: none;
}   
</style>

@endpush

    <div class="row">
        <section class="about" id="about">
            <div class="max-width">
              <h2 class="title">About me</h2>
              <div class="about-content row">
                <div class="column left col-md-5 col-12">
                  <img src="{{ $profile[0]->avatar_url }}" alt="">
                </div>
                <div class="column right col-md-7 col-12">
                  <div class="text">
                    {!! $profile[0]->title !!}
                  </div>
                  <p>{{ $profile[0]->description }}</p>
                  <a href="{{ route('admin.profile.edit', $profile[0]->id) }}">Edit My Profile</a>
                </div>
              </div>
            </div>
          </section>
    </div>
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
</script>
@endpush