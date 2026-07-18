@extends($theme.'layouts.app')
@section('title',__('Login'))
@section('content')
	<!-- login-signup section start -->
	<section class="login-signup-page">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-5 col-md-8">
					<div class="login-signup-form">
						<form action="{{ route('login') }}" method="post">
							@csrf
							<div class="login-signup-header">
								<h4>@lang(optional(@$template->description)->title)</h4>
								<div class="description">@lang(optional(@$template->description)->sub_title)</div>
							</div>
							<div class="row g-3">
								<div class="col-12">
									<input type="text" name="identity" value="{{ old('identity') }}"
										   class="form-control" id="exampleInputEmail1"
										   placeholder="@lang('Username or Email')">
									<div class="text-danger">
										@error('username') @lang($message) @enderror
										@error('email') @lang($message) @enderror
									</div>
								</div>
								<div class="col-12">
									<div class="password-box">
										<input type="password" name="password" class="form-control password"
											   id="exampleInputPassword1"
											   placeholder="@lang('Password')">
										<i class="password-icon fa-regular fa-eye"></i>
										<div class="text-danger">
											@error('password') @lang($message) @enderror
										</div>
									</div>
								</div>
								@if((basicControl()->manual_reCaptcha_status == 1) && (basicControl()->reCaptcha_status_login	== 1))
									<div class="input-box mb-4">
										<input type="text" tabindex="2"
											   class="form-control @error('captcha') is-invalid @enderror"
											   name="captcha" id="captcha" autocomplete="off"
											   placeholder="@lang('Enter captcha code')" required>
										@error('captcha')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror
									</div>

									<div class="mb-4">
										<div class="input-group input-group-merge d-flex justify-content-between"
											 data-hs-validation-validate-class>
											<img src="{{route('captcha').'?rand='. rand()}}" id='captcha_image'>
											<a class="input-group-append input-group-text"
											   href='javascript: refreshCaptcha();'>
												<i class="fas fa-sync  "></i>
											</a>
										</div>
									</div>
								@endif

								@if(basicControl()->reCaptcha_status_login && basicControl()->google_reCaptcha_status)
									<div class="form-group">
										{!! NoCaptcha::renderJs() !!}
										{!! NoCaptcha::display() !!}
										@error('g-recaptcha-response')
										<div class="text-danger mt-1 mb-1">@lang($message)</div>
										@enderror
									</div>
								@endif
								<div class="col-12">
									<div class="form-check d-flex justify-content-between">
										<div class="check">
											<input type="checkbox" class="form-check-input" id="exampleCheck1">
											<label class="form-check-label"
												   for="exampleCheck1">@lang('Remember me')</label>
										</div>
										@if (Route::has('password.request'))
											<div class="forgot highlight">
												<a href="{{ route('password.request') }}">@lang('Forgot password')?</a>
											</div>
										@endif
									</div>
								</div>
							</div>
							<button type="submit" class="btn cmn-btn mt-30 w-100">@lang('Log In')</button>
							<hr class="divider">

							<div class="cmn-btn-group">
								<div class="row g-2">
									@if(config('basic.google_status'))
										<div class="col-sm-4">
											<a href="{{route('socialiteLogin','google')}}"
											   class="btn cmn-btn3 w-100 social-btn"><img
													src="{{asset($themeTrue.'images/login-signup/google.png')}}"
													alt="...">@lang('Google')
											</a>
										</div>
									@endif
									@if(config('basic.facebook_status'))
										<div class="col-sm-4">
											<a href="{{route('socialiteLogin','facebook')}}"
											   class="btn cmn-btn3 w-100 social-btn"><img
													src="{{asset($themeTrue.'images/login-signup/facebook.png')}}"
													alt="...">@lang('Facebook')
											</a>
										</div>
									@endif
									@if(config('basic.github_status'))
										<div class="col-sm-4">
											<a href="{{route('socialiteLogin','github')}}"
											   class="btn cmn-btn3 w-100 social-btn"><img
													src="{{asset($themeTrue.'images/login-signup/github.png')}}"
													alt="...">@lang('Github')
											</a>
										</div>
									@endif
								</div>
							</div>
							<div class="pt-20 text-center">
								@lang("Don't have an account")?
								<p class="mb-0 highlight"><a
										href="{{ route('register') }}">@lang('Create an account')</a></p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- login-signup section end -->
@endsection
@section('scripts')
	<script>
		"use strict";

		// input field show hide password start
		const password = document.querySelector('.password');
		const passwordIcon = document.querySelector('.password-icon');

		passwordIcon.addEventListener("click", function () {
			if (password.type == 'password') {
				password.type = 'text';
				passwordIcon.classList.add('fa-eye-slash');
			} else {
				password.type = 'password';
				passwordIcon.classList.remove('fa-eye-slash');
			}
		})
		// input field show hide password end

		function refreshCaptcha() {
			let img = document.images['captcha_image'];
			img.src = img.src.substring(
				0, img.src.lastIndexOf("?")
			) + "?rand=" + Math.random() * 1000;
		}
	</script>
@endsection
