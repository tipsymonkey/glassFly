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
$xmlData = <<< END
    <?xml version="1.0" encoding="UTF-8"?>
<entry xmlns="http://www.w3.org/2005/Atom" xmlns:user="http://user.openfly.shutterfly.com/v1.0">
  <category term="user" scheme="http://openfly.shutterfly.com/v1.0" />
  <user:password>sNf86VJG6N</user:password>
</entry> 
END;


$xmlshit = simplexml_load_string($xmlData);
//Using this for debuging, this will have to be set dynamically in real life. 
$auth_url = "/user/ravasquez@shutterfly.com/auth?oflyAppId=".$sfly_app_id;






$url = $sfly_base_url.$auth_url;

$ch = curl_init();
$curlConfig = array(
    CURLOPT_URL            => $url,
    CURLOPT_POST           => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS     => $xmlshit
);


curl_setopt_array($ch, $curlConfig);
$result = curl_exec($ch);
curl_close($ch);

echo $result;



    $xmlData =<<< END
03
<?xml version="1.0"?>
04
<datas>
05
  <books> 
06
    <book>
07
      <id>1</id>
08
      <title>PHP Undercover</title>     
09
      <author>Wiwit Siswoutomo</author>
10
    </book>
11
  </books>
12
</datas>
13
END;

?>
