@extends('layouts.app')
@use('App\Enums\Status')

@push('styles')
	<link href="{{ asset('styles/user/detail.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('scripts/user/detail.js') }}" defer></script>
@endpush

@section('content')
		
<form action="{{ $viewModel->getFormAction() }}" method="post" id="userForm">
	<input type="hidden" value="{{ $viewModel->user['id'] }}" name="id">
	@csrf

	<section class="user-data">
		@if($viewModel->isUpdate())
			<label class="large-text">更新時間：{{ $viewModel->user['updateAt'] }}</label>
		@endif
		
		<div class="row">
			<div class="field label border field-dark-blue">
				<input type="text" id="adAccount" name="adAccount" value="{{  $viewModel->user['ad'] }}" maxlength="15">
				<label>AD帳號</label>
				<output>@8way.com.tw</output>
			</div>
		</div>
		<div class="user-password row">
			<div class="field label border field-dark-blue field-password">
				<input type="password" id="password" name="password" value="" maxlength="15" data-bs-toggle="tooltip" data-bs-placement="top" title="數字+英文，六個字元以上">
				<label>系統驗證密碼</label>
				<button type="button" class="button circle transparent small btn-view-pwd"></button>
				<span class="tooltip">系統驗證登入模式：設定完成<br/>可使用［AD帳號+系統密碼］登入</span>
			</div>
			<button type="button" class="button btn-generate-pwd">產生密碼</button>
			
			@if($viewModel->hasPassword())
			<label class="checkbox remove-password check-red">
				<input type="checkbox" value="1" id="removePassword" name="removePassword">
				<span>刪除既有密碼<span class="badge none">此帳號已設定密碼</span></span>
			</label>
			@endif
		</div>
		<div class="user-status row field-light-green">
			<label class="switch switch-green">
				<input type="checkbox" name="status" value="1" @checked($viewModel->user['isActive'] == Status::ACTIVE->value)>
				<span>啟用</span>
			</label>
		</div>
		
		<fieldset class="user-roles fieldset field-dark-blue required">
			<legend>使用者身份</legend>
			<nav>
				@foreach($viewModel->option['roleList'] as $id => $name)
				<label for="role-{{$id}}">
					<input type="radio" name="role" id="role-{{$id}}" value="{{ $id }}" @checked($viewModel->user['roleId'] == $id) >
					{{ $name }}
				</label>
				@endforeach
			</nav>
		</fieldset>

		<nav class="toolbar">
			<button type="button" class="button btn-save btn-primary">{{ $viewModel->action->label()}}</button>
			<button type="button" class="button btn-cancel border" id="btnReset">重置</button>
		</nav>
	</section>
</form>
@endsection