
var page = 1,
	more_items = true,
	loading = false,
	last_loaded_page = 0,
	tag = start_tag || false,
	push_state = false,
	url_base = (host === 'madebyfieldwork.co') ? '/lab/things-we-find/' : '/',
	secret_tags = ['Cats'];

$(function(){
	
	$('#main').css({marginTop: 200});
	
	loadItems(tag);
	
	
	$('#category-title > span').wrap('<span class="category-wrapper"></span>');
	
	$('body').on('click', 'a.category-link', function(e) {
		e.preventDefault();
		//$('.category-tooltip').remove();
		var new_tag = $(this).attr('href').substr(1);
		if (new_tag === tag) {
			tag = false;
		}
		else {
			tag = new_tag;
		}
		swapTag();
	});
	
	$('#category-nav a').on('mouseenter', function() {
		$(this).append($('<span class="category-tooltip">' + $(this).text() + '</span>'));
	});
	$('#category-nav a').on('mouseleave', function() {
		$('.category-tooltip').remove();
	});
	
	
	$(window).on('popstate', function(e){
		if (e.originalEvent.state) {
			tag = e.originalEvent.state.tag || start_tag;
		}
		else {
			tag = start_tag;
		}
		if (push_state) {
			swapTag(true);
		}
	});
	
	
	
	
	var scroll_timer;
	$(window).on('scroll', function() {
		if (scroll_timer) {
			clearTimeout(scroll_timer);
		}
		scroll_timer = setTimeout(function() {
			var doc_h = $(document).height(),
				win_h = $(window).height(),
				scroll = $(window).scrollTop();
			if (scroll + win_h > doc_h - 80) {
				loadItems(tag);
			}
		}, 200);
	});
	
	var resize_timer;
	$(window).resize(function() {
		if (resize_timer) {
			clearTimeout(resize_timer);
		}
		resize_timer = setTimeout(function() {
			$('#main').masonry('reload');
		}, 200);
	});
	
	
	var typed = [], 
		typed_timer = false;
	$(window).on('keyup', function(e) {
		if (typed_timer) {
			clearTimeout(typed_timer);
		}
		typed_timer = setTimeout(function() {
			typed = [];
		}, 3000);
		typed.push(e.which);
		if (typed.join(',') === '67,65,84,83') {
			tag = 'Cats';
			swapTag();
		}
	})
	
});





function swapTag(is_back) {

	$('body').attr('class', '');
	$('body').addClass('tag-body-' + tag);
	
	$('#main').fadeOut('fast', function() {
		var title = tag || 'Everything';
		$('#category-title .category-wrapper')
			.append($('<span class="tag-' + title + '">' + title + '</span>'))
			.animate({marginLeft: '-100%'}, function() {
				$(this).css({marginLeft: 0}).children(':first').remove();
			});
		$(this).replaceWith('<ul id="main"></ul>');
		page = 1;
		more_items = true;
		loading = false;
		last_loaded_page = 0;
		loadItems(tag);
		var url = url_base;
		var title = 'Things We Find';
		if (tag) {
			url += tag + '';
			title = tag + ' – ' + title;
		}
		document.title = title;
		if (typeof _gaq !== 'undefined') {
			_gaq.push(['_trackPageview', url]);
		}
		if (!is_back) {
			window.history.pushState({tag: tag}, title, url);
			push_state = true;
		}
	});
	
}



function loadItems(tag) {	
	if (!loading && more_items && page > last_loaded_page) {
		loading = true;
		var url = 'api.php?q=becausestudio/things-we-have-found';
		if ($.inArray(tag, secret_tags) > -1) {
			url = 'api.php?q=andygott/things-we-find-secretly'
		}
		if (page) {
			url += '&p=' + page;
		}
		if (tag) {
			url += '&tag=' + tag;
		}
		$.ajax({
			url: url, 
			dataType: 'json',
			complete: function() {
				loading = false;
			},
			success: onItemsLoaded
		});
		
	}
	
}


function onItemsLoaded(data) {

	more_items = data.more_records;
	
	if (data.records) {
	
		last_loaded_page = page;
		
		item_html = generateItemsHtml(data.records);
		
		var $container = $('#main'),
			has_items = ($container.children().length) ? true : false;
		if (!has_items && page > 1) {
			$container.replaceWith('<ul id="main"></ul>');
			$container = $('#main');
			
		}
		$item_html = $(item_html);
		$container.append($item_html);
		
		if (has_items) {
			$item_html.css({opacity: 0});
		}
		
		$container.imagesLoaded(function(){
			if (!has_items) {
				$container.masonry({
					itemSelector : '.box',
					isAnimated: true
				});
				$('#main').css({marginTop: 0, opacity: 1});
			}
			else {
				$container.masonry('appended', $item_html, true);
				setTimeout(function() {$item_html.css({opacity: 1}); }, 200);
			}
			page ++;
			setTimeout(function() {
				if ($('body').height()-160 < $(window).height()) {
					loadItems(tag);
				}
			}, 750);
		});
	}
}


function generateItemsHtml(items) {

	var item, item_html, template, context;
	
	for (var i = 0, len = items.length; i < len; i ++) {
	
		item = items[i];
		
		switch (item.asset_type) {
		
			case 'image':
				template = $('#template-gimmebar-image').html();
				context = {
					thumb: item.content.resized_images.stash.url,
					source: item.source,
					tags: (item.tags || [tag] || false)
				}
				break;
				
			default: 
				template = false;
				context = {};
				
		}
		
		if (template) {
			if (!tag || (tag && $.inArray(tag, context.tags) > -1)) {
				template = Handlebars.compile(template);
				item_html += template(context);
			}
		}
		
	}
	
	return item_html;
}
