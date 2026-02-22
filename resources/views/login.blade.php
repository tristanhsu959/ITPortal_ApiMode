@extends('layouts.app')
@use('App\Enums\AuthType')

@push('styles')
    <link href="{{ asset('styles/login.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('scripts/login.js') }}" type="module" defer></script>
@endpush

@section('isLoginView', 'true')

@section('content')
<form x-data="login()" class="responsive" @submit.prevent="submit" novalidate>
	@csrf
	
	<header class="head middle-align center-align vertical">
		<img src="{{ asset('images/logo.svg') }}" />
		<h3><span>IT<b>Portal</b></span></h3>
	</header>
	
	<div class="container">
		<div class="field label border field-purple" :class="Helper.hasError(errors, 'account')">
			<input type="text" id="account" x-model="formData.account" @input="errors.delete('account')" maxlength="20" required>
			<label>AD帳號</label>
			<span class="suffix">@8way.com.tw</span>
		</div>
		<div class="field label border field-purple" :class="Helper.hasError(errors, 'password')">
			<input type="password" x-model="formData.password" @input="errors.delete('password')" maxlength="20" required>
			<label>密碼</label>
		</div>
		<div class="nav-bar">
			<nav class="buttons">
				<button type="submit" class="btn-login max small-round ripple">登入</button>
				<button type="button" class="btn-reset min small-round ripple" @click="reset"><i>backspace</i></button>
			</nav>
			<div class="radios">
				<label for="ad">
					<input type="radio" id="ad" x-model="formData.authType" value="{{ AuthType::AD->value }}">
					{{ AuthType::AD->label() }}
				</label>
				<label for="system">
					<input type="radio" id="system" x-model="formData.authType" value="{{ AuthType::SYSTEM->value }}">
					{{ AuthType::SYSTEM->label() }}
				</label>
			</div>
		</div>
	</div>
</form>
@endsection