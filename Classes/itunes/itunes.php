<?php

/**
 * iTunes Search API Class
 *
 * Allows you to search the iTunes store using their search API
 *
 * @package		iTunes Search API Class
 * @version		1.0
 * @author		Adam Fairholm <http://www.adamfairholm.com>
 * @license		Apache License v2.0
 * @copyright	2011 Adam Fairholm
 */
 
class iTunes
{
	private $request_url 		= 'http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsSearch?';

	// --------------------------------------------------------------------------

	/**
	 * iTunes Parameters
	 *
	 * Each of these parameters are set to their defaults.
	 * See: http://www.apple.com/itunes/affiliates/resources/documentation/itunes-store-web-service-search-api.html
	 * to see how to use them.
	 */
	public $country				= 'US';
	public $media				= 'all';
	public $entity				= '';
	public $attribute			= '';
	public $limit				= '';
	public $callback			= '';
	public $lang				= 'en_us';
	public $version				= '2';
	public $explicit			= 'No';

	// --------------------------------------------------------------------------

	/**
	 * Search iTunes
	 *
	 * @access	public
	 * @param	string - the term to search for
	 * @return	obj
	 */
	public function search($term)
	{
		$data['term']		= $term;
		$data['country']	= $this->country;
		$data['media']		= $this->media;
		$data['limit']		= $this->limit;
		$data['lang']		= $this->lang;
		$data['version']	= $this->version;
		$data['explicit']	= $this->explicit;

		if($this->entity):
		
			$data['entity'] = $this->entity;
		
		endif;
		
		if($this->attribute):
		
			$data['attribute'] = $this->attribute;
		
		endif;
		
		return $this->request($data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Make a basic REST request
	 *
	 * @access 	private
	 * @param	string
	 * @param	array
	 * @return	object
	 */
	private function request($data)
	{
		$url = $this->request_url.$this->build_params($data);

		$response = @file_get_contents($url);
		
		return json_decode($response);
	}

	// --------------------------------------------------------------------------

	/**
	 * Build parameter URL string
	 *
	 * @access	private
	 * @param	array - assoc. array of parameters
	 * @return	string
	 */
	private function build_params($data)
	{
		$return 	= '';

		foreach( $data as $k => $v ):

			$k = urlencode($k);
			$v = urlencode($v);

			$return .= "&{$k}={$v}";
		
		endforeach;

		return $return;
	}

}

/* End of file iTunes.php */