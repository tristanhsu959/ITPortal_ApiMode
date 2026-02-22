
<header x-data='app.actionBar(@json($initData))' class="top-nav">
	<nav>
		<a :href="backUrl" x-show="showBack" class="nav-back button circle transparent">
			<i>arrow_back</i>
		</a>
		<h6 class="max nav-breadcrumb" x-html="breadcrumb"></h6>
		<a href="{{ route('home') }}" x-show="! isHome" class="circle small button small-elevate btn-home"><i>home</i></a>
		<a type="button" class="circle small button small-elevate btn-profile" data-ui="#profile"><i>person</i></a>
	</nav>
</header>
