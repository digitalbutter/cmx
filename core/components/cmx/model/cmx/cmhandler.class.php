<?php

class CMHandler {
	
	var $_api_key;
	var $_client_id;
	var $_cache_expiry;
	var $_force_flush;
	var $cache_path;
	var $core_cache_path;
	var $assets_cache_path;
	var $wrapper_path;
	var $resultCount;

    function __construct(modX &$modx, $force_flush = 'false') {
	    $this->modx =& $modx;

	    $this->_api_key = $modx->getOption('cmx.api_key');
	    $this->_client_id = $modx->getOption('cmx.client_id');
	    $this->_force_flush = $force_flush;
	    $this->cache_path = $this->modx->getOption('cmx.core_path') . 'cache/';
	    $this->core_cache_path = $this->modx->getOption('cmx.core_path') . 'cache/';
	    $this->assets_cache_path = $this->modx->getOption('cmx.assets_path') . 'cache/';
	    $this->wrapper_path = dirname(__FILE__).'/cm-createsend/';
	    $this->_cache_expiry = $this->modx->getOption('cmx.cache_expiry_limit') * 60;
	    // $this->_cache_expiry = 3000 * 60;
    }

    function getSentCampaigns() {
    	$filename = 'sent_campaigns.json';
    	$this->loadWrapperClass('csrest_clients');
    	$list = false;
    	
    	// Check for fresh cached results
    	if ($this->cacheNotExpired($filename) && $this->_force_flush == 'false') {
    		FB::log('Cached Results');
    		$list = $this->getCached($filename);
    	}
    	
    	// Uncached Results
    	if (empty($list) || $this->_force_flush == 'true') {
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
    	$list = false;

    	// Check for fresh cached results
    	if ($this->cacheNotExpired($filename) && $this->_force_flush === 'false') {
    		$list = $this->getCached($filename);
    	}
    	
    	// Uncached Results
    	if (!is_array($list) || $this->_force_flush === 'true') {
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
    	$list = false;

    	// Check for fresh cached results
    	if ($this->cacheNotExpired($filename) && $this->_force_flush === 'false') {
    		$list = $this->getCached($filename);
    	}
    	
    	// Uncached Results
    	if (empty($list) || $this->_force_flush === 'true') {
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
    	if ($this->cacheNotExpired($filename) && $this->_force_flush === 'false') {
    		$list = $this->getCached($filename);
    	}
    	
    	// Uncached Results
    	if (empty($list) || $this->_force_flush === 'true') {
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

    // get Subscriber Lists
    function getSegments() {
    	$filename = 'subscriber_segments.json';
    	$this->loadWrapperClass('csrest_clients');
    	$list = array();

    	// Check for fresh cached results
    	if ($this->cacheNotExpired($filename) && $this->_force_flush === 'false') {
    		$list = $this->getCached($filename);
    	}
    	
    	// Uncached Results
    	if (empty($list) || $this->_force_flush === 'true') {
    		$list = array();
    		$wrap = new CS_REST_Clients($this->_client_id, $this->_api_key);
    		$result = $wrap->get_segments();

			
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

    function createCampaign($campaignData) {
    	$this->loadWrapperClass('csrest_campaigns');

    	$wrap = new CS_REST_Campaigns('', $this->_api_key);
    	$campaign = $wrap->create($this->_client_id, $campaignData);
    	FB::log($campaignId);
    	return $campaign;
    }

    function sendCampaign($campaignID, $schedule) {
    	$this->loadWrapperClass('csrest_campaigns');

    	$wrap = new CS_REST_Campaigns($campaignID, $this->_api_key);
    	return $wrap->send($schedule);
    }

    function sendPreview($campaignID, $recipients) {
    	$this->loadWrapperClass('csrest_campaigns');

    	$wrap = new CS_REST_Campaigns($campaignID, $this->_api_key);
    	return $wrap->send_preview($recipients);
    }

	function unschedule($campaignID) {
		$this->loadWrapperClass('csrest_campaigns');

    	$wrap = new CS_REST_Campaigns($campaignID, $this->_api_key);
    	return $wrap->unschedule();
	}

	function removeCampaign($campaignID) {
		$this->loadWrapperClass('csrest_campaigns');

		$wrap = new CS_REST_Campaigns($campaignID, $this->_api_key);
		return $wrap->delete();
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

	// grab the core cache file and decode it
	function getCached($filename) {
		$path = $this->core_cache_path . $filename;
		$cached = '';
		if (file_exists($path)) {
			if ($cached = file_get_contents($path)) {
				$results = json_decode($cached, true);
				return $results;
			} else {
				$this->modx->log(modX::LOG_LEVEL_ERROR,'[CMx] Problem opening cache file ('.$filename.').');
				return false;
			}
		// cache file doesn't exist
		} else {
			return false;
		}
	}

	// save core cache file
	function setCached($filename, $data) {
		$path = $this->core_cache_path . $filename;
		$data = json_encode($data);

		if($data) { 
		    if(file_put_contents($path, $data)) {
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

	// remove core cached file
	function removeCached($filename) {
		$path = $this->core_cache_path . $filename;

		if (file_exists($path)) {
			unlink($path);
			return true;
		} else {
			return false;
		}
	}

	// save assets cache file
	function setAssetsCached($filename, $data) {
		$path = $this->assets_cache_path . $filename;

		if($data) { 
		    if(file_put_contents($path, $data)) {
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

	function removeAssetsCached($filename) {
		$path = $this->assets_cache_path . $filename;

		if (file_exists($path)) {
			unlink($path);
			return true;
		} else {
			return false;
		}
	}

	function setCampaignCache($campaignID, $campaign) {
		$filename = 'campaigns/'.$campaignID.'.json';

		$success = $this->setCached($filename, $campaign);
		return $success;
	}

	function getCampaignCache($campaignID) {
		$filename = 'campaigns/'.$campaignID.'.json';

		$campaign = $this->getCached($filename);
		return $campaign;
	}

	function removeCamapaignCache($campaignID) {
		$filename = 'campaigns/'.$campaignID.'.json';

		$response = $this->removeCached($filename);
		return $response;		
	}

    function setCampaignFiles($content) {
    	require_once $this->modx->getOption('cmx.core_path',null,$this->modx->getOption('core_path').'components/cmx/') . 'library/html2text.php';
    	$rand = rand(111111111, 999999999);
    	$filename_html = $rand.'.html';
    	$filename_txt = $rand.'.txt';

    	if (!file_exists($this->assets_cache_path.$filename_html)) {
    		if(!$this->setAssetsCached($filename_html, $content)) {
    			// problem saving html copy
    			return false;
    		}
    	} else return false;

    	if (!file_exists($this->assets_cache_path.$filename_txt)) {
	    	if(!$this->setAssetsCached($filename_txt, convert_html_to_text($content))) {
				// problem saving txt copy
				return false;
			}
		} else return false;

		return $rand;
    }

    function removeCampaignFiles($fileId) {
    	$filename_html = $fileId.'.html';
    	$filename_txt = $fileId.'.txt';

    	if (!$this->removeAssetsCached($filename_html)) {
    		return false;
    	}

    	if (!$this->removeAssetsCached($filename_txt)) {
    		return false;
    	}

    	return true;
    }

   //  function getCampaignFiles($filename) {
   //  	$content = $this->getAssetsCached($filename, false);

   //  	if ($content) {
			// return $content;
   //  	} else return false;
   //  }

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