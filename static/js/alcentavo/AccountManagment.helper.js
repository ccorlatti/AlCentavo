
$(function(){
	//load banks
	var check = $('#onlyMyCountry');
	AccountManagment.loadBanks(check.is(':checked') ? check.val() : '')
	
	//listeners
	check.bind('change', function(){
			var check = $('#onlyMyCountry');
			AccountManagment.loadBanks(check.is(':checked') ? check.val() : '');
	});
	
	var banks = $('#bank');
	banks.bind('change', function(){
		$('#bank option:selected').hasClass('noImport') ? $('#noImportBank').show() : $('#noImportBank').hide();
	});
	
	
	AccountManagment.validateAccountForm();
	
	$('#accoundEditSaveButton').bind('click', function(){ $('#accountEditForm').submit();  });	
	
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
						.append($('<option class="' + className + '" value="'+ idBank +'">', { idBank : description })
						.text(description)); 
				}
				$('#bank').change();
				
			} catch (e) {
				AccountManagment.errorHandler(e.message);
			}
		},
		
		validateAccountForm: function(){
			try {
				return $('#accountEditForm').validate({
					rules : {
						accountType: {
							required: true
						},
						bank: {
							required: true
						},
						accountDescription: {
							required: true,
							minlength: 4
						},
						accountInitialBalance: {
							required: false,
							number: true
						}
					},
					wrapper: "span",
					errorClass: "formErrorMessage",
					submitHandler: function(form) {
						$('#action').val('save');
						AccountManagment.submit();
					}
				});				
			} catch (e) {
				AccountManagment.errorHandler(e.message);
			}
		},
		
		submit : function(){
			try {
				var values = {
					'accountType' : $('#accountType').val(),
					'bank' : $('#bank').val(),
					'accountDescription' : $('#accountDescription').val(),
					'accountInitialBalance': $('#accountInitialBalance').val(),
					'action': $('#action').val(),
					'idAccount': $('#idAccount').val(),
					'currency': $('#currency').val()
				}
				
				
				jQuery.ajax({
					url: 'ws/accounting/wsAccountManagment.json.php',
					dataType: 'json',
					type: 'POST',
					data: values,
					success: function(resultado,statuss){
						if(!resultado.result.error){
							$('#accountEditForm').hide();
							$('#confirmation').show();
						} else {
							AccountManagment.errorHandler(resultado.result.description);
							$('#registerButton').show();
							$('#registerFormLoading').hide();
						}
					},					
					error: function(a,e){
						var msg = e.message ? e.message : a.statusText;
						AccountManagment.errorHandler(msg);
						$('.actionButtons').show();
						$('.actionLoading').hide();
					},
					beforeSend:function(){
						$('.actionButtons').hide();
						$('.actionLoading').show();
					}
				});
				
			} catch (e){
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