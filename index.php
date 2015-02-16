<?php
header('Content-Type: text/html; charset=UTF-8'); 
echo "<pre>";

require_once "simplehtmldom/simple_html_dom.php";


$lohko = 1;
$kuvioalku = 102;
$kerrallaan = 5;

$loppu = $kuvioalku + $kerrallaan;

for ($i = $kuvioalku; $i <= $loppu; $i++)
{
	echo "\n";
	$url = "http://maps.ramboll.fi/palaute/kyselyt/espoonmetsat/palaute_nayta_palaute.php?MAPNAME=Espoo1424115647348&id=$lohko&panel=map&kuvio=$i"; 
	echo "$lohko\t";
	echo "$i\t";

	$client = curl_init($url);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec($client);
	curl_close($client);

	$html = str_get_html($response); 

	$table = $html->find('table', 0);
	if (! is_object($table))
	{
		continue;
	}

	// RIVIT
	foreach($table->find('tr') as $row)
	{
		$name = $row->find('td', 0)->plaintext;
		$value = $row->find('td', 1)->plaintext;
		echo trim($value) . "\t";
	}
}


?>