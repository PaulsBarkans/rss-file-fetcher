<?php

// Configuration
define("PHP_ERROR_REPORTING", false); // either "true" or "false"
define("DEBUG", true); // either "true" or "false"
define("FILE_FOLDER", "/tmp/rss"); // a folder where torrent files will be copied.
define("RSS_URL", "http://www.example.com/feed/");

// Some debug..
if(PHP_ERROR_REPORTING){
	error_reporting(E_ALL);
} else {
	error_reporting(0);
}

if(!function_exists('curl_init')){
	exit("- Couldn't find Curl for PHP. The script will exit. \n");
}

if(!function_exists('simplexml_load_file')){
	exit("- SimpleXML library is required. The script will exit.\n");
}

// Set up directories if doesn't exist:
if(!is_dir(FILE_FOLDER)){
	if(DEBUG){echo "- Trying to create folder '".FILE_FOLDER."'\n";}
	if(!mkdir(FILE_FOLDER)){
		exit("- Couldn't create folder '".FILE_FOLDER."'\n");
	} else {
		if(DEBUG){echo "- ... OK\n";}
	}
}



// Main logic
if(DEBUG){echo "\n- Will try to load RSS file using SimpleXML (".RSS_URL.")...\n";}
$rss = simplexml_load_file(RSS_URL);

if(!$rss){
	exit("- Couldn't fetch RSS file. Application will exit.\n");
} else {
	if(DEBUG){echo "- RSS file successfully loaded.\n";}
}


// Get existing files
$existing_files = array();
if ($handle = opendir(FILE_FOLDER)) {
	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != "..") {
			$existing_files[] = $file;
		}
	}
	closedir($handle);
}
if(DEBUG){echo "\n- There are currently ".count($existing_files)." files in ".FILE_FOLDER." \n";}

// Iterate on RSS items.
if(DEBUG){echo "- Iterating on all RSS items \n\n";}
foreach($rss->channel->item as $item){
	$rss_file = substr($item->link, strrpos($item->link, "/")+1);

	if(DEBUG){echo "- Checking whether '".FILE_FOLDER."' contains a file '".$rss_file."' \n";}
	if(!in_array($rss_file, $existing_files)){

		if(DEBUG){echo "-- It doesn't. Will try to download it. \n";}
		$fp = fopen (FILE_FOLDER.'/'.$rss_file, 'w+');
		$ch = curl_init($item->link);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_exec($ch);

		$info = curl_getinfo($ch);
		if(DEBUG){
			echo "-- File downloaded in ".$info['total_time']." seconds, and is ".$info['download_content_length']." bytes \n\n";
		}

		curl_close($ch);
		fclose($fp);
		
		// Check filesize, delete torrent file if 0
		if(filesize(FILE_FOLDER.'/'.$rss_file) === 0) {
			if(DEBUG){echo "-- File '".$rss_file."' is 0 bytes. Will delete (perhaps next time it will download correctly).\n";}
			unlink(FILE_FOLDER.'/'.$rss_file);
		} else {
			if(!DEBUG){echo "Downloaded: ".$rss_file."\n";}
		}
	} else {
		if(DEBUG){echo "-- File already exists. No need to download. \n\n";}
	}
	
}

?>