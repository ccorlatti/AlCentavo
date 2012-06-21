
$(function(){
	//validation
	//Register.validateRegisterForm();
	
	//listeners
	//$('#registerButton').bind('click', function(){ $('#registerForm').submit();  });
	
	
	
});


var AccountManagment = {
		
		loadBanks: function(country){
			
			try {
				
				var values = { "country" : country };
				
				jQuery.ajax({
					url: 'ws/generic/wsGetEnabledBanks.json.php',
					dataType: 'json',
					type: 'POST',
					data: values,
					success: function(resultado,statuss){
						if(!resultado.result.error){
							AccountManagment.fillBankCombo(resultado.response);
						} else {
							AccountManagment.errorHandler(resultado.result.description);
						}
						$('#bankLoading').hide();
					},
					error: function(a,e){
						AccountManagment.errorHandler('ERROR: ' + e.message + a);
						$('#bankLoading').hide();
					},
					beforeSend:function(){
						$('#bankLoading').show();
					}
				});		
				
				
			} catch(e){
				AccountManagment.errorHandler(e.message);
			}
			
		},
		
		fillBankCombo: function(rs){
			try {
				$('#bank').empty();
				for(var i=0; i<rs.length; i++){
					
					description = rs[i].Country.short_name + ' - ' + rs[i].description;
					idBank = rs[i].id;
					
					className = rs[i].import == '1' ? 'import' : 'noImport';
					
					$('#bank')
						.append($('<option class="' + className + '">', { idBank : description })
						.text(description)); 
				}
				$('#bank').change();
				
			} catch (e) {
				AccountManagment.errorHandler(e.message);
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