

function addRow() {
	var highest_id = $('#board tr').length;
	var sys_id = $( '.boardids' ).last().val();
	sys_id = parseInt(sys_id) + 1;
	$('.board tr:last').after('<tr class="jqadded"><td><input class="boardids" type="hidden" name="id[]" value="' + sys_id + '"/>' + highest_id + '</td><td><input class="bes" type="text" name="bes[]"/></td><td><input class="pkt" type="number" min="0" name="pkt[]" /></td><td><input class="name" type="text" name="name[]" /></td></tr>');
	
	$("html, body").animate({ scrollTop: $(document).height() }, 100);
	console.log("Reihe: " + highest_id + " hinzugefügt | Sys:" + sys_id);
	
	if (highest_id >= 3) {
		$( "#delete" ).prop( "disabled", false );
	}
}



function deleterow() {
	var highest_id = $('#board tr').length;
	var jqaddedquests = $('.jqadded').length;
	
	var higest_fix_id = highest_id - jqaddedquests;
	//Entfernen der Reihe
	$('.jqadded:last').remove();
	
	//higest_fix_id = higest_fix_id - 1;
	if (jqaddedquests <= 1) {
		$( '#delete' ).prop("disabled", true);
	}

}



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

function disable(id, was) {
	$( id ).prop( "disabled", was );
}



$( document ).ready(function() {
	//Reset des löschenbuttons
	var jqaddedquests = $('.jqadded').length;
	if (jqaddedquests <= 1) {
		$( '#delete' ).prop("disabled", true);
	}
	
	var sys_id = $( '.boardids' ).last().val();	
	
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
	}, 10000);
	
	
	
//Passwort Check Einheit + diable Funktion oben
	$( "#newpasswd, #newpasswd2" ).on("change keyup paste", function() {
		var newpasswd = $( "#newpasswd" ).val();
		var newpasswd2 = $( "#newpasswd2" ).val();
		var newpasswdlen = newpasswd.length;
		
		if (newpasswd !== newpasswd2) {
			$( ".passwdzukurzinfo" ).remove();
			disable("#passwordsubmit", true);
			
			//Alte Klassenentfernen
			$( "#newpasswd" ).toggleClass( "valid", false );
			$( "#newpasswd2" ).toggleClass( "valid", false );
			
			//Neue Klassen Hinzufügen
			$( "#newpasswd" ).toggleClass( "error", true );
			$( "#newpasswd2" ).toggleClass( "error", true );
			
			
		} else if (newpasswdlen < 4){
			$( ".passwdzukurzinfo" ).remove();
			$( '<br><p class="passwdzukurzinfo" style="color: red;font-weight:bold;">Das Passwort muss mindestens 4 Zeichen lang sein!</p>' ).insertAfter( "#newpasswd2" );
			disable("#passwordsubmit", true)
			
			//Alte Klassenentfernen
			$( "#newpasswd" ).toggleClass( "valid", false );
			$( "#newpasswd2" ).toggleClass( "valid", false );
			
			//Neue Klassen Hinzufügen
			$( "#newpasswd" ).toggleClass( "error", true );
			$( "#newpasswd2" ).toggleClass( "error", true );
			
			
		} else if (newpasswdlen > 0 && newpasswd === newpasswd2) {
			$( ".passwdzukurzinfo" ).remove();;
			disable("#passwordsubmit", false);
			
			//Alte Klassenentfernen
			$( "#newpasswd" ).toggleClass( "error", false );
			$( "#newpasswd2" ).toggleClass( "error", false );
			
			//Neue Klassen Hinzufügen
			$( "#newpasswd" ).toggleClass( "valid", true );
			$( "#newpasswd2" ).toggleClass( "valid", true );
			
		} else {
			$( ".passwdzukurzinfo" ).remove();
			console.log("Joo [...] dat is ned so gut -> darf nich leer sein!");
			disable("#passwordsubmit", true);
			
			//Alte Klassenentfernen
			$( "#newpasswd" ).toggleClass( "valid", false );
			$( "#newpasswd2" ).toggleClass( "valid", false );
			
			//Neue Klassen Hinzufügen
			$( "#newpasswd" ).toggleClass( "error", true );
			$( "#newpasswd2" ).toggleClass( "error", true );
		}
	});


});