<?php

ini_set(Ôdisplay_errorsÕ,1);
error_reporting(E_ALL|E_STRICT);



list($user, $collection) = explode('/', $_GET['q']);
$page = (isset($_GET['p'])) ? $_GET['p'] : 1;
$per_page = 15;
$tag = (isset($_GET['tag'])) ? $_GET['tag'] : false;

//	Temp fix for broken GimmeBar API
$tag = false;


echo gimmeBar($user, $collection, $page, $per_page, $tag);


function gimmeBar($user, $collection, $page, $per_page, $tag) {
	$url = 'https://gimmebar.com/api/v1/public/assets/' . $user . '/' . $collection . '.json';
	if ($tag) {
		$url .= '?tag=' . $tag;
		$per_page = 50;
	}
	else {
		$url .= '?_extension[]=description';
	}
	$url .= '&limit=' . $per_page . '&skip=' . ($per_page * ($page - 1));
//echo $url;
	require_once('phpcache.php');
	$cache = new reallysimple\PhpCache('cache');
	$data = $cache->fetch($url);
	if (!$data) {
		$json = @file_get_contents($url);
		$data = json_decode($json);
		$cache->store($url, $data, 60*5);
		$data->twf_cached = false;
	}
	else {
		$data->twf_cached = true;
	}
	return json_encode($data);
}



?>