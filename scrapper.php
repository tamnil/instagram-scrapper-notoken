<?php
function curl_download($Url) {

	$tmpfname = dirname(__FILE__) . '/cookie.txt';
	if (!function_exists('curl_init')) {
		die('cURL is not installed. Install and try again.');
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_COOKIEJAR, $tmpfname);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $tmpfname);
	curl_setopt($ch, CURLOPT_URL, $Url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);

	return $output;
}

$name="coryrichards";

$test = curl_download("https://www.instagram.com/".$name.'/');
$pattern = '/window._sharedData.*;/';
preg_match($pattern, $test, $matches, PREG_OFFSET_CAPTURE, 3);
$temp = $matches[0];
$i=substr_replace($temp[0],'',0,20);
$i=substr_replace($i,'',strlen($i)-1,20);
$json=json_decode($i);
$media=$json->entry_data->ProfilePage[0]->user->media->nodes;

//var_dump($media);
foreach($media as $var){
echo '<img src="'.$var->display_src.'" />';
echo '<br>';
echo $var->caption;
echo '<br>';
}
