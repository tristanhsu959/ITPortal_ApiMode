/* Login JS */

window.loginInit = function(initial = []) 
{
    return {
        formData: initial.formData,
		authUrl: initial.authUrl,
		homeUrl: initial.homeUrl,
		errors: new Set(),
		isLoading: false,

        async submit() {
			try 
			{
				this.errors.clear();
				
				if (util.isEmpty(this.formData.account))
					this.errors.add('account');
				if (util.isEmpty(this.formData.password))
					this.errors.add('password');
				
				if (this.errors.size == 0)
				{
					const response = await axios.post(this.authUrl, this.formData);
					
					if (response.data.status === true)
						window.location.href = this.homeUrl;
					else
						util.notify(response.data.msg);
				}
				else
					return false;
            } 
			catch (e) 
			{
                console.error("API呼叫失敗", e);
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
    }
}