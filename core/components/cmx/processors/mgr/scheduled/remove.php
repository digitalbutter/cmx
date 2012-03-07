<?php

$campaignID = $modx->getOption('id', $_REQUEST, '');

if (!empty($campaignID)) {
	$cm = new CMHandler($modx);
	$results = $cm->removeCampaign($campaignID);
	FB::log($results);
	if ($results->http_status_code == '200') {
		return $modx->error->success('', $results);
	} else {
		return $modx->error->failure('Problem deleting campaign: '.$results->response->Message);
	}
} else {
	return $modx->error->failure('Invalid Campaign ID');
}