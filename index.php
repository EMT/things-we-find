<?php

ini_set('display_errors',1); 
 error_reporting(E_ALL);

$format = 'html';
$error = false;


$host = $_SERVER['HTTP_HOST'];
$base_url = $host;
$base_slug = '';
if ($host === 'madebyfieldwork.co') {
	$base_url .= '/lab/things-we-find';
	$base_slug = '/lab/things-we-find';
}
$build = 22;


$tag = false;
$item_id = false;
$item = false;
$item_data = false;
$items = false;


$slug = (isset($_GET['url'])) ? $_GET['url'] : false;

if ($slug) {

	$slug = explode('/', $slug);
	
	if ($slug[0] !== 'item') {
		$tag = ucfirst($slug[0]);
	}
	
	if ($slug[0] === 'item' && isset($slug[1])) {
		$item_id = $slug[1];
	}
	else if (isset($slug[1]) && $slug[1] === 'item' && isset($slug[2])) {
		$item_id = $slug[2];
	}
	
	if (!$item_id && array_pop($slug) === 'feed.rss') {
		$format = 'rss';
		$api_url = 'http://' . $base_url . '/api.php?q=becausestudio/things-we-have-found&tag=' . $tag;
		$items = file_get_contents($api_url);
		$items = json_decode($items);
	}
}


$tag_title = ($tag) ?: 'Everything';
$page_title = ($tag) ?: '';
$page_title .= ($tag) ? ' – ' : '';
$page_title .= 'Things We Find';



$collection_url = 'http://' . $base_url;
if ($tag) {
	$collection_url .= '/' . $tag;
}

$feed_url = false;
if (!$item_id) {
	$feed_url = $collection_url . '/feed.rss';
}


//	Access the API if the URL refers to an item
if ($item_id) {
	$item = file_get_contents('http://' . $base_url . '/api.php?asset=' . $item_id);
	$item_data = json_decode($item);
	if ($item) {
		$page_title = $item_data->title . ' – Things We Find';
	}
}




//	Prepare data for view

$view = new SimpleView();
$view->page_title = $page_title;
$view->tag = $tag;
$view->item_id = $item_id;
$view->item = $item;
$view->item_data = $item_data;
$view->base_slug = $base_slug;
$view->build = $build;
$view->tag_title = $tag_title;
$view->page_title = $page_title;
$view->host = $host;
$view->items = $items;
$view->collection_url = $collection_url;
$view->feed_url = $feed_url;







//	Render view in requested format

try {
	if ($error) {
		$view->render($error . '.' . $format . '.php');
	}
	else {
		if ($format === 'rss') {
			header('Content-Type: application/rss+xml; charset=UTF-8');
		}
		$view->render('itemlist.' . $format . '.php');
	}
}
catch (Exception $e) {
	$view->render('404.html.php');
}


exit();



/**	
 *	Simple templating engine
 */
 

class SimpleView {

    protected $views_dir;
    protected $vars = array();
    
    public function __construct($views_dir = 'views/') {
        $this->views_dir = $views_dir;
    }
    
    public function render($view_file) {
        if (file_exists($this->views_dir . $view_file)) {
        	extract($this->vars);
            include($this->views_dir . $view_file);
        } else {
            throw new Exception('View file ' . $view_file . ' not found in ' . $this->views_dir);
        }
    }
    
    public function __set($name, $value) {
        $this->vars[$name] = $value;
    }
    
    public function __get($name) {
        return $this->vars[$name];
    }
}

	
	
	
	
	
?>