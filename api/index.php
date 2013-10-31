<?php 
	header('Content-Type: application/javascript');
	ini_set( "display_errors", 0);

	include_once('image_parser.php');
	include_once('functions.php');

	$version = '0.1';
	$url = convertURL($_GET['url']);

	function getImagesfromURL($url){
		// Get images from URL
		$page = file_get_contents($url);
		$doc = new DOMDocument(); 
		$doc->loadHTML($page);
		// Assign Images to $images
		$images = $doc->getElementsByTagName('img');

		if($url){
			// Create an empty list
			$imageList = array();
			// Find all the images, add them to $imageList
			foreach($images as $image) {
				$src = formatImageURL($url, $image->getAttribute('src'));
				$parser = new Parser_Provider_Image();
				$width = $parser->getImageSize($src)[0];
				$height = $parser->getImageSize($src)[1];
				$data = [
					"url" => $src,
					"width" => $width,
					"height" => $height,
					"size" => ($width*$height)
				];
				array_push($imageList, $data);
			};
			// Sort images Smallest to Largest
			usort($imageList, function($a, $b) {
	    		return $a['size'] - $b['size'];
			});

			return array_reverse($imageList);
		} else {
			return "Error. Please use a URL";
		}
	}

	$results = getImagesfromURL($url);
	$json = array(
		'version' 		=> $version,
		'url' 			=> $url,
		'smartSelect'	=> $results[0],
		'results' 		=> $results,
		'time' 			=> pageLoadingTime($start)
	);

	echo json_encode($json, JSON_PRETTY_PRINT);
?>