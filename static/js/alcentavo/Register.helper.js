
$(function(){
	//validation
	Register.validateRegisterForm();
	
	//listeners
	$('#registerButton').bind('click', function(){ $('#registerForm').submit();  });
	
	
	
});


var Register = {
		
		validateRegisterForm: function(){
			try {
				
				return $('#registerForm').validate({
					rules : {
						name: {
							required: true,
							minlength: 4/*,
							remote: {
					        	url: "ws/wsCheckUsername.json.php",
					        	type: "post",
					        	data: {
					          			username: function() {
					            			return $("#username").val();
					          			}
					        	}
							}*/
						},
						password: {
							required: true,
							minlength: 6
						},
						confirmPassword: {
							required: true,
							equalTo: '#password'
						},
						email: {
							required: true,
							email: true
						}
					},
					wrapper: "span",
					errorClass: "formErrorMessage",
					submitHandler: function(form) {
						Register.submit();
					}
				});
								
			} catch(e){
				alert(e.message);
			}
		},
		
		submit : function(){
			try {
				var values = {
					'name' : $('#name').val(),
					'email' : $('#email').val(),
					'password' : $('#password').val()		
				}
				
				jQuery.ajax({
					url: 'ws/users/wsRegister.json.php',
					dataType: 'json',
					type: 'POST',
					data: values,
					success: function(resultado,statuss){
						if(!resultado.result.error){
							$('#form').hide();
							$('#confirmation').show();
						} else {
							Register.errorHandler(resultado.result.description);
							$('#registerButton').show();
							$('#registerFormLoading').hide();
							//Register.errorHandler(resultado.result.description);
						}
					},					
					error: function(a,e){
						Register.errorHandler(e.message);
						$('#registerButton').show();
						$('#registerFormLoading').hide();
					},
					beforeSend:function(){
						$('#registerButton').hide();
						$('#registerFormLoading').show();
					}
				});
				
			} catch (e){
				Register.errorHandler(e.message);
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