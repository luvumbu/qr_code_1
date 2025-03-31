<?php

session_start() ; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<style>
    body{
        position: absolute;
        background-color: black;
    }
</style>

<?php 

/*
 * PHP QR Code encoder
 *
 * Exemplatory usage
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */


/*
var_dump($_POST['level']);

var_dump($_POST['size']);
var_dump($_POST['data']);

*/

  
 

 

$id_sha1_projet =  $_SESSION["id_sha1_projet"] ; 
$id_sha1_projet_name =   $_SERVER['SERVER_NAME'].'/qr_scan.php/'.$_SESSION["id_sha1_projet"] ; 

 

 

//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;

//html PNG location prefix
$PNG_WEB_DIR = 'temp/';
 


include "qrlib.php";

//ofcourse we need rights to create temp dir
if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);


$filename = $PNG_TEMP_DIR . $id_sha1_projet.'.png';

//processing form input
//remember to sanitize user input in real-life solution !!!
$errorCorrectionLevel = 'L';
if (isset($_POST['level']) && in_array($_POST['level'], array('L', 'M', 'Q', 'H'))) {
    $errorCorrectionLevel = $_POST['level'];
}

$matrixPointSize = 4;
if (isset($_POST['size'])) {
    $matrixPointSize = min(max((int)$_POST['size'], 1), 10);
}

// Get data from POST or GET
$qrData = '';
if (isset($_POST['data'])) {
    $qrData = $_POST['data'];
} elseif (isset($_GET['data'])) {
    $qrData = $_GET['data'];
}

if (!empty($qrData)) {
    //it's very important!
    if (trim($qrData) == '') {
        die('data cannot be empty! <a href="?">back</a>');
    }

    // user data
    $filename = $PNG_TEMP_DIR . 'test' . md5($qrData . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
    QRcode::png($qrData, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
} else {
    //default data
    QRcode::png($id_sha1_projet_name, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
}

//display generated file
 

//config form
 
 
 

// benchmark
QRtools::timeBenchmark();


?>




<meta http-equiv="refresh" content="0; URL=../index.php" />
</body>


</html>