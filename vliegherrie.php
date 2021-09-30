<?php

##################################
#
# Vliegherrie Credentials
#
##################################

$username = 'username';
$password = 'password';
$debug = false;

if ( !isset($_GET["melding"]) ) { 
	exit("Geen melding.");
}

$melding = $_GET["melding"];

echo '<html><body>Starting melding!<br>';

## GET COOKIE
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,            "https://vliegherrie.nl/profiel" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POST,           1 );
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__.'/vliegherrie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS,     "name=$username&pass=$password&persistent_login=1&form_id=user_login&op=Inloggen" ); 
curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Referer: https://vliegherrie.nl/','Origin: https://vliegherrie.nl')); 

$result=curl_exec ($ch);
curl_close($ch);
if ($debug) { print $result; }

echo 'Cookie is set if creds were complete.<br>'

## GET FORM
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,            "https://vliegherrie.nl/melding-aanmaken" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1); 
curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Referer: https://vliegherrie.nl/','Origin: https://vliegherrie.nl')); 
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__.'/vliegherrie.txt');

$result=curl_exec ($ch);
curl_close($ch);

if ($debug) { print $result; }

echo 'Retrieved form to get Token.<br>'

# Parse to get form ID
$formid_match = '/(?<=<input type="hidden" name="form_build_id" value=").*?(?=" \/>)/'; 
preg_match($formid_match, $result, $output); // Outputs ID
$formid = array_shift($output);

# Parse to get form Token
$formtoken_match = '/(?<=<input type="hidden" name="form_token" value=").*?(?=" \/>)/';
preg_match($formtoken_match, $result,$output); // Outputs token
$formtoken = array_shift($output);

# field_datum_overlast[und][0][value][day]
$datum_day = date("j");
# field_datum_overlast[und][0][value][month]
$datum_month = date("n");
# field_datum_overlast[und][0][value][year]
$datum_year = date("Y");

# field_datum_overlast[und][0][value][hour]
$datum_hour = date("G");
# field_datum_overlast[und][0][value][minute]
$datum_minute = date("i");

# field_oorzaak[und]
$oorzaak = 'Geluid';

## Post Message
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,            "https://vliegherrie.nl/melding-aanmaken" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POST,           1 );
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__.'/vliegherrie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS,     "changed=&form_build_id=$formid&form_token=$formtoken&form_id=melding_node_form&field_datum_overlast[und][0][value][day]=$datum_day&field_datum_overlast[und][0][value][month]=$datum_month&field_datum_overlast[und][0][value][year]=$datum_year&field_datum_overlast[und][0][value][hour]=$datum_hour&field_datum_overlast[und][0][value][minute]=$datum_minute&field_oorzaak[und]=$oorzaak&field_omschrijving_melding[und][0][value]=$melding&field_postcode[und][0][value]=&field_akkoord_2[und]=Ja&field_info[und][0][value]=&field_lengte[und][0][value]=&field_stad[und][0][value]&op=Opslaan" ); 
curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Referer: https://vliegherrie.nl/','Origin: https://vliegherrie.nl')); 

$result=curl_exec ($ch);

curl_close($ch);

if ($debug) { print $result; }

echo 'Finished melding!';

?>
