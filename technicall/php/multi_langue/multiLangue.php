<?php

if(!isset($_SESSION['langue'])){
    $_SESSION['langue']='fr.lang';
}
if(isset($_POST['langue'])){
    $_SESSION['langue']=$_POST['langue'];
}

$location='../multi_langue/langue';
$fileregex='/.lang$/';

$matchedfiles = array();

$dir = opendir($location);
while ($file = readdir($dir)) {
    if (!is_dir($location.'/'.$file)) {
        if (preg_match($fileregex,$file)) {
            array_push($matchedfiles,$file);
        }
    }
}
closedir($dir);
unset($dir);


include_once ('langue/'.$_SESSION['langue']);