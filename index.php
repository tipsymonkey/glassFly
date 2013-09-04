<?php

require_once 'config.php';

function getSigniture ($input_url)
{
	$time_stamp = getTimeStamp();
	$base_string = $sfly_shared_secret.$input_url."&oflyHashMeth=MD5&oflyTimestamp=".$time_stamp;
	return md5($base_string);

}


function getTimeStamp ()
{
		$date =	new DateTime();
        // Using format 'c' will do the right ISO date format needed. 
		return $date->format('c');
}

function curl_post($url,$post_xml)
{


  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $post_xml);
  curl_setopt($curl, CURLOPT_HEADER, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec ($curl);
  curl_close ($curl);

  
  return $response;

}

// Returns the sfly auth token
// Takes user email address and password. 

function sflyAuthUser($user_email, $user_password)
{
  // Pull the appid and the base url from the config.php
  global $sfly_app_id, $sfly_base_url;
  $auth_url = "/user/".$user_email."/auth?oflyAppId=".$sfly_app_id;
  $url = $sfly_base_url.$auth_url;
 

  $curl_response = curl_post($url,writeXML($user_password));
  echo $curl_response;


}


// writeXML
// Returns a string with the xml requested to post in body

function writeXML($user_password)
{
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


sflyAuthUser('raf@test94.com','test123');



?>
