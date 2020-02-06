<?php 
//speakerbot backend. this plays audio via a python script on the server (usually something like a raspberry pi)
//i've tried to keep all the code vanilla and old school
//gus mueller, july 12 2019
//////////////////////////////////////////////////////////////
 
 
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


$file = "";
$blob = "";
$mode = "";

if($_REQUEST && $_REQUEST["file"]) {
	$file = $_REQUEST["file"];
}
  
if($_POST) {
	$blob = base64_decode(str_replace('^', '+', str_replace("~", "/", $_POST['blob']))); //OMG THESE FUCKING REPLACEMENTS!!!
}


$date = new DateTime("now", new DateTimeZone('America/New_York') );
//$formatedDateTime =  $date->format('m-d H:i');
$formatedDateTime =  $date->format('H:i');

if($_REQUEST && $_REQUEST["mode"]) {
	$mode = $_REQUEST["mode"];
	if($mode=="kill") {
	
	} else if ($mode=="getTemperature") {
		$command = escapeshellcmd('sudo python 75a.py');
		ob_start();
		passthru($command);
 		$output = trim(ob_get_contents());
		ob_end_clean();
		$celsius = floatval($output);
		$farenheit = ($celsius * 9/5) + 32;
		$objOut = array("temperature"=>$farenheit, "time"=>$formatedDateTime);
		echo json_encode($objOut);
	
		exit;
	} else if ($mode=='browse') { //in case i want to do directory browsing via AJAX
	 
	}
	
	
	
}
 
 
echo '{"message":"done"}';
 