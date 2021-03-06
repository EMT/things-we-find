<!doctype html>
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
	
	<?php if ($tag) { ?>
<!-- 		<link rel="canonical" href="http://<?php echo $base_url; ?>/<?php echo $tag; ?>" /> -->
	<?php } ?>
	
	<?php if ($item) { ?>
		<?php if ($item_data->asset_type === 'image') { ?>
			<meta property="og:image" content="<?php echo $item_data->content->resized_images->full; ?>"/>
		<?php } else if ($item_data->asset_type === 'embed') { ?>
			<meta property="og:image" content="<?php echo $item_data->content->thumbnail; ?>"/>
		<?php } ?>
		<meta property="og:title" content="<?php echo $item_data->title; ?> (via Things We Find)"/>
	<?php } ?>
	<meta property="og:site_name" content="Things We Find"/>

	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="<?php echo $base_slug; ?>/css/style.<?php echo $build; ?>.css">
	<script src="<?php echo $base_slug; ?>/js/modernizr.js"></script>
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
			<a class="category-link tag-Moving" href="/Moving">Moving</a>
			<a class="category-link tag-Miscellany" href="/Miscellany">Miscellany</a>
		</nav>
		
		<div id="social-media">
			<a href="#" id="sm-trigger">Tweet/Like</a>
			<ul id="sm-popup">
				<li>
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://thingswefind.com">Tweet</a>
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
					<div class="fb-like" data-href="http://thingswefind.com" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
				</li>
			</ul>
		</div>
		
		<a class="about-link" href="/about">?</a>
		
		<!--[if lte IE 9]>
			<p class="ie-note">Hey, this site isn't broken, your browser is. It looks like you’re using Internet Explorer, which is old, slow, insecure and full of bugs. Please try <a href="https://www.google.com/intl/en/chrome/browser/" target="_blank">Chrome</a>, <a href="http://www.apple.com/safari/" target="_blank">Safari</a> or <a href="http://www.mozilla.org/en-US/firefox/new/" target="_blank">Firefox</a> instead.</p>
		<![endif]-->
		
		<div>
			<h1><a class="category-link" href="/">Things We Find</a></h1>
			<h2 id="category-title"><span class="tag-<?php echo $tag_title; ?>"><?php echo $tag_title; ?></span></h2>
		</div>
		
	</header>
	
	
	<div class="main-wrapper">
		<ul id="main">
		
		</ul>
	</div>
	
	
	
	
	<section id="about" class="popup">
		<h2>What’s all this then?</h2>
		<p>Created by Andy Gott & Loz Ives, Things We Find is an online repository for the visual loveliness that we find every day. Content is uploaded as and when we find it, and loosely categorised in one way or another.</p>
		<p>The collection is quickly expanding thanks to a growing network of contributors.</p>
		<p>The code is hosted on <a href="https://github.com/EMT/things-we-find">Github</a>, and the whole thing is built on top of <a href="http://gimmebar.com">GimmeBar</a>.</p>
		<h2>Digital Explorers</h2>
		<ul>
			<li><a href="https://twitter.com/BecauseStudio" target="_blank">Loz Ives</a></li>
			<li><a href="https://twitter.com/waltlowry" target="_blank">Johnny Lowry</a></li>
			<li><a href="https://twitter.com/smartemma" target="_blank">Emma Smart</a></li>
			<li><a href="https://twitter.com/RSWorks" target="_blank">Andy Gott</a></li>
		</ul>
		<p class="made-by-fieldwork">Designed &amp; Built by <a href="http://madebyfieldwork.co">Fieldwork</a></p>
	</section>
	
	
	
	<script id="template-gimmebar-image" type="text/x-handlebars-template">
		<li class="box">
			<a class="item-link" href="{{url}}">
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
	
	<script id="template-gimmebar-embed" type="text/x-handlebars-template">
		<li class="box">
			<a class="item-link" href="{{url}}">
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
	
	
	<script id="template-item-popup-image" type="text/x-handlebars-template">
		<section class="popup popup-item">
			<h2>{{title}}</h2>
			<a id="main-img" href="{{source}}"><img src="{{content.resized_images.full}}" alt="{{title}}" /></a>
			<p><a href="{{source}}" target="_blank">Original Source</a></p>
		</section>
	</script>
	
	<script id="template-item-popup-embed-iframe" type="text/x-handlebars-template">
		<section class="popup popup-item popup-embed">
			<h2>{{title}}</h2>
			<div id="main-embed">
				<iframe src="{{content.params.src}}" alt="{{title}}" />
			</div>
			<p><a href="{{source}}" target="_blank">Original Source</a></p>
		</section>
	</script>
	
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php echo $base_slug; ?>/js/jquery.js"><\/script>')</script>
	<script src="<?php echo $base_slug; ?>/js/jquery.masonry.min.js"></script>
	<script src="<?php echo $base_slug; ?>/js/handlebars.js"></script>
	<script src="<?php echo $base_slug; ?>/js/spin.js"></script>
	<script type="text/javascript">
		start_tag = <?php echo ($tag) ? ("'" . $tag . "'") : 'false'; ?>;
		start_item_id = <?php echo ($item_id) ? ("'" . $item_id . "'") : 'false'; ?>;
		start_item = <?php echo ($item) ? ($item) : 'false'; ?>;
		host = '<?php echo $host; ?>';
	</script>
	<script src="<?php echo $base_slug; ?>/js/bootstrap.<?php echo $build; ?>.js"></script>
	
	<?php if ($host !== 'madebyfieldwork.co') { ?>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-34217297-3']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>
	<?php } ?>
	
</body>
</html>
