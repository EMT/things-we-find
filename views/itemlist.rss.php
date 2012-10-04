<?php //var_dump($items); ?>
<?xml version="1.0" encoding="utf-8" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title><?php echo $page_title; ?></title>
		<link><?php echo $feed_url; ?></link>
		<atom:link href="<?php echo $feed_url; ?>" rel="self" type="application/rss+xml" />
		<description>Created by Andy Gott &amp; Loz Ives, Things We Find is an online repository for the visual loveliness that we find every day. Content is uploaded as and when we find it, and loosely categorised in one way or another.</description>
		<language>en</language>
		<?php foreach ($items->records as $item) { 
			if (!$tag || in_array($tag, $item->tags)) { ?>
			<item>
				<guid><?php echo $collection_url . '/item/' . $item->id; ?></guid>
				<title><?php echo $item->title; ?></title>
				<link><?php echo $collection_url . '/item/' . $item->id; ?></link>
				<pubDate><?php echo date(DATE_RFC2822, $item->date); ?></pubDate>
				<?php if ($item->asset_type === 'image') { ?>
					<description><![CDATA[<a href="<?php echo $collection_url . '/item/' . $item->id; ?>"><img alt="<?php echo $item->title; ?>" src="<?php echo $item->content->resized_images->full; ?>" /></a>]]></description>
				<?php } else if ($item->asset_type === 'embed') { ?>
					<description><![CDATA[<a href="<?php echo $collection_url . '/item/' . $item->id; ?>"><img alt="<?php echo $item->title; ?>" src="<?php echo $item_data->content->thumbnail; ?>" /></a>]]></description>
				<?php } ?>
			</item>
			<?php } ?>
		<?php } ?>
	</channel>
</rss>