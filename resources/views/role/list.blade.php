@extends('layouts.app')
@use('App\Enums\RoleGroup')

@push('styles')
	<link href="{{ asset('styles/role/list.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('scripts/role/list.js') }}" defer></script>
@endpush

@section('content')

@if($viewModel->status() === TRUE && $viewModel->hasPermission())
	<form action="" method="post" id="roleForm" class="no-margin">@csrf</form>
	
	<header class="page-nav">
		<nav>
			<a href="{{ route('role.create.get') }}" class="btn-create button circle">
				<i>add</i>
			</a>
		</nav>
	</header>
	
	<section class="role-list">
		@if(empty(($viewModel->list)))
		<div class="alert alert-danger" role="alert">
			查無符合資料
		</div>
		@else
		<div class="d-table">
			<div class="d-table-row head">
				<div class="d-table-cell">#</div>
				<div class="d-table-cell">身份</div>
				<div class="d-table-cell">權限群組</div>
				<div class="d-table-cell">更新時間</div>
				<div class="d-table-cell cell-action">操作</div>
			</div>
			@foreach($viewModel->list as $idx => $role)
			<div class="d-table-row list">
				<div class="d-table-cell">{{ $idx + 1 }}</div>
				<div class="d-table-cell">{{ $role['roleName'] }}</div>
				<div class="d-table-cell">{{ RoleGroup::getLabelByValue($role['roleGroup']) }}</div>
				<div class="d-table-cell">{{ $role['updateAt'] }}</div>
				<div class="d-table-cell cell-action">
					<a href="{{ route('role.update.get', [$role['roleId']]) }}" class="btn-edit button circle small" @disabled(! $viewModel->canEditThisRole($role['roleGroup']))>
						<i>edit</i>
					</a>
					<a href="{{ route('role.delete.post', [$role['roleId']]) }}" class="btn-delete button circle small" @disabled(! $viewModel->canDeleteThisRole($role['roleGroup']))>
						<i>delete</i>
					</a>
				</div>
			</div>
			@endforeach
		</div>
		@endif
	</section>
@endif
@endsection