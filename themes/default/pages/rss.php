<?php
echo <<<END
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0"
	 xmlns:atom="http://www.w3.org/2005/Atom"
	 xmlns:dc="http://purl.org/dc/elements/1.1/"
	 xmlns:content="http://purl.org/rss/1.0/modules/content/">
	<channel>
		<title>Example.com - Новости</title>
		<link>http://example.com</link>
		<atom:link href="http://example.com/news/rss/" rel="self" type="application/rss+xml" />
		<description>Новости example.com</description>
		<language>ru</language>

END;
echo ($content);
echo <<<END
	</channel>
</rss>
END;
?>
