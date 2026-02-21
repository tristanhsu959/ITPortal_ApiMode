@extends('layouts.app')
@use('App\Enums\AuthType')

@push('styles')
    <link href="{{ asset('styles/signin.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('scripts/signin.js') }}" defer></script>
@endpush

@section('signin')
<div class="absolute middle-align center-align">
	<div class="m6">
		<header class="head middle-align center-align vertical">
			<img src="{{ asset('images/logo.svg') }}" />
			<h3><span>IT<b>Portal</b></span></h3>
		</header>
		
		<form action="{{ route('signin.post') }}" method="post" id="signinForm">
			@csrf
			<div class="content-wrapper">
				<div class="field label border field-purple">
					<input type="text" id="account" name="account" value="{{ $viewModel->account }}" maxlength="20" required>
					<label>AD帳號</label>
					<span class="suffix">@8way.com.tw</span>
				</div>
				<div class="field label border field-purple">
					<input type="password" id="password" name="password" maxlength="20" required>
					<label>密碼</label>
				</div>
				<div class="nav-bar">
					<nav class="buttons">
						<button id="btnSignin" type="button" class="max small-round ripple">登入</button>
						<button id="btnReset" type="button" class="min small-round ripple"><i>backspace</i></button>
					</nav>
					<div class="radios">
						<label for="ad">
							<input type="radio" id="ad" name="authType" value="{{ AuthType::AD->value }}" @checked(AuthType::AD->value == $viewModel->authType) >
							{{ AuthType::AD->label() }}
						</label>
						<label for="system">
							<input type="radio" id="system" name="authType" value="{{ AuthType::SYSTEM->value }}" @checked(AuthType::SYSTEM->value == $viewModel->authType)>
							{{ AuthType::SYSTEM->label() }}
						</label>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection