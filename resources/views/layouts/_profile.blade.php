
<dialog x-data='app.profile(@json($initData))' class="left" id="profile">
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
			<p x-text="employeeId"></p>
			<p class="name" x-text="displayName"></p>
			<p class="mail" x-text="mail"></p>
			<button class="transparent circle large btn-chg-password" data-ui="#changePassword">
				<i>settings</i>
				<span class="tooltip left">設定系統驗證密碼</span>
			</button>
		</div>
		<div class="section info-body">
			<p x-text="department"></p>
			<p x-text="company"></p>
		</div>
	</div>
	<a href="{{ route('logout') }}" class="btn-logout button extend circle">
		<i>logout</i>
		<span>登出</span>
	</a>
</dialog>
