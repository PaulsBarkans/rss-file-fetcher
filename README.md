rss-file-fetcher
================

A simple PHP script that parses remote RSS feed and downloads remote files from it. No database required.

Requirements
-------------

Script requires [SimpleXML](http://php.net/manual/en/book.simplexml.php) (available in PHP 5) and [cURL](http://php.net/manual/en/book.curl.php) libraries.


Usage
-----

#### Configuration ####
Edit the php file and change constants in the configuration section.

* PHP_ERROR_REPORTING : Sets the php error reporting. Must be either true or false.
* DEBUG : Will display some debug information. Must be either true or false.
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
