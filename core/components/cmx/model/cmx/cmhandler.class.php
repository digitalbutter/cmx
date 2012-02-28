<?php

class CMHandler {
	
	var $_api_key;
	var $_client_id;
	var $_cache_expiry;
	var $_force_flush;
	var $cache_path;
	var $wrapper_path;
	var $resultCount;

    function __construct(modX &$modx, $force_flush = false) {
	    $this->modx =& $modx;

	    $this->_api_key = $modx->getOption('cmx.api_key');
	    $this->_client_id = $modx->getOption('cmx.client_id');
	    $this->_force_flush = $force_flush;
	    $this->cache_path = $this->modx->getOption('cmx.core_path') . 'cache/';
	    $this->wrapper_path = dirname(__FILE__).'/cm-createsend/';
	    $this->_cache_expiry = $this->modx->getOption('cmx.cache_expiry_limit') * 60;
	    // $this->_cache_expiry = 3000 * 60;
    }

    function getSentCampaigns() {
    	$filename = 'sent_campaigns.json';
    	$this->loadWrapperClass('csrest_clients');
    	$list = array();

    	// Check for fresh cached results
    	if ($this->cacheNotExpired($filename)) {
    		FB::log('Cached Results');
    		$list = $this->getCached($filename);
    	}
    	
    	// Uncached Results
    	if (!$list) {
    		FB::log('Uncached Results');
    		$list = array();
    		$wrap = new CS_REST_Clients($this->_client_id, $this->_api_key);
    		$result = $wrap->get_campaigns();

			foreach ($result->response as $item) {
			    array_push($list,$this->objectToArray($item)); 
			}


			$this->setCached($filename, $list);
			$this->setCacheExpiry($filename);
		}    	
		
		$this->resultCount = count($list);
		return $list;
    }

    function getScheduledCampaigns() {
    	$filename = 'scheduled_campaigns.json';
    	$this->loadWrapperClass('csrest_clients');
    	$list = array();

    	// Check for fresh cached results
    	if ($this->cacheNotExpired($filename)) {
    		$list = $this->getCached($filename);
    	}
    	
    	// Uncached Results
    	if (!is_array($list)) {
    		$list = array();
    		$wrap = new CS_REST_Clients($this->_client_id, $this->_api_key);
    		$result = $wrap->get_scheduled();

			
			foreach ($result->response as $item) {
			    array_push($list,$this->objectToArray($item)); 
			}

			$this->setCached($filename, $list);
			$this->setCacheExpiry($filename);
		}
		
		$this->resultCount = count($list);
		return $list; 
    }

    function getDraftCampaigns() {
    	$filename = 'draft_campaigns.json';
    	$this->loadWrapperClass('csrest_clients');
    	$list = array();

    	// Check for fresh cached results
    	if ($this->cacheNotExpired($filename)) {
    		$list = $this->getCached($filename);
    	}
    	
    	// Uncached Results
    	if (!$list) {
    		$list = array();
    		$wrap = new CS_REST_Clients($this->_client_id, $this->_api_key);
    		$result = $wrap->get_drafts();

			
			foreach ($result->response as $item) {
			    array_push($list,$this->objectToArray($item)); 
			}

			$this->setCached($filename, $list);
			$this->setCacheExpiry($filename);
		}
		
		$this->resultCount = count($list);
		return $list; 
    }

    // get Subscriber Lists
    function getLists() {
    	$filename = 'subscriber_lists.json';
    	$this->loadWrapperClass('csrest_clients');
    	$list = array();

    	// Check for fresh cached results
    	if ($this->cacheNotExpired($filename)) {
    		$list = $this->getCached($filename);
    	}
    	
    	// Uncached Results
    	if (!$list) {
    		$list = array();
    		$wrap = new CS_REST_Clients($this->_client_id, $this->_api_key);
    		$result = $wrap->get_lists();

			
			foreach ($result->response as $item) {
			    array_push($list,$this->objectToArray($item)); 
			}

			FB::log($list);
			$this->setCached($filename, $list);
			$this->setCacheExpiry($filename);
		}
		
		$this->resultCount = count($list);
		return $list; 
    }

    function getCampaignSummary($campaignId) {
    	$this->loadWrapperClass('csrest_campaigns');

    	$wrap = new CS_REST_Campaigns($campaignId, $this->_api_key);
    	$result = $wrap->get_summary();
    	$list = $this->objectToArray($result->response);

    	$this->resultCount = count($list);
    	return $list;
    }

    // Loads CM-CS class, throws error if not found
    function loadWrapperClass($classname) {
    	if (file_exists($this->wrapper_path.$classname.'.php')) {
    		require_once($this->wrapper_path.$classname.'.php');
    		return true;
    	} else {
    		$this->modx->log(modX::LOG_LEVEL_ERROR,'[CMx] Could not load '.$classname.' class.');
    		return false;
    	}
    }

    function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
		return $d;
	}

	function cacheNotExpired($filename) {
		$current_time = time();
		$cache_times = $this->getCached('cache_times.json');
		
		if (empty($cache_times)) {
			// cache times don't exist
			// @TODO  -- CHANGE THIS
			return false;
		}
		
		$time = $cache_times[$filename];
		if (empty($time)) {
			// unknown last time
			return false;
		}

		// Find the time elapsed since the cache was generated
		// FB::log(($current_time - $time));
		// FB::log($this->_cache_expiry);
		if ( ($current_time - $time) < $this->_cache_expiry ) {
			// use cache
			return true;
		} else {
			// cache is old
			return false;
		}		
	}

	function setCacheExpiry($filename) {
		$cache_times = $this->getCached('cache_times.json');
		
		if (empty($cache_times)) {
			// cache times don't exist
			$cache_times = array();
		}

		$cache_times[$filename] = time();

		$this->setCached('cache_times.json', $cache_times);
	}

	// grab the cache file and decode it
	function getCached($filename) {
		$path = $this->cache_path . $filename;
		$cached = '';
		if (file_exists($path)) {
			if ($cached = file_get_contents($path)) {
				return json_decode($cached, true);
			} else {
				$this->modx->log(modX::LOG_LEVEL_ERROR,'[CMx] Problem opening cache file ('.$filename.').');
				return false;
			}
		// cache file doesn't exist
		} else {
			return false;
		}
	}

	// save a new cache file
	function setCached($filename, $array) {
		$path = $this->cache_path . $filename;

		if($array) { 
		    if(file_put_contents($path, json_encode($array))) {
		      	return true;
		    }
		    // unable to save
		    else {
	    		$this->modx->log(modX::LOG_LEVEL_ERROR,'[CMx] Problem saving cache file ('.$filename.').');
		      	return false;
		    }
		}
		// unable to get contents
		else {
	    	$this->modx->log(modX::LOG_LEVEL_ERROR,'[CMx] Could not open cache file ('.$filename.') for writing.');
			return false;
		}
	}

	function sortResults($data, $sort, $dir) {
		if(!empty($sort)) {
			$dir = ($dir == 'ASC') ? SORT_ASC : SORT_DESC;
			$count = count($data);
			for($i=0;$i<$count;$i++) {
				$sortfields[$i] = $data[$i][$sort];
			}
			array_multisort($sortfields, $dir, $data);
		}
		return $data;
	}


	function searchResults($haystack, $needle) {
		if(!empty($needle)) {
			$count = count($haystack);
			$results = array();

			for($i=0; $i<$count;$i++) {
				foreach($haystack[$i] as $field) {
					if (strpos(strtolower($field),strtolower($needle)) !== false) {
						$results[] = $haystack[$i];
						break;
					}
				}
			}
			return $results;
		}
		else return $haystack;
	}  

	function getCount() {
		return $this->resultCount;
	}
}	