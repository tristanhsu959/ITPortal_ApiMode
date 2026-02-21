
<dialog class="left" id="profile">
	<header>
		<nav>
			<h6 class="max">Profile</h6>
			<button class="transparent circle large" data-ui="#profile"><i>close</i></button>
		</nav>
	</header>
	<div class="space"></div>
	<div class="dialog-body">
		<div class="section info-head">
			<i class="fill">person_pin</i>
			<p>{{ $currentUser->employeeId }}</p>
			<p class="name">{{ $currentUser->showAvailableName() }}</p>
			<p class="mail">{{ $currentUser->mail }}</p>
		</div>
		<div class="section info-body">
			<p>
				<span>{{ $currentUser->department }}</span>
				<span>{{ $currentUser->title }}</span>
			</p>
			<p>{{ $currentUser->company }}</p>
		</div>
	</div>
	<a href="{{ route('signout') }}" class="btn-signout button extend circle">
		<i>logout</i>
		<span>登出</span>
	</a>
</dialog>
