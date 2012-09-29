<?php //var_dump($items); ?>
<?xml version="1.0" encoding="ISO-8859-1" ?>
<rss version="2.0">
	<channel>
		<title><?php echo $page_title; ?></title>
		<link><?php echo $feed_url; ?></link>
		<description>Created by Andy Gott & Loz Ives, Things We Find is an online repository for the visual loveliness that we find every day. Content is uploaded as and when we find it, and loosely categorised in one way or another.</description>
		<language>English</language>
		<?php foreach ($items->records as $item) { ?>
			<item>
				<title><?php echo $item->title; ?></title>
				<link><?php echo $collection_url . '/' . $item->id; ?></link>
				<?php if ($item->asset_type === 'image') { ?>
					<description><![CDATA[<a href="<?php echo $collection_url . '/' . $item->id; ?>"><img alt="<?php echo $item->title; ?>" src="<?php echo $item->content->resized_images->full; ?>" /></a>]]></description>
				<?php } else if ($item->asset_type === 'embed') { ?>
					<description><![CDATA[<a href="<?php echo $collection_url . '/' . $item->id; ?>"><img alt="<?php echo $item->title; ?>" src="<?php echo $item_data->content->thumbnail; ?>" /></a>]]></description>
				<?php } ?>
			</item>
		<?php } ?>
	</channel>
</rss>