<?php




require_once 'config.php';

function getSigniture ($input_url)
{
	$time_stamp = getTimeStamp();
	$base_string = $sfly_shared_secret.$input_url."&oflyHashMeth=MD5&oflyTimestamp=".@time_stamp;
	return md5($base_string);

}


function getTimeStamp ()
{
		$date =	new DateTime();
        // Using format 'c' will do the right ISO date format needed. 
		return $date->format('c');
}
/*
    This is going to be debug section stuff. This doens't need to exist / only for now. 
*/


//Create hard codeded xml

$xmlstr = <<< XML
<?xml version="1.0" encoding="UTF-8"?>
<entry xmlns="http://www.w3.org/2005/Atom" xmlns:user="http://user.openfly.shutterfly.com/v1.0">
  <category term="user" scheme="http://openfly.shutterfly.com/v1.0" />
  <user:password>sNf86VJG6N</user:password>
</entry>
XML;


$auth_url = "/user/ravasquez@shutterfly.com/auth?oflyAppId=".$sfly_app_id;






$url = $sfly_base_url.$auth_url;


$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlstr);
curl_setopt($curl, CURLOPT_HEADER, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec ($curl);
curl_close ($curl);

echo $response;

?>
