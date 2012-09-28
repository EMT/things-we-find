<?php




if (isset($_GET['q'])) {
	list($user, $collection) = explode('/', $_GET['q']);
}
else if (isset($_GET['asset'])) {
	$asset_id = $_GET['asset'];
}
$page = (isset($_GET['p'])) ? $_GET['p'] : 1;
$per_page = 15;
$tag = (isset($_GET['tag'])) ? $_GET['tag'] : false;

//	Temp fix for broken GimmeBar API
if ($tag) {
	$per_page = 50;
}

if (isset($asset_id)) {
	echo gimmeBarAsset($asset_id);
}
else {
	echo gimmeBar($user, $collection, $page, $per_page, $tag);
}


function gimmeBar($user, $collection, $page, $per_page, $tag) {

	$url = 'https://gimmebar.com/api/v1/public/assets/' . $user . '/' . $collection . '.json';
	$url .= '?limit=' . $per_page . '&skip=' . ($per_page * ($page - 1));
	$url .= '&_extension[]=description';
	
	if ($tag) {
		$url .= '&tag=' . $tag;
	}
	
	$url .= '&limit=' . $per_page . '&skip=' . ($per_page * ($page - 1));

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


function gimmeBarAsset($asset_id) {

	$url = 'https://gimmebar.com/api/v1/public/asset/' . $asset_id . '.json';

	require_once('phpcache.php');
	$cache = new reallysimple\PhpCache('cache');
	$data = $cache->fetch($url);
	
	if (!$data) {
		$json = @file_get_contents($url);
		$data = json_decode($json);
		$cache->store($url, $data);
		$data->twf_cached = false;
	}
	else {
		$data->twf_cached = true;
	}
	
	return json_encode($data);
}



?>