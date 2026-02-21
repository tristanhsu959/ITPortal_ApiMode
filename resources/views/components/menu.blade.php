<!-- Menu component -->

<nav class="menu left">
	<div class="header">IT Portal</div>
	<div class="responsive">
		<ul>
			@foreach($menu as $item)
			<li class="{{ $item['style']['width'] }} button square small-elevate">
				<a href="{{ route($item['url']) }}" class="{{ $isActive($item['url']) }}">
					<span class="material-symbols-outlined">{{ $item['style']['icon'] }}</span>
					<span>{{ $item['name'] }}</span>
				</a>
			</li>
			@endforeach
			<li class="w2">
				<a href="#" class="d-test button square small-elevate">
					<span class="material-symbols-outlined"></span>
					<span>Dialog</span>
				</a>
			</li>
			<li class="">
				<a href="" class=" button square small-elevate">
					<span class="material-symbols-outlined"></span>
					<span>UnDefined</span>
				</a>
			</li>
			<li class="">
				<a href="" class=" button square small-elevate">
					<span class="material-symbols-outlined"></span>
					<span>UnDefined</span>
				</a>
			</li>
			<li class="">
				<a href="" class=" button square small-elevate">
					<span class="material-symbols-outlined"></span>
					<span>UnDefined</span>
				</a>
			</li>
		</ul>
	</div>
</nav >