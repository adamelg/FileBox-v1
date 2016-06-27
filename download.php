<?php
// ini_set("display_errors",1);

include("connexionsql.php");

$key = $_REQUEST['key'];

$sql = "SELECT * FROM uploader WHERE file_key = '$key'"; 


		$query = $pdo->prepare($sql);
		$query->execute(); 
        $data = $query->fetchAll();



    
    
$size = filesize ( "upload/".$data[0]['file_key']);
header('Content-disposition: attachment; filename="'.$data[0]['filename'].'"'); 
header('Content-Length: '.$size);
readfile("upload/".$data[0]['file_key']); // do the double-download-dance (dirty but worky)

?>  
 