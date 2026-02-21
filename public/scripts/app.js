/* App JS */

window.app = {
	init(msg) {
		if (! util.isEmpty(msg))
			util.notify(msg);
	},
	actionBar(initData) {
		return {
			breadcrumb: initData.breadcrumb,
			backUrl: initData.backUrl,
			showBack: (initData.backUrl) ? true : false,
			isHome: initData.isHome,
		}
	},
	profile(initData) {
		return {
			displayName: initData.displayName,
			company: initData.adCompany,
			department: initData.adDepartment,
			employeeId: initData.adEmployeeId,	 
			mail: initData.adMail, 		 
		}
    },
	chgPassword(initData) {
		return {
			formData: {
				userId: initData.userId,
				oldPassword: '',
				newPassword: '',
				confirmPassword: '',
			},
			userName: initData.userName,
			apiUrl: initData.apiUrl,
			errors: new Set(),
			isLoading: false,

			async submit() {
				try 
				{
					this.errors.clear();
					
					if (util.isEmpty(this.formData.oldPassword))
						this.errors.add('oldPassword');
					if (util.isEmpty(this.formData.newPassword))
						this.errors.add('newPassword');
					if (util.isEmpty(this.formData.confirmPassword))
						this.errors.add('confirmPassword');
					
					if (this.errors.size > 0)
						return false;
					
					if (! util.isPasswordFormat(this.formData.newPassword))
					{
						this.errors.add('newPassword');
						util.notify('新密碼格式錯誤');
					}
					
					if (this.formData.newPassword != this.formData.confirmPassword)
					{
						this.errors.add('confirmPassword');
						util.notify('新密碼與確認密碼輸入不符');
					}
					
					if (this.errors.size > 0)
						return false;
					
					const response = await axios.put(this.apiUrl, this.formData);
						
					if (response.data.status === true)
					{
						util.notify('密碼設定完成，已啟用系統驗證登入模式');
						this.reset();
					}
					else
						util.notify(response.data.msg);
				} 
				catch (e) 
				{
					console.error("API change password 呼叫失敗", e);
				} 
				finally 
				{
					this.isLoading = false;
				}
			},
		
			async reset() {
				this.formData.oldPassword = '';
				this.formData.newPassword = '';
				this.formData.confirmPassword = '';
				this.errors.clear();
				this.isLoading = false;
			}
		}
    }
}
