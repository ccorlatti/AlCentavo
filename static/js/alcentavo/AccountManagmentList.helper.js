
$(function(){
	
});


var AccountManagmentList = {
		
		deleteAccount: function(idAccount){
			bootbox.dialog("<h3>Cuidado! esta accion es irreversible.</h3><p>Al borrar una cuenta tambien desapareceran todos los movimientos y datos relacionados a esta.</p>", [{
		        "label" : "Cancelar y volver",
		        "class" : "btn-success",
		        "icon"  : "icon-ok-sign icon-white",
		    }, {
		        "label" : "Estoy seguro, eliminar cuenta!",
		        "class" : "btn-danger",
		        "icon"  : "icon-warning-sign icon-white",
		        "callback": function(){
					var values = {
							'idAccount': idAccount,
							'action': 'delete'
						}
						
					jQuery.ajax({
						url: 'ws/accounting/wsAccountManagment.json.php',
						dataType: 'json',
						type: 'POST',
						data: values,
						success: function(resultado,statuss){
							if(!resultado.result.error){
								$('#confirmationDelete').show();
							} else {
								AccountManagment.errorHandler(resultado.result.description);
							}
							$('.actionLoading').hide();
							
							$('#row-' + idAccount).remove();
						},					
						error: function(a,e){
							var msg = e.message ? e.message : a.statusText;
							AccountManagment.errorHandler(msg);
							$('.actionLoading').hide();
						},
						beforeSend:function(){
							$('.actionLoading').show();
						}
					});		        	
		        }
		    }],{ "onEscape": function() {
            }});
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