var fileInput_pdfpng = document.getElementById("pdf_to_png_submit").value;
var fileInput_pdfjpg = document.getElementById("pdf_to_jpeg_submit").value;
var fileInput_pngjpg = document.getElementById("png_to_jpeg_submit").value;
var fileInput_pngpdf = document.getElementById("png_to_pdf_submit").value;
var fileInput_jpgpdf = document.getElementById("jpeg_to_pdf_submit").value;
var fileInput_jpgpng = document.getElementById("jpeg_to_png_submit").value;
var fileInput_mergepdf = document.getElementById("mergepdf_submit").value;
var fileInput_compresspdf = document.getElementById("compresspdf_submit").value;
var fileInput_splitpdf = document.getElementById("splitpdf_submit").value;
var fileInput_grayscalepdf = document.getElementById("grayscalepdf_submit").value;

var progess_text = '\nPlease wait! \nConverting & downloading...';

function pdf_to_png_progress(){
	document.getElementById('pdf_to_png_submit').value = fileInput_pdfpng.concat(progess_text);
	return true;
}					

function pdf_to_jpeg_progress(){
	document.getElementById('pdf_to_jpeg_submit').value = fileInput_pdfjpg.concat(progess_text);
	return true;
}			

function png_to_jpeg_progress(){
	document.getElementById('png_to_jpeg_submit').value = fileInput_pngjpg.concat(progess_text);
	return true;
}			

function png_to_pdf_progress(){
	document.getElementById('png_to_pdf_submit').value = fileInput_pngpdf.concat(progess_text);
	return true;
}			

function jpeg_to_pdf_progress(){
	document.getElementById('jpeg_to_pdf_submit').value = fileInput_jpgpdf.concat(progess_text);
	return true;
}			

function mergepdf_progress(){
	document.getElementById('mergepdf_submit').value = fileInput_mergepdf.concat(progess_text);
	return true;
}			
function compresspdf_progress(){
	document.getElementById('compresspdf_submit').value = fileInput_compresspdf.concat(progess_text);
	return true;
}			
function jpeg_to_png_progress(){
	document.getElementById('jpeg_to_png_submit').value = fileInput_jpgpng.concat(progess_text);
	return true;
}			
function splitpdf_progress(){
	document.getElementById('splitpdf_submit').value = fileInput_splitpng.concat(progess_text);
	return true;
}			
function grayscalepdf_progress(){
	document.getElementById('grayscalepdf_submit').value = fileInput_grayscalepdf.concat(progess_text);
	return true;
}			



function pdf_to_png_clear(){
	document.getElementById('pdf_to_png_submit').value = fileInput_pdfpng.replace(progess_text,'');
	return true;
}	

function pdf_to_jpeg_clear(){
	document.getElementById('pdf_to_jpeg_submit').value = fileInput_pdfjpg.replace(progess_text,'');
	return true;
}			

function png_to_jpeg_clear(){
	document.getElementById('png_to_jpeg_submit').value = fileInput_pngjpg.replace(progess_text,'');
	return true;
}			

function png_to_pdf_clear(){
	document.getElementById('png_to_pdf_submit').value = fileInput_pngpdf.replace(progess_text,'');
	return true;
}			

function jpeg_to_pdf_clear(){
	document.getElementById('jpeg_to_pdf_submit').value = fileInput_jpgpdf.replace(progess_text,'');
	return true;
}			

function mergepdf_clear(){
	document.getElementById('mergepdf_submit').value = fileInput_mergepdf.replace(progess_text,'');
	return true;
}			
function compresspdf_clear(){
	document.getElementById('compresspdf_submit').value = fileInput_compresspdf.replace(progess_text,'');
	return true;
}			
function jpeg_to_png_clear(){
	document.getElementById('jpeg_to_png_submit').value = fileInput_jpgpng.replace(progess_text,'');
	return true;
}			
function splitpdf_clear(){
	document.getElementById('splitpdf_submit').value = fileInput_splitpdf.replace(progess_text,'');
	return true;
}			
function grayscalepdf_clear(){
	document.getElementById('grayscalepdf_submit').value = fileInput_grayscalepdf.replace(progess_text,'');
	return true;
}			

