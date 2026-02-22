@extends('layouts.app')

@push('styles')
    <link href="{{ asset('styles/product/list.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('scripts/product/list.js') }}" defer></script>
@endpush

@section('content')

@if($viewModel->status() === TRUE && $viewModel->hasPermission())
	<form action="" method="post" id="productForm" class="no-margin">@csrf</form>

	<header class="page-nav">
		<nav>
			<a href="{{ route('product.create.get') }}" class="btn-create button circle">
				<i>add</i>
			</a>
		</nav>
	</header>
	
	<section class="group-list">
		<ul class="list border">
			<li>
				<details>
					<summary>Headline</summary>
					<ul class="list border">
						<li>子項目 A</li>
						<li>子項目 B</li>
					</ul>
				</details>
				<!-- 放在Detail之後才能trigger on click -->
				<button class="btn-edit">Button</button>
			</li>
			<li>
				<details>
					<summary>Headline</summary>
					<ul class="list border">
						<li>子項目 A</li>
						<li>子項目 B</li>
					</ul>
				</details>
				<!-- 放在Detail之後才能trigger on click -->
				<button class="btn-edit">Button</button>
			</li>
			<li>
				<details>
					<summary>Headline</summary>
					<ul class="list border">
						<li>子項目 A</li>
						<li>子項目 B</li>
					</ul>
				</details>
				<!-- 放在Detail之後才能trigger on click -->
				<button class="btn-edit">Button</button>
			</li>
		</ul>
	</section>
@endif <!-- Status -->

@endsection