/* App JS */

document.addEventListener('alpine:init', () => {
	Alpine.store('toast', {
		init() {
            if (window.phpSession && window.phpSession.message) {
                // 延遲一小段時間確保 DOM 與 BeerCSS 完全就緒
                setTimeout(() => {
                    this.notify(window.phpSession.message);
                }, 100);
            }
        },
		
		notify(message, status = false) {
			if (window.ui) {
				const el = document.querySelector('#notifyMsg');
				const msgEl = el.querySelector('.message');
				const colorClass = (status == true) ? 'green' : 'error';
				
				//Set or reset to empty
				el.classList.remove('green', 'error', 'white-text');
				msgEl.innerText = message;
				el.classList.add(colorClass, 'white-text');
				
				if (message != '')
					ui('#notifyMsg');
			}
		},
	});
		/* viewMode: {
			isLoginView: false,
			classMode: 'app',
		}, */
		
		/* init(isLogin) { console.log(1);
			this.isLogin = isLogin;
			this.mode = (isLogin == true) ? 'login' : 'app';
			
			this.$watch('notify.message', (val) => {
				console.log('🔔 $watch 偵測到值:', val);
				if (val && val.trim() !== '') {
					// 呼叫你的工具類
					if (typeof util !== 'undefined' && util.notify) {
						util.notify(val);
					} else {
						console.error('找不到 util.notify 函式');
					}
				}
			});
		}, */
	
        /* modal: { active: false, title: '', content: '' },
        toast: { active: false, msg: '' },
        
        showModal(title, content) {
            this.modal = { active: true, title, content };
        },
        showToast(msg) {
            this.toast = { active: true, msg };
            setTimeout(() => this.toast.active = false, 3000);
        }, */
		
    
});

/* window.app = {
	notify: {
		message: ''
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
} */
