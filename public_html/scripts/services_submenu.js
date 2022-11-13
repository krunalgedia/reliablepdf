function myFunction() {
var x = document.getElementById("menu_bar_id");
if (x.className === "menu_bar") {
	x.className += " responsive";
		} else {
		x.className = "menu_bar";
		}
}
function list_services() {
	document.getElementById("services_submenu").classList.toggle("show");
		 
}
// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
	if (!event.target.matches('.services_button')) {
		var dropdowns = document.getElementsByClassName("services_submenu");
		var i;
		for (i = 0; i < dropdowns.length; i++) {
			var openDropdown = dropdowns[i];
			if (openDropdown.classList.contains('show')) {
				openDropdown.classList.remove('show');
			}
		}
	}
}