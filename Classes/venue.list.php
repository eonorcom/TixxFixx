<?php 
	header('Content-type: text/xml');

	require_once "eventful/eventful.old.php";

	$AppKey = "TDz4XswWTpKVmzsS";

	$eV = new Eventful($AppKey);

	$evLogin = $eV->login('block2150', 'beaver');
	if($evLogin) {
		
		$evArgs = array(
			'location' => 'Boise, Idaho',
			'category' => 'music',
			'date' => 'Future', // "All", "Future", "Past", "Today", "Last Week", "This Week", "Next week", and months by name, e.g. "October"
			'page_size' => '50',
			'page_number' => '1',
			'sort_order' => 'date',
			'sort_direction' => 'ascending' //	 'ascending' or 'descending'	
		);

		/* Usefull Calls
		 * categories/list: MAIN_LIST: music, sports  ALL_LIST: music, conference, learning_education, family_fun_kids, festivals_parades, movies_film, food, fundraisers, art, books, attractions, community, business, singles_social, schools_alumni, clubs_associations, outdoors_recreation, performing_arts, animals, politics_activism, sales, science, religion_spirituality, sports, technology, other
		 * 
		 * 
		 * 
		 */

		$cEvent = $eV->call('/events/search', $evArgs);

		echo $cEvent;

	}else{
		die("<strong>Error logging into Eventful API</strong>");
	}


?>