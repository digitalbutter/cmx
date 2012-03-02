<?php

// FB::log($_POST);

$campaign = array();

$campaign['Name'] = $modx->getOption('name', $_POST, '');
$campaign['Subject'] = $modx->getOption('subject', $_POST, '');
$campaign['FromName'] = $modx->getOption('from_name', $_POST, '');
$campaign['FromEmail'] = $modx->getOption('from_email', $_POST, '');
$campaign['ReplyTo'] = $modx->getOption('replyto', $_POST, '');
$listids = $modx->getOption('lists', $_POST, array(''));
$segmentids = $modx->getOption('segments', $_POST, array(''));

FB::log($listids);FB::log($segmentids);

if ($listids[0] === '' && $segmentids[0] === '') {
	return $modx->error->failure('Select a list or segment for this campaign');
}

if ($listids[0] !== '') {
	$campaign['ListIDs'] = $listids;
} 

if ($segmentids[0] !== '') {
	$campaign['SegmentIDs'] = $segmentids;
}

// FB::log($campaign);
$content = $modx->getOption('content', $_POST, '');

$cm = new CMHandler($modx);

$fileId = $cm->setCampaignCache($content);

if (!$fileId) {
	return $modx->error->failure('Problem saving cache file');
}

$url = 'http://'.$_SERVER['HTTP_HOST'] . '/cmx/core/components/cmx/cache/campaigns/';
$campaign['TextUrl'] = $url.$fileId.'.txt';
$campaign['HtmlUrl'] = $url.$fileId.'.html';

$results = $cm->createCampaign($campaign);

FB::log($results);
FB::log($results->http_status_code);

if ($results->http_status_code == 201) {
	FB::log('201 status');
	// remove cache
} else {
	return $modx->error->success('Campaign Monitor rejected the campaign: '. $results->response->Message); // @TODO change this to fail
}

$cm->removeCampaignCache($fileId);

return $modx->error->success('',$results);