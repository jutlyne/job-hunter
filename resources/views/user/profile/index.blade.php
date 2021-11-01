@extends('layouts.user.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }} ">
@endpush
@section('title', 'User Profile')
@section('content')
    @include('layouts.user.info')
    <section>
        <div class="block no-padding">
            <div class="container">
                <div class="row no-gape">
                    @include('layouts.user.leftbar')
                    <div class="col-lg-9 column" style="padding: 0 20px">
                        <form action="" method="POST">
                            <div class="padding-left">
                                <div class="profile-title">
                                    <h3>My Profile</h3>
                                    {{-- <div class="upload-img-bar">
										<span class="round"><img src="{{ $user->getAvatarUrl }}" alt="" /></span>
										<div class="upload-info">
											<a href="#" title="">Browse</a>
											<span>Max file size is 1MB, Minimum dimension: 270x210 And Suitable files are .jpg & .png</span>
										</div>
									</div> --}}
                                </div>
                                <div class="profile-form-edit">
                                    <form action="{{ route('user.profile') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <span class="pf-title">Full Name</span>
                                                <div class="pf-field">
                                                    <input type="text" name="name" placeholder="{{ $user->name }}"
                                                        disabled style="background: #dfe6e9" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="pf-title">Job Title</span>
                                                <div class="pf-field">
                                                    <input type="text" name="job_title"
                                                        placeholder="{{ isset($user->profile) ? $user->profile->job_title : '' }}"
                                                        value="{{ isset($user->profile) ? $user->profile->job_title : '' }}" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="pf-title">Experience</span>
                                                <div class="pf-field">
                                                    <select data-placeholder="Allow In Search" name="experience"
                                                        class="chosen">
                                                        @foreach (\App\Enums\ExperienceEnums::toSelectArray() as $key => $item)
                                                            <option value="{{ $key }}"
                                                                {{ isset($user->profile) && $user->profile->experience == $key ? 'selected' : '' }}>
                                                                {{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="pf-title">Year Of Birth</span>
                                                <div class="pf-field">
                                                    <input type="text" name="year_of_birth"
                                                        placeholder="{{ isset($user->profile) ? $user->profile->year_of_birth : '' }}"
                                                        value="{{ isset($user->profile) ? $user->profile->year_of_birth : '' }}" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="pf-title">Education Levels</span>
                                                <div class="pf-field">
                                                    <select data-placeholder="Please Select Specialism" name="education"
                                                        class="chosen">
                                                        @foreach (\App\Enums\EducationLevels::toSelectArray() as $key => $item)
                                                            <option value="{{ $key }}"
                                                                {{ isset($user->profile) && $user->profile->education == $key ? 'selected' : '' }}>
                                                                {{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <span class="pf-title">Languages</span>
                                                <div class="pf-field">
                                                    <div class="pf-field">
                                                        <select data-placeholder="Please Select Specialism" name="language"
                                                            class="chosen">
                                                            @foreach (\App\Enums\Languages::toSelectArray() as $key => $item)
                                                                <option value="{{ $key }}"
                                                                    {{ isset($user->profile) && $user->profile->language == $key ? 'selected' : '' }}>
                                                                    {{ $item }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <span class="pf-title">Description</span>
                                            <div class="pf-field">
                                                <textarea
                                                    name="quote" style="resize:none">{{ isset($user->profile) ? $user->profile->quote : '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit">Update</button>
                                        </div>
                                </div>
                        </form>
                    </div>
                    <div class="contact-edit">
                        {{-- <h3>Contact</h3>
									<form>
										<div class="row">
											<div class="col-lg-6">
												<span class="pf-title">Phone Number</span>
												<div class="pf-field">
													<input type="text" placeholder="{{ $user->phone }}" />
												</div>
											</div>
											<div class="col-lg-6">
												<span class="pf-title">Email</span>
												<div class="pf-field">
													<input type="text" placeholder="{{ $user->email }}" />
												</div>
											</div>
											<div class="col-lg-6">
												<span class="pf-title">Country</span>
												<div class="pf-field">
													<select data-placeholder="Please Select Specialism" class="chosen">
													 <option>Web Development</option>
													 <option>Web Designing</option>
													 <option>Art & Culture</option>
													 <option>Reading & Writing</option>
												 </select>
												</div>
											</div>
											<div class="col-lg-6">
												<span class="pf-title">City</span>
												<div class="pf-field">
													<select data-placeholder="Please Select Specialism" class="chosen">
													 <option>Web Development</option>
													 <option>Web Designing</option>
													 <option>Art & Culture</option>
													 <option>Reading & Writing</option>
												 </select>
												</div>
											</div>
											<div class="col-lg-12">
												<button type="submit">Update</button>
											</div>
										</div>
									</form> --}}
                    </div>
                </div>
                </form>
            </div>
        </div>
        </div>
        </div>
    </section>
@endsection

