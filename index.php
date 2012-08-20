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

	<title>Things We Find</title>

	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/modernizr.js"></script>
	<script type="text/javascript" src="//use.typekit.net/pja1bzr.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
</head>
<body>
	
	
	<header>
		<nav id="category-nav" class="category-nav">
			<a class="tag-Typography" href="">Typography</a>
			<a class="tag-Illustration" href="">Illustration</a>
			<a class="tag-Spaces" href="">Spaces</a>
			<a class="tag-Print" href="">Print</a>
			<a class="tag-Objects" href="">Objects</a>
			<a class="tag-Colour" href="">Colour</a>
			<a class="tag-Environments" href="">Environments</a>
			<a class="tag-Photography" href="">Photography</a>
		</nav>
		<h1>Things We Find</h1>
		<h2 id="category-title"><span>Everything</span></h2>
	</header>
	
	
	<ul id="main">
		
	</ul>
	
	
	<script id="template-gimmebar-image" type="text/x-handlebars-template">
		<li class="box">
			<a href="{{source}}">
				<img src="{{thumb}}" alt="" />
				{{#if tags.length}}
					<ul class="tags">
						{{#each tags}}
							<li class="tag-{{this}}">{{this}}</li>
						{{/each}}
					</ul>
				{{/if}}
			</a>
		</li>
	</script>
	
	<script id="template-category-list" type="text/x-handlebars-template">
		<li class="tag tag-{{tag}}">{{tag}}</li>
	</script>
	
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/jquery.js"><\/script>')</script>
	<script src="js/jquery.masonry.min.js"></script>
	<script src="js/handlebars.js"></script>
	<script src="js/bootstrap.js"></script>
	
</body>
</html>
