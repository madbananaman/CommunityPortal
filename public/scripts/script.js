//To direct to the corresponding profile.php of the user
var email=''; //email of corresponding user
function directToProfile (email){
	window.location.href = "profile.php?email="+email; ;
}

//To enable clicking of the <td> to check/uncheck the checkbox residing in it. userlist.php
var id=''; //id of element
function easyCheckBoxClick(id){
	if (document.getElementById(id).disabled != true){
		document.getElementById(id).checked = !document.getElementById(id).checked
	} else {
		alert(id + ' had unsubscribed to mailing list');
	}
}

function test(email){  
 alert('Element: ' + email);  
}