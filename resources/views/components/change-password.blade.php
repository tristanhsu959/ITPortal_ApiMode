
<dialog class="left" id="changePassword">
	<header>
		<nav>
			<h6 class="max">設定系統驗證密碼</h6>
			<button class="transparent circle large" data-ui="#changePassword"><i>close</i></button>
		</nav>
	</header>
	<div class="space"></div>
	<div class="dialog-body">
		<form x-data='app.chgPassword(@json($initData))' @submit.prevent="submit" novalidate>
			<h6 x-text="userName"></h6>
			<div class="field label border field-orange" :class="util.hasError(errors, 'oldPassword')">
				<input type="password" x-model="formData.oldPassword" @input="errors.delete('oldPassword')"  maxlength="20" required>
				<label>輸入舊密碼</label>
			</div>
			<div class="field label border field-orange" :class="util.hasError(errors, 'newPassword')">
				<input type="password" x-model="formData.newPassword" @input="errors.delete('newPassword')"  maxlength="20" required>
				<label>輸入新密碼</label>
				<output>數字+英文，六個字元以上</output>
			</div>
			<div class="field label border field-orange" :class="util.hasError(errors, 'confirmPassword')">
				<input type="password" x-model="formData.confirmPassword" @input="errors.delete('confirmPassword')"  maxlength="20" required>
				<label>確認新密碼</label>
			</div>
			<nav class="toolbar">
				<button type="submit" class="button btn-save btn-primary">儲存</button>
				<button type="button" class="button btn-cancel border" @click="reset">重置</button>
			</nav>
		</form>
	</div>
</dialog>