
var page = 1,
	more_items = true,
	loading = false,
	item_loading = false,
	last_loaded_page = 0,
	tag = start_tag || false,
	item_id = start_item_id,
	items = {},
	push_state = false,
	url_base = (host === 'madebyfieldwork.co') ? '/lab/things-we-find/' : '/',
	secret_tags = ['Cats'];
	
	
if (start_item) {
	items[start_item.id] = start_item;
}
	
	
var spinner_opts = {
  lines: 9, // The number of lines to draw
  length: 15, // The length of each line
  width: 10, // The line thickness
  radius: 35, // The radius of the inner circle
  corners: 1, // Corner roundness (0..1)
  rotate: 30, // The rotation offset
  color: 'rgb(255,255,255)', // #rgb or #rrggbb
  speed: 1.1, // Rounds per second
  trail: 62, // Afterglow percentage
  shadow: false, // Whether to render a shadow
  hwaccel: false, // Whether to use hardware acceleration
  className: 'spinner', // The CSS class to assign to the spinner
  zIndex: 2e9, // The z-index (defaults to 2000000000)
  top: 'auto', // Top position relative to parent in px
  left: 'auto' // Left position relative to parent in px
};
	

	

$(function(){
	
	
	$('#main').css({marginTop: 200});
	
	
	loadItems(tag);
	
	if (item_id) {
		loadItem(item_id, true);
	}
	
	
	$('.about-link').on('click', function(e) {
		e.preventDefault();
		if (popup_open) {
			closePopup(false);
		}
		$popup = $('#about');
		if ($popup.css('display') !== 'block') {
			var random_index = 1 + Math.floor(Math.random() * $('#category-nav a').length);
			if (random_index === 4 || random_index === 8 || random_index === 10) {
				random_index --;
			}
			var $random_cat_link = $('#category-nav a:nth-child(' + random_index + ')');
			$popup.attr('class', 'popup bg-' + $random_cat_link.attr('href').substr(1));
			openPopup($popup, false);
		}
		else {
			closePopup();
		}
	});
	
	
	$('#category-title > span').wrap('<span class="category-wrapper"></span>');
	
	
	$('body').on('click', 'a.category-link', function(e) {
		e.preventDefault();
		var new_tag = $(this).attr('href').substr(1);
		if (new_tag === tag) {
			tag = false;
		}
		else {
			tag = new_tag;
		}
		if ($('#popup-overlay').length) {
			closePopup(swapTag);
		}
		else {
			swapTag();
		}
	});
	
	
	$('#category-nav a').on('mouseenter', function() {
		$(this).append($('<span class="category-tooltip">' + $(this).text() + '</span>'));
	});
	$('#category-nav a').on('mouseleave', function() {
		$('.category-tooltip').remove();
	});
	
	
	$('body').on('click', 'a.item-link', function(e) {
		if (Modernizr.history) {
			e.preventDefault();
			var url = $(this).attr('href');
			if (popup_open) {
				closePopup(false, function() {loadItemOnClick(url); });
			}
			else {
				loadItemOnClick(url);
			}
		}
	});
	
	
	$(window).on('popstate', function(e){
		var old_tag = tag;
		var old_item_id = item_id;
		if (e.originalEvent.state) {
console.log(e.originalEvent.state);
			tag = e.originalEvent.state.tag;
			item_id = e.originalEvent.state.item_id;
		}
		else {
console.log("no state: " + e.originalEvent.state);
			tag = start_tag;
			item_id = start_item_id;
		}
		if (push_state) {
			if (tag !== old_tag) {
				swapTag(true);
			}
			if (item_id !== old_item_id) {
				loadItem(item_id, true);
			}
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
		if (title === 'Cats') {
			title = 'Kiiiitttttiiiiieeeeessssss!!!!!!';
		}
		
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
		title = 'Things We Find';
		if (tag) {
			url += tag + '';
			title = tag + ' – ' + title;
		}
		
		document.title = title;
		
		if (typeof _gaq !== 'undefined') {
			_gaq.push(['_trackPageview', url]);
		}
		
		if (!is_back) {
			window.history.pushState({tag: tag, item_id: false}, title, url);
			push_state = true;
		}
		
	});
	
}



function loadItems(tag) {

	if (!loading && more_items && page > last_loaded_page) {
	
		loading = true;
		
		var url = url_base + 'api.php?q=becausestudio/things-we-have-found';
		if ($.inArray(tag, secret_tags) > -1) {
			url = url_base + 'api.php?q=andygott/things-we-find-secretly'
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
			
			var container_width = $('#main').width(),
				col_width = Math.floor(container_width / (Math.ceil(container_width / 300)));
			$('.box').each(function() {$(this).css({width: col_width}); });
			
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
					id: item.id,
					thumb: (item.content.resized_images.stash) 
						? item.content.resized_images.stash.url : item.content.resized_images.full,
					source: item.source,
					tags: (item.tags || [tag] || false)
				}
				break;
				
			case 'embed':
				template = $('#template-gimmebar-embed').html();
				context = {
					id: item.id,
					thumb: item.content.thumbnail,
					source: item.source,
					tags: (item.tags || [tag] || false)
				}
				break;
				
			default: 
				template = false;
				context = {};
				
		}
		
		if (template && context.thumb) {
			if (!tag || (tag && $.inArray(tag, context.tags) > -1)) {
				template = Handlebars.compile(template);
				context.url = url_base;
				if (tag) {
					context.url += tag + '/';
				}
				context.url += 'item/' + context.id;
				item_html += template(context);
			}
		}
		
	}
	
	return item_html;
}



function loadItemOnClick(url) {
	var url_parts = url.split('/');
	item_id = url_parts.pop();
	loadItem(item_id);
}


function loadItem(item_id, is_back) {
	
	if (!item_id) {
		closePopup(function() {clearItem(is_back); });
		return;
	}

	openPopupOverlay();
	var spin_timer = setTimeout(function() {
		spinner = new Spinner(spinner_opts).spin(document.getElementById('popup-overlay'));
	}, 750);
	
	if (!item_loading) {
	
		if (items[item_id]) {
			return onItemLoaded(items[item_id], is_back);
		}
	
		item_loading = true;
	
		var url = url_base + 'api.php?asset=' + item_id;
			
		$.ajax({
			url: url, 
			dataType: 'json',
			complete: function() {
				item_loading = false;
			},
			success: function(data) {
				onItemLoaded(data, is_back);
			}
		});	
	}
	
}


function onItemLoaded(data, is_back) {

	if (data && data.id) {
		items[data.id] = data;
	}
	
	if (popup_open) {
		closePopup(false, function() {
			var template = Handlebars.compile($('#template-item-popup').html());
			$popup = $(template(data));
			$popup.appendTo($('body'));
			$popup.imagesLoaded(function() {
				openPopup($popup);
			});
		});
	}
	else {
		var template = false;
		if (data.asset_type === 'image') {
			template = Handlebars.compile($('#template-item-popup-image').html());
		}
		else if (data.asset_type === 'embed') {
			template = Handlebars.compile($('#template-item-popup-embed-iframe').html());
console.log(data);
		}
		if (template) {
			$popup = $(template(data));
			$popup.appendTo($('body'));
			$popup.imagesLoaded(function() {
				openPopup($popup);
			});
		}
	}
	
	var title = data.title + ' – Things We Find';
	document.title = title;
	if (!is_back) {
		var url = url_base;
		if (tag) {
			url += tag + '/';
		}
		url += 'item/' + data.id;
		window.history.pushState({tag: tag, item_id: item_id}, title, url);
		push_state = true;
		if (typeof _gaq !== 'undefined') {
			_gaq.push(['_trackPageview', url]);
		}
	}
	
	return;
}


function clearItem(is_back) {

	if (!Modernizr.history) {
		window.location = url_base + ((tag) ? tag : '');
		return;
	}

	item_id = false;
	
	var title = '';
	if (tag) {
		title = tag + ' – ';
	}
	title += 'Things We Find';
	document.title = title;
	
	if (!is_back) {
		var url = url_base
		if (tag) {
			url += tag;
		}
		window.history.pushState({tag: tag, item_id: item_id}, title, url);
		push_state = true;
		if (typeof _gaq !== 'undefined') {
			_gaq.push(['_trackPageview', url]);
		}
	}
}




var $popup = false,
	popup_open = false;
	
function openPopup($popup, remove_on_close) {

	if (typeof remove_on_close === 'undefined') {
		remove_on_close = true;
	}

	var w = $popup.css({top: '-99999px', display: 'block'}).outerWidth(true),
		h = $popup.outerHeight(true),
		win_w = $(window).width(),
		win_h = $(window).height(),
		viewport_h = win_h - $('#category-nav').outerHeight();	
			
	if (viewport_h - 20 < h) {
		var diff = h - (viewport_h - 20),
			img_h = $('#main-img').height();
		$('#main-img').css('height', img_h - diff);	
	}
	
	if ($popup.hasClass('popup-embed')) {
		var embed_h = $('#main-embed').outerHeight(),
			embed_w = $('#main-embed').outerWidth(),
			margins_h = h - embed_h,
			margins_w = w - embed_w,
			space_h = viewport_h - h,
			space_w = win_w - w;
		if (space_h > space_w * 0.5625) {
			//	fit to width
			$('#main-embed').css('width', Math.min((win_w * 0.9) - margins_w, 1000));
		}
		else {
			//	fit to height
			$('#main-embed').css('width', Math.min(((viewport_h * 0.9) - margins_h) * 1.5325, 1000));
		}
	}
	
	win_h += $('#category-nav').outerHeight();
	
	$popup.css({
		display: 'none'
	});
	w = $popup.outerWidth(true);
	h = $popup.outerHeight(true);
				
	$popup.css({
		display: 'none', 
		top: (win_h - h) / 2, 
		left: (win_w - w) / 2
	}).data('removeOnClose', remove_on_close);
	
	openPopupOverlay();
	
	$popup.append($('<a class="close" href="#">Close</a>')).fadeIn('fast');
	
	$popup.find('.close').on('click', function(e) {e.preventDefault(); closePopup(); });
	
	popup_open = true;	
}


function closePopup(close_overlay, callback) {
	//	change URL
	if (typeof close_overlay === 'function') {
		callback = close_overlay;
		close_overlay = true;
	}
	if (item_id) {
		clearItem();
	}
	$popup.fadeOut('fast', function() {
		if ($(this).data('removeOnClose')) {
			$(this).remove();
		}
		if (typeof callback === 'function') {
			callback();
		}
	});
	if (close_overlay !== false) {
		$('#popup-overlay').fadeOut('fast', function() {
			$(this).remove();
		});
	}
	popup_open = false;
}


function openPopupOverlay() {
	if (!$('#popup-overlay').length) {
		$('<div></div>').attr('id', 'popup-overlay')
			.appendTo($('body'))
			.on('click', function() {closePopup(remove_on_close); })
			.fadeIn('fast');
	}
}

