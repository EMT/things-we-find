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
		
		//	Account for flash Vimeo embeds
		$vimeo_url = 'http://vimeo.com/api/v2/video/';
		foreach ($data->records as $item) {

			if ($item->asset_type === 'embed' 
			&& !$item->content->params 
			&& $item->content->attributes 
			&& $item->content->attributes->src)  {
				$purl = parse_url($item->content->attributes->src);
				if ($purl['query']) {
					parse_str($purl['query'], $q);
					if ($q['clip_id']) {
						$clip_data = @file_get_contents($vimeo_url . $q['clip_id'] . '.json');
						if ($clip_data) {
							$clip_data = json_decode($clip_data);
							$item->content->params->src = 'http://player.vimeo.com/video/' . $q['clip_id'];
							$item->content->thumbnail = $clip_data[0]->thumbnail_large;
						}
					}
				}
			}
		}
		
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
		
		//	Account for flash Vimeo embeds
		$vimeo_url = 'http://vimeo.com/api/v2/video/';
		if ($data->asset_type === 'embed' 
		&& !$data->content->params 
		&& $data->content->attributes 
		&& $data->content->attributes->src)  {
			$purl = parse_url($data->content->attributes->src);
			if ($purl['query']) {
				parse_str($purl['query'], $q);
				if ($q['clip_id']) {
					$clip_data = @file_get_contents($vimeo_url . $q['clip_id'] . '.json');
					if ($clip_data) {
						$clip_data = json_decode($clip_data);
						$data->content->params->src = 'http://player.vimeo.com/video/' . $q['clip_id'];
						$data->content->thumbnail = $clip_data[0]->thumbnail_large;
					}
				}
			}
		}
		
		$cache->store($url, $data);
		$data->twf_cached = false;
	}
	else {
		$data->twf_cached = true;
	}
	
	return json_encode($data);
}



?>