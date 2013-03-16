// JavaScript Document
function formhash(form, password){
	//Create a new input, will be the hash password
	var p = document.createElement("input");
	//Add element to the form
	form.appendChild(p);
	p.name = "p";
	p.type = "hidden";
	p.value = hex_sha512(password.value);
	//Make sure we don't send the plain password
	password.value = "";
	//Submit the form
	form.submit();
}