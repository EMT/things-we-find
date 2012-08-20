<?php
	$tag = (isset($_GET['url'])) ? $_GET['url'] : false;
	$tag_title = ($tag) ?: 'Everything';
	$page_title = ($tag) ?: '';
	$page_title .= ($tag) ? ' – ' : '';
	$page_title .= 'Things We Find';
?><!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">

	<!--
	Welcome to the source.
	It's been our pleasure.
	-->

	<title><?php echo $page_title; ?></title>

	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/modernizr.js"></script>
	<script type="text/javascript" src="//use.typekit.net/pja1bzr.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
</head>
<body class="tag-body-<?php echo $tag_title; ?>">
	
	
	<header>
		<nav id="category-nav" class="category-nav">
			<a class="category-link tag-Typography" href="/Typography">Typography</a>
			<a class="category-link tag-Illustration" href="/Illustration">Illustration</a>
			<a class="category-link tag-Spaces" href="/Spaces">Spaces</a>
			<a class="category-link tag-Print" href="/Print">Print</a>
			<a class="category-link tag-Objects" href="/Objects">Objects</a>
			<a class="category-link tag-Colour" href="/Colour">Colour</a>
			<a class="category-link tag-Environments" href="/Environments">Environments</a>
			<a class="category-link tag-Photography" href="/Photography">Photography</a>
			<a class="category-link tag-Miscellany" href="/Miscellany">Miscellany</a>
		</nav>
		<div id="social-media">
			<a href="#" id="sm-trigger">Tweet/Like</a>
			<ul id="sm-popup">
				<li>
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="[TEST]">Tweet</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</li>
				<li>
					<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
					<div class="fb-like" data-href="http://test.com" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
				</li>
			</ul>
		</div>
		<h1>Things We Find</h1>
		<h2 id="category-title"><span class="tag-<?php echo $tag_title; ?>"><?php echo $tag_title; ?></span></h2>
	</header>
	
	
	<ul id="main">
		
	</ul>
	
	
	<script id="template-gimmebar-image" type="text/x-handlebars-template">
		<li class="box">
			<a href="{{source}}">
				<img src="{{thumb}}" alt="" />
			</a>
			{{#if tags.length}}
				<ul class="tags">
					{{#each tags}}
						<li><a class="category-link tag-{{this}}" href="/{{this}}">{{this}}</a></li>
					{{/each}}
				</ul>
			{{/if}}
		</li>
	</script>
	
	<script id="template-category-list" type="text/x-handlebars-template">
		<li class="tag tag-{{tag}}">{{tag}}</li>
	</script>
	
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery.js"><\/script>')</script>
	<script src="js/jquery.masonry.min.js"></script>
	<script src="js/handlebars.js"></script>
	<script type="text/javascript">
		start_tag = <?php echo ($tag) ? ("'" . $tag . "'") : 'false'; ?>;
	</script>
	<script src="js/bootstrap.js"></script>
	
</body>
</html>
