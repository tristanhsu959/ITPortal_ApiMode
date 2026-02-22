/* Login JS */

document.addEventListener('alpine:init', () => {
    Alpine.data('login', () => ({
		formData: {
			account: '',
			password: '',
			authType: 1
		},
		authUrl: '/login',
		homeUrl: '/home',
		errors: new Set(),
		isLoading: false,
		
        init() {
			
        },
		
		async submit() {
			try 
			{
				this.errors.clear();
				
				if (Helper.isEmpty(this.formData.account))
					this.errors.add('account');
				if (Helper.isEmpty(this.formData.password))
					this.errors.add('password');
				
				if (this.errors.size == 0)
				{
					const response = await axios.post(this.authUrl, this.formData);
					
					if (response.data.status === true)
						window.location.href = this.homeUrl;
					else
						Alpine.store('toast').notify(response.data.msg);
				}
				else
					return false;
			} 
			catch (e) 
			{
				Alpine.store('toast').notify("API呼叫失敗", e);
			} 
			finally 
			{
				this.isLoading = false;
			}
		},
		
		async reset() {
			this.formData.account = '';
			this.formData.password = '';
			this.formData.authType = 1;
			this.errors.clear();
			this.isLoading = false;
		}
    }));
});
