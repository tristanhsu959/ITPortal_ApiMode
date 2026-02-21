
<header class="top-nav">
	<nav>
		<a href="{{ $getRoute() }}" class="nav-back button circle transparent {{ $active() }}">
			<i>arrow_back</i>
		</a>
		<h6 class="max nav-breadcrumb">{!! $renderBreadcrumb !!}</h6>
		<a href="{{ route('home') }}" class="circle small button small-elevate btn-home"><i>home</i></a>
		<a type="button" class="circle small button small-elevate btn-profile" data-ui="#profile"><i>person</i></a>
		@yield('navAction')
	</nav>
</header>
