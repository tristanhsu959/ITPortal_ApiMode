@extends('layouts.app')

@push('styles')
	<link href="{{ asset('styles/role/detail.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('scripts/role/detail.js') }}" defer></script>
@endpush

@section('content')
<form action="{{ $viewModel->getFormAction() }}" method="post" id="roleForm">
	<input type="hidden" value="{{ $viewModel->role['id'] }}" name="id">
	@csrf

	<section class="role-data">
		@if($viewModel->isUpdate())
			<label class="large-text">更新時間：{{ $viewModel->role['updateAt'] }}</label>
		@endif
		
		<div class="row">
			<div class="field label border field-purple">
				<input type="text" id="name" name="name" value="{{  $viewModel->role['name'] }}" maxlength="10" required>
				<label>身份名稱</label>
			</div>
		</div>
		<div class="row">
			<div class="field label suffix border field-purple">
				<select id="group" name="group">
					<option value="">請選擇</option>
					@foreach($viewModel->option['roleGroups'] as $role)
						<option value="{{ $role->value }}" @selected($viewModel->role['group'] == $role->value) >
						{{ $role->label() }}
						</option>
					@endforeach
				</select>
				<label>權限群組</label>
				<i>arrow_drop_down</i>
			</div>
		</div>
		
		<fieldset class="role-permission field-purple fieldset required">
			<legend>功能權限</legend>
			<ul class="list border">
				@foreach($viewModel->option['functionList'] as $functionKey => $function)
				<li class="{{ $function['style']['group'] }}">
					<div class="max">
						<h6 class="small">{{ $function['name'] }}</h6>
					</div>
					<label class="switch field-dark-blue">
						<input type="checkbox" name="permission[]" value="{{ $functionKey }}" @checked(in_array($functionKey, $viewModel->role['permission']))>
						<span></span>
					</label>
				</li>
				@endforeach
			</ul>
		</fieldset>
		
		<nav class="toolbar">
			<button type="button" class="button btn-save btn-primary">{{ $viewModel->action->label()}}</button>
			<button type="button" class="button btn-cancel border" id="btnReset">重置</button>
		</nav>
	</section>
</form>

@endsection()