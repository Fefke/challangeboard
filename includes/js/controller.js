
//Funktionen
function show_element(id, showelement) {
	
	switch (showelement) {
		case true:
			document.getElementById( id ).style.display = 'inline';
		break;
		case false:
			document.getElementById( id ).style.display = 'none';
		break;
	}
}

$( document ).ready(function() {
	setTimeout(function(){
				show_element('beta_info', false);
				$( "#beta_info" ).animate({
					opacity: 0.8,
					height: "toggle"
				}, 600);
	}, 800);
	setTimeout(function(){
				show_element('beta_info', true);
				$( "#beta_info" ).animate({
					opacity: 0.0,
					height: "toggle"
				}, 600);
	}, 10000);		$( "#newpasswd, #newpasswd2" ).change(function() {		var newpasswd = $( "#newpasswd" );		var newpasswd2 = $( "#newpasswd2" );		console.log(newpasswd);		if (newpasswd.value !== newpasswd2.value) {			console.log("nied gleicH!");		}			});		
});
