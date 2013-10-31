<?php
/* 
	Convert a string to URL
	by adding http://
*/
function convertURL($string){
	if($string){
		$parsedURL = parse_url($string);
		if($parsedURL['scheme']!='http'){
			$string = 'http://'.$string;
		}
		return $string;
	}
	else {
		return null; // No URL found
	}
}

/*
	Check if the domain was
	included with the image URL.
	If not, add it. 
*/
function formatImageURL($url, $string){
	$parsedURL = parse_url($url);
	$parsedImageURL = parse_url($string);
	if($parsedImageURL["scheme"] != true && $parsedImageURL["host"] != true){
		// Check for a forslash at the start
		if(substr($string,0,1)!='/'){
			$string = '/'.$string;
		}
		return $parsedURL["scheme"]."://".$parsedURL["host"].$string;
	}
	return $string;
}

/* 
	Sort Images (NOT WORKING)
*/
function sortImages($list){
	// Sort each Image 
	usort($list, function($a, $b) {
		return $a['size'] - $b['size'];
	});
}

/*
	Check how long it takes for the page to load
*/
// Set all the starting variables
function startPageTimer(){
	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	return $time;
}
$start = startPageTimer();

function pageLoadingTime($start){
	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$finish = $time;
	$total_time = round(($finish - $start), 4);
	return 'Results generated in '.$total_time.' seconds.';
}

?>