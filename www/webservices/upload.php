<?php
header("Access-Control-Allow-Origin: *");
header("Cache-Control: no-cache, must-revalidate");

$ds          = DIRECTORY_SEPARATOR;  //1
 
$storeFolder = 'uploads';   //2
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];          //3             
      
    $targetPath = dirname(dirname(__FILE__)) . $ds. $storeFolder . $ds;  //4

    $fileName = time().$_FILES['file']['name'];
     
    $targetFile =  $targetPath.$fileName;  //5
 
    move_uploaded_file($tempFile,$targetFile); //6

    echo $fileName;
     
}