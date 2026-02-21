@extends('layouts.app')

@push('styles')
    <link href="{{ asset('styles/user/list.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('scripts/user/list.js') }}" defer></script>
@endpush

@section('content')

@if($viewModel->status() === TRUE && $viewModel->hasPermission())
	<form action="" method="post" id="userForm" class="no-margin">@csrf</form>

	<!-- Search panel -->
	<form action="{{ route('user.search') }}" method="post" id="searchForm" class="no-margin">
		@csrf
		<dialog id="searchPanel" class="right">
			<h5>查詢</h5>
			
			<div class="field label border round field-light-blue">
				<input type="text" id="searchAd" name="searchAd" value="{{ $viewModel->search['ad'] }}" maxlength="20">
				<label>AD帳號</label>
			</div>
			<div class="field label border round field-light-blue">
				<input type="text" id="searchName" name="searchName" value="{{ $viewModel->search['name'] }}" maxlength="20">
				<label>顯示名稱</label>
			</div>
			<div class="field label suffix round border field-light-blue">
				<select id="searchRoleId" name="searchRoleId">
					<option value="">請選擇</option>
					@foreach($viewModel->option['roleList'] as $id => $name)
						<option value="{{ $id }}" @selected($id == $viewModel->search['roleId'])>{{ $name }}</option>
					@endforeach
				</select>
				<label>身份</label>
				<i>arrow_drop_down</i>
			</div>
			
			<nav class="right-align group split">
				<button type="button" class="btn-search left-round large"><i>search</i>查詢</button>
				<button type="button" class="btn-search-reset right-round square large"><i>backspace</i></button>
			</nav>
		</dialog>
	</form>
	
	<header class="page-nav">
		<nav>
			<button type="button" class="btn-show-search button circle" data-ui="#searchPanel"><i>search</i></button>
			<a href="{{ route('user.create.get') }}" class="btn-create button circle">
				<i>add</i>
			</a>
		</nav>
	</header>
	
	<section class="user-list">
		@if(empty(($viewModel->list)))
		<div class="alert alert-danger" role="alert">
			查無符合資料
		</div>
		@else
		<div class="d-table">
			<div class="d-table-row head">
				<div class="d-table-cell">#</div>
				<div class="d-table-cell">AD帳號</div>
				<div class="d-table-cell">顯示名稱</div>
				<div class="d-table-cell">工號</div>
				<div class="d-table-cell">身份</div>
				<!--div class="d-table-cell">EMail</div-->
				<div class="d-table-cell">狀態</div>
				<div class="d-table-cell">更新時間</div>
				<div class="d-table-cell cell-action">操作</div>
			</div>
			@foreach($viewModel->list as $idx => $user)
			<div class="d-table-row list">
				<div class="d-table-cell">{{ $idx + 1 }}</div>
				<div class="d-table-cell">{{ $user['userAd'] }}</div>
				<div class="d-table-cell">{{ $user['adDisplayName'] }}</div>
				<div class="d-table-cell">
					<span>{{ $user['adEmployeeId'] }}</span>
					@if(! empty($user['adDepartment']))
					<span class="badge none blue">{{ $user['adDepartment'] }}<span>
					@endif
				</div>
				<div class="d-table-cell">{{ $user['roleName'] }}</div>
				<!--div class="d-table-cell">{{ $user['adMail'] }}</div-->
				<div class="d-table-cell cell-status {{ $viewModel->getActiveStyle($user['isActive']) }}"></div>
				<div class="d-table-cell cell-date">{{ $user['updateAt'] }}</div>
				<div class="d-table-cell cell-action">
					<a href="{{ route('user.update.get', [$user['userId']]) }}" class="btn-edit button circle small" @disabled(! $viewModel->canEditThisUser($user['roleGroup']))>
						<i>edit</i>
					</a>
					<a href="{{ route('user.delete.post', [$user['userId']]) }}" class="btn-delete button circle small" @disabled(! $viewModel->canDeleteThisUser($user['userId'], $user['roleGroup']))>
						<i>delete</i>
					</a>
				</div>
			</div>
			@endforeach
		</div>
		@endif
	</section>
@endif <!-- Status -->

@endsection