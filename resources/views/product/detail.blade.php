@extends('layouts.app')

@push('styles')
	<link href="{{ asset('styles/product/detail.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('scripts/product/detail.js') }}" defer></script>
@endpush

@section('content')
		
<form action="{{ $viewModel->getFormAction() }}" method="post" id="productForm">
	<input type="hidden" value="{{ $viewModel->group['id'] }}" name="groupId">
	@csrf

	<section class="product-data">
		@if($viewModel->isUpdate())
			<label class="large-text">更新時間：{{ $viewModel->group['updateAt'] }}</label>
		@endif
		
		<div class="row">
			<div class="field label suffix border field-dark-blue">
				<select id="brand" name="brand">
					<option value="">請選擇</option>
					@foreach($viewModel->option['brandList'] as $brand)
						<option value="{{ $brand->value }}" @selected($viewModel->group['brand'] == $brand->value) >
						{{ $brand->label() }}
						</option>
					@endforeach
				</select>
				<label>品牌</label>
				<i>arrow_drop_down</i>
			</div>
			<div class="field label border field-dark-blue">
				<input type="text" id="name" name="name" value="" maxlength="30">
				<label>產品群組名稱</label>
				<span class="tooltip">定義統一的產品名稱</span>
			</div>
		</div>
		<div class="row">
			<div class="field label border field-dark-blue">
				<textarea id="erpNo" name="erpNo" placeholder=" "></textarea>
				<label>產品料號</label>
				<span class="tooltip">多筆料號請用換行分隔</span>
			</div>
			<button type="button" class="button btn-fetch-product purple">取得產品</button>
		</div>
		
		<div class="row top-align">
			<fieldset class="product-primart fieldset field-dark-blue required max">
				<legend>主料號</legend>
				<ul class="list border">
					<li>
						<button class="circle">A</button>
						<div class="max">
							<h6 class="small">Headline</h6>
							<div>Supporting text</div>
						</div>
						<label>+15 min</label>
						<button class="circle">A</button>
					</li>
					<li>
						<button class="circle">A</button>
						<div class="max">
							<h6 class="small">Headline</h6>
							<div>Supporting text</div>
						</div>
						<label>+15 min</label>
						<button class="circle">A</button>
					</li>
				</ul>
			</fieldset>
		
			<fieldset class="product-primart fieldset field-cyan required max">
				<legend>複合店料號</legend>
				<ul class="list border">
					<li>
						<button class="circle">A</button>
						<div class="max">
							<h6 class="small">Headline</h6>
							<div>Supporting text</div>
						</div>
						<label>+15 min</label>
						<button class="circle">A</button>
					</li>
					<li>
						<button class="circle">A</button>
						<div class="max">
							<h6 class="small">Headline</h6>
							<div>Supporting text</div>
						</div>
						<label>+15 min</label>
						<button class="circle">A</button>
					</li>
				</ul>
			</fieldset>		</div>
		
		<nav class="toolbar">
			<button type="button" class="button btn-save btn-primary">{{ $viewModel->action->label()}}</button>
			<button type="button" class="button btn-cancel border" id="btnReset">重置</button>
		</nav>
	</section>
</form>
@endsection