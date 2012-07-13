
var Dialog = {

		warning: function(title, msg){
			
			$('<div width=650 height=590 />').dialog({
				modal: true,
				autoOpen: true,
				closeOnEscape: true,
				resizable: true,
	            width: 760,
	            height: 500,
				show:'zoom',
				hide:'blind',
				title: ".: " + title
			}).width(740).height(480);
			
		}
}