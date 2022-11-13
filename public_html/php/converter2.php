<?php
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new mPDF();

// Write some HTML code:

$mpdf->WriteHTML('<h1>Hello World</h1><br><p>My first PDF with mPDF</p>');

// Output a PDF file directly to the browser
$mpdf->Output();
?>