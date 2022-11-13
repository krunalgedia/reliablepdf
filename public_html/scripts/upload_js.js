var dropFileForm  = document.getElementById("dropFileForm");

function overrideDefault(event) {
	event.preventDefault();
	event.stopPropagation();
}

function fileHover() {
	dropFileForm.classList.add("hover");
}

function fileHoverEnd() {
	dropFileForm.classList.remove("hover");
}

var droppedFiles;
var fileLabelText = document.getElementById("fileLabelText");

var files_count = 0;
var my_files = [];

var fileInput = document.getElementById("fileInput");
var formData = new FormData();

function addFiles(event) {
	//droppedFiles = event.target.files || event.dataTransfer.files;
	//showFiles(droppedFiles);
	console.log("now check");
	console.log(event.target.files);
	var files = event.target.files|| event.dataTransfer.files; //FileList object ;
	for(var i = 0; i< files.length; i++)
	{
		//var file = files[i];				
		my_files[files_count]=files[i];
		files_count +=1;
		console.log(my_files);
		console.log(files_count);
		console.log(files[i].name)
		formData.append(files[i].name, files[i], files[i].name);
		console.log(formData);
	}
	showFiles(my_files);
}

function showFiles(files) {
	if (files.length > 1) {
		fileLabelText.innerText = files.length + " files selected";
	} 
	else if (files.length === 0){
		fileLabelText.innerText = "Choose a file or drag it here";	
	}
	else {
		fileLabelText.innerText = files[0].name;
	}
}

var progressBar = document.getElementById("progress_bar");
console.log(progressBar);
function resetProgressBar() {
		  
	progressBar.innerText = "0%";
	progressBar.style.width = "0%";
	console.log(progressBar.innerText);
}

/*
function allSelectedFiles{

var es = document.forms[0].elements;
es[1].onclick = function(){
  clearInputFile(es[0]);
};

    function clearInputFile(f){
        if(f.value){
            try{
                f.value = ''; //for IE11, latest Chrome/Firefox/Opera...
            }catch(err){
            }
            if(f.value){ //for IE5 ~ IE10
                var form = document.createElement('form'), ref = f.nextSibling;
                form.appendChild(f);
                form.reset();
                ref.parentNode.insertBefore(f,ref);
            }
        }
    }
}
*/

function clearFileInput() {
	my_files = [];
	formData = new FormData();
	showFiles(my_files);
	files_count = 0;
	resetProgressBar();
}


/*

function clearFileInput() {
	clear = "yes";
	console.log(clear);
}
*/


/*
var uploadStatus = document.getElementById("uploadStatus");
var fileInput = document.getElementById("fileInput");

function uploadFiles(event) {
event.preventDefault();
changeStatus("Uploading...");

var formData = new FormData();

for (var i = 0, file; (file = my_files[i]); i++) {
formData.append(fileInput.name, file, file.name);
}

var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function(data) {
//handle server response and change status of
//upload process via changeStatus(text)
console.log(xhr.response);
};
console.log(formData);

xhr.open(dropFileForm.method, dropFileForm.action, true);
xhr.send(formData);
}

function changeStatus(text) {
	uploadStatus.innerText = text;
}
*/

/*		
var fileInput = document.getElementById("fileInput");
var formData = new FormData();

for (var i = 0, file; (file = my_files[i]); i++) {
	formData.append(fileInput.name, file, file.name);
}
console.log(formData);
console.log(my_files);
*/

$(document).ready(function(){
		   
	var fileInput = document.getElementById("fileInput");

	// File upload via Ajax
	$("#dropFileForm").on('submit', function(e){
		e.preventDefault();
		$.ajax({
			xhr: function() {
				var xhr = new window.XMLHttpRequest();

				xhr.upload.addEventListener("progress", function(evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						percentComplete = parseInt(percentComplete * 100);
						console.log(percentComplete);
						$('.progress-bar').width(percentComplete+'%');
						$('.progress-bar').html(percentComplete+'%');

						if (percentComplete === 100) {
							console.log(formData);									
						}
					}
				}, false);

				return xhr;
			},
                
		url: "upload.php",
		type: "POST",
		//data: new FormData(this),
		data: formData,
		contentType: false,
		cache: false,
		processData: false,
		//dataType: "json",
		success: function(result) {
			console.log("result is");
			//if result=="numfiles_issue":{
			//}
			if(result.trim().startsWith("Array")){
				fileLabelText.innerText = "Files uploaded!\nClick on one of the option below or add more files here";
				files_count = 0;
			}
			if(!result.trim().startsWith("Array")){
				alert(result);		
			}			
			console.log(result.trim());
			//console.log(data);
			console.log("result printed");
			//alert('New message received');
			
		}
		});
	});

	$("#fileInput").click(function(){
		$('.progress-bar').width('0%');
		$('.progress-bar').html('0%');
	});
		
});




		