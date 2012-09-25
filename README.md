rss-file-fetcher
================

A simple PHP script that parses remote RSS feed and downloads remote files from it.

Requirements
-------------

Script requires [SimpleXML](http://php.net/manual/en/book.simplexml.php) (available in PHP 5) and [cURL](http://php.net/manual/en/book.curl.php) libraries.

No database is required.


Usage
-----

#### Configuration ####
Edit the php file and change constants in the configuration section.

* PHP_ERROR_REPORTING : Sets the php error reporting. Must be either true or false.
* DEBUG : Setting this to true will display some debug information.
* FILE_FOLDER : A full path to a folder where downloaded files should reside.
* RSS_URL : A url to a remote RSS file. 

#### Running the script ####
Run the script in a console or on a web server. If you use it in a console, don't forget to add an interpreter on top of the php file:

    #!/usr/bin/php
    <?php
    ....

.. or call it directly:

    /usr/bin/php /path/to/rss-file-fetcher.php

.. or schedule it (using [cron](http://en.wikipedia.org/wiki/Cron)) to regularly download a new content like so:

    */30 * * * * /usr/bin/php /path/to/rss-file-fetcher.php

#### RSS example ####
This is a sample RSS (xml) file that hypothetically could be parsed. Each channel->item->link file could then be downloaded.

    <?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0">
        <channel>
            <title>Personal feed</title>
            <link>http://www.example.com/feed/</link>
            <ttl>30</ttl>
            <description>A feed of the shows selected by the user</description>
            <item>
                <title>HD 720p: Breaking Bad S05E08 720p HDTV x264-IMMERSE</title>
                <link>http://torrent.zoink.it/Breaking.Bad.S05E08.720p.HDTV.x264-IMMERSE.%5Beztv%5D.torrent</link>
                <guid isPermaLink="true">http://torrent.zoink.it/Breaking.Bad.S05E08.720p.HDTV.x264-IMMERSE.%5Beztv%5D.torrent</guid>
                <pubDate>Mon, 03 Sep 2012 11:25:03 +0200</pubDate>
                <description>&lt;strong&gt;New HD 720p torrent for Breaking Bad:&lt;/strong&gt; &lt;strong&gt;Breaking Bad&lt;/strong&gt; 5x08 720p. Torrent link: &lt;a href="http://torrent.zoink.it/Breaking.Bad.S05E08.720p.HDTV.x264-IMMERSE.[eztv].torrent"&gt;http://torrent.zoink.it/Breaking.Bad.S05E08.720p.HDTV.x264-IMMERSE.[eztv].torrent&lt;/a&gt;</description>
                <enclosure url="http://torrent.zoink.it/Breaking.Bad.S05E08.720p.HDTV.x264-IMMERSE.%5Beztv%5D.torrent" length="0" type="application/x-bittorrent"/>
            </item>
            <item>
                ...
            </item>
        </channel>
    </rss>
