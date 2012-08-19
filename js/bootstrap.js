
var page = 1,
	more_items = true,
	loading = false,
	last_loaded_page = 0,
	tag = false;

$(function(){
	
	$('#main').css({marginTop: 200});
	
	loadItems(tag);
	
	$('#category-nav a').on('click', function(e) {
		e.preventDefault();
		tag = $(this).text();
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		$('#main').fadeOut('fast', function() {
			$('#category-title')
				.append($('<span class="tag-' + tag + '">' + tag + '</span>'))
				.animate({marginLeft: '-100%'}, function() {
					$(this).css({marginLeft: 0}).children(':first').remove();
				});
			$(this).replaceWith('<ul id="main"></ul>');
			page = 1;
			more_items = true;
			loading = false;
			last_loaded_page = 0;
			loadItems(tag);
		});
		
	});
	
	var timer;
	$(window).on('scroll', function() {
		if (!timer) {
			var timer = setTimeout(function() {
				var doc_h = $(document).height(),
					win_h = $(window).height(),
					scroll = $(window).scrollTop();
				if (scroll + win_h > doc_h - 80) {
					loadItems(tag);
				}
			}, 200);
		}
	});
	
	var timer;
	$(window).resize(function() {
		if (!timer) {
			var timer = setTimeout(function() {
				$container.masonry('reload');
			}, 200);
		}
	});
	
});


function loadItems(tag) {
	
	if (!loading && more_items && page > last_loaded_page) {
		loading = true;
		var url = 'api.php?q=becausestudio/things-we-have-found';
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
			success: function(data) {
				more_items = data.more_records;
				if (data.records) {
					more_items = data.more_records;
					last_loaded_page = page;
					var item, item_html, template, context;
					for (var i = 0, len = data.records.length; i < len; i ++) {
						item = data.records[i];
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
					
					var $container = $('#main'),
						has_items = ($container.children().length) ? true : false;
					if (!has_items && page > 1) {
						$container.replaceWith('<ul id="main"></ul>');
						$container = $('#main');
						
					}
					$item_html = $(item_html);
					$container.append($item_html);
					
					$container.imagesLoaded( function(){
					  if (!has_items) {
						$container.masonry({
					    	itemSelector : '.box',
					    	isAnimated: true
					    });
					    $('#main').css({marginTop: 0, opacity: 1});
					  }
					  else {
						  $container.masonry('appended', $item_html, true);
					  }
					  page ++;
					});
				}
				
				
			}
		});
		
	}
	
}