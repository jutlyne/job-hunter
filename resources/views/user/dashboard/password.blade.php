@extends('layouts.user.app')

@push('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endpush
@section('title', 'Info')
@section('content')
@include('layouts.user.info')

<section>
  <div class="block no-padding">
    <div class="container">
       <div class="row no-gape">
         @include('layouts.user.leftbar')
         <div class="col-lg-9 column">
           <div class="padding-left">
             <div class="manage-jobs-sec">
               <h3>Change Password</h3>
               <div class="change-password">
                 <form>
                   <div class="row">
                     <div class="col-lg-6">
                       <span class="pf-title">Old Password</span>
                       <div class="pf-field">
                         <input type="password" />
                       </div>
                       <span class="pf-title">New Password</span>
                       <div class="pf-field">
                         <input type="password" />
                       </div>
                       <span class="pf-title">Confirm Password</span>
                       <div class="pf-field">
                         <input type="password" />
                       </div>
                       <button type="submit">Update</button>
                     </div>
                     <div class="col-lg-6">
                       <i class="la la-key big-icon"></i>
                     </div>
                   </div>
                 </form>
               </div>
             </div>
           </div>
        </div>
       </div>
    </div>
  </div>
</section>
@endsection

@push('script')
    <script>
      
    </script>
@endpush
