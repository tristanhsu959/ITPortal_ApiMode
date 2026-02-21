<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>八方雲集-IT Portal</title>
		
		<link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
		
		<!-- Styles & Font -->
		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Poiret+One&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
		<link href="https://cdn.jsdelivr.net/npm/beercss@4.0.7/dist/cdn/beer.min.css" rel="stylesheet">
		<link href="{{ asset('styles/include.css') }}" rel="stylesheet" />
		@sectionMissing('signin')
		<link href="{{ asset('styles/app.css') }}" rel="stylesheet" />
		@endif
		
		@stack('styles')
		
		<!-- Scripts -->
		<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script>
		<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous" defer></script>
		<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.min.js" integrity="sha256-Fb0zP4jE3JHqu+IBB9YktLcSjI1Zc6J2b6gTjB0LpoM=" crossorigin="anonymous" defer></script>
		<script type="module" src="https://cdn.jsdelivr.net/npm/beercss@4.0.7/dist/cdn/beer.min.js" defer></script>
		<script type="module" src="https://cdn.jsdelivr.net/npm/material-dynamic-colors@1.1.4/dist/cdn/material-dynamic-colors.min.js" defer></script>
		<script src="{{ asset('scripts/app.js') }}" defer></script>
		
		@stack('scripts')
	</head>

	<body>
		@hasSection('signin')
			<main class="signin responsive">
				@yield('signin')
			</main>	
		@else
			<x-menu />
				
			<main class="app responsive">
				
				<div class='content-wrapper'>
					<x-action-bar :breadcrumb="$viewModel->breadcrumb()" :backRoute="$viewModel->backRoute()"/>
					
					@hasSection('content')
						@yield('content')
					@endif
				</div>
				
				<x-profile />
			</main>
			
			@include('layouts._dialog')
			
		@endif
		
		@include('layouts._toast')
	</body>
</html>
