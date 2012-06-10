
$(function(){
	//validation
	Login.validateLoginForm();
	
	//listeners
	$('#loginButton').bind('click', function(){ $('#loginForm').submit();  });
	
	
	
});


var Login = {
		
		validateLoginForm: function(){
			try {
				
				return $('#loginForm').validate({
					rules : {
						password: {
							required: true,
							minlength: 6
						},
						email: {
							required: true,
							email: true
						}
					},
					wrapper: "span",
					errorClass: "formErrorMessage"
				});
								
			} catch(e){
				alert(e.message);
			}
		},
		
		errorHandler: function(e){
			try {
				$('#errorMessage').text(e);
				$('#error').show();
			} catch(ex){
				alert(ex.message);
			}
		}
		
		
}