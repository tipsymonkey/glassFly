<?php

require_once 'config.php';

function getSigniture ($input_url) {
	$time_stamp = getTimeStamp();
	$base_string = $sfly_shared_secret.$input_url."&oflyHashMeth=MD5&oflyTimestamp=".$time_stamp;
	return md5($base_string);
}


function getTimeStamp () {
		$date =	new DateTime();
        // Using format 'c' will do the right ISO date format needed. 
		return $date->format('c');
}

function curl_post($url,$post_xml) {


  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $post_xml);
  curl_setopt($curl, CURLOPT_HEADER, false); //Turn off  headers in the response. 
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec ($curl);
  curl_close ($curl);

  
  return $response;
}

// Returns the sfly auth token
// Takes user email address and password. 

function sflyAuthUser($user_email, $user_password) {
  // Pull the appid and the base url from the config.php
  global $sfly_app_id, $sfly_base_url;
  $auth_url = "/user/".$user_email."/auth?oflyAppId=".$sfly_app_id;
  $url = $sfly_base_url.$auth_url;
 

  $curl_response = curl_post($url,writeXML($user_password));
  $entry = new SimpleXMLElement($curl_response);
  $user = $entry->children("user",TRUE);

  return $user->newAuthToken;
}


// writeXML
// Returns a string with the xml requested to post in body

function writeXML($user_password) {
$dom = new DOMDocument('1.0','UTF-8');

$element = $dom->createElementNS('http://www.w3.org/2005/Atom','entry');
$element->setAttribute('xmlns:user','http://user.openfly.shutterfly.com/v1.0');
$dom->appendChild($element);

$category = $element->appendChild($dom->createElement('category'));
$category->setAttribute('term','user');
$category->setAttribute('scheme','http://openfly.shutterfly.com/v1.0');
$category->appendChild($dom->createTextNode(''));

$userpass = $element->appendChild($dom->createElement('user:password',$user_password));

return $dom->saveXML();
}




 $response = sflyAuthUser('raf@test94.com','test123');
 //echo $response;


$img = imagecreatefromjpeg('test.jpeg');

$postdata = array(
    'AuthenticationID' => $response,
    'Image.AlbumName' => 'Glass Upload',
    'Image.Data' => '@/Users/ravasquez/Sites/glassFly/test.jpeg'
);






// $srand = substr(md5(rand(0,32000)),0,10);
// $boundary_eol = "\r\n";
// $aform =  "----".$srand.$boundary_eol;
 
// $submitdata = $aform;
// $submitdata .= "Content-Disposition: form-data; name=\"AuthenticationID\"\r\n\r\n";
// $submitdata .= "$response";
// $submitdata .= "\r\n".$aform;
// $submitdata .= "Content-Disposition: form-data; name=\"Image.AlbumName\"".$boundary_eol.$boundary_eol;
// $submitdata .= "Glass Upload";
// $submitdata .= $boundary_eol.$aform;
// $submitdata .= "Content-Disposition: form-data; name=\"Image.Data\"; filename=\"test.jpeg\"".$boundary_eol.$boundary_eol;
// $submitdata .= "Content-Type: image/jpeg"."\r\n";
// $submitdata .= $img_test['file'];
// $submitdata .= "\r\n"."----$srand"."--\r\n";

//$postdata = $submitdata;
$posturl = "http://up3.shutterfly.com/images?".$sfly_app_id;

echo $submitdata;
 $ch = curl_init($posturl);
 //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "Content-Type: multipart/form-data");
 curl_setopt($ch, CURLOPT_POST      ,1);
 curl_setopt($ch, CURLOPT_POSTFIELDS    ,$postdata);
 // curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,0);
 // curl_setopt($ch, CURLOPT_COOKIE,  $mycookies);
 curl_setopt($ch, CURLOPT_HEADER      ,1);  // DO NOT RETURN HTTP HEADERS
 curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
 $return = curl_exec($ch);
 curl_close($ch);
 echo "<p>-----Return:<p>".$return;




?>
