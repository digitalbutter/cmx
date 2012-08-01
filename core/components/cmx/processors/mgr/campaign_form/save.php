<?php

$campaignID = '';

$campaign = array();

$campaign['Name'] = $modx->getOption('name', $_POST, '');
$campaign['Subject'] = $modx->getOption('subject', $_POST, '');
$campaign['FromName'] = $modx->getOption('from_name', $_POST, '');
$campaign['FromEmail'] = $modx->getOption('from_email', $_POST, '');
$campaign['ReplyTo'] = $modx->getOption('replyto', $_POST, '');
$listids = $modx->getOption('lists', $_POST, array(''));
$segmentids = $modx->getOption('segments', $_POST, array(''));

if ($listids[0] === '' && $segmentids[0] === '') {
	return $modx->error->failure('Select a list or segment for this campaign');
}

if ($listids[0] !== '') {
	$campaign['ListIDs'] = $listids;
} 

if ($segmentids[0] !== '') {
	$campaign['SegmentIDs'] = $segmentids;
}
// var_dump($scriptProperties);exit;
$rand = rand(111111111, 999999999);
$staticFileUrl = $modx->getOption('cmx.static_file_url',null,'');
if (!empty($staticFileUrl)) {
	$staticFile = $staticFileUrl.$rand.'.html';
	$scriptProperties['url'] = $staticFile; 
}

$chunk = $modx->getOption('cmx.use_chunk', null, '');
if (!empty($chunk)) {
	$content = $modx->getChunk($chunk, $scriptProperties);
} else {
	$content = $scriptProperties['content'];
	$content = str_replace('<p> </p>', '<br/>', $content); // CM doesn't like that non breaking space TinyMCE adds between the p tags
}

$cm = new CMHandler($modx);

$fileId = $cm->setCampaignFiles($content, $rand);

if (!$fileId) {
	return $modx->error->failure('Problem saving cache file');
}

$url = 'http://'.$_SERVER['HTTP_HOST'] . $modx->getOption('cmx.assets_url') . 'cache/';
$campaign['TextUrl'] = $url.$fileId.'.txt';
$campaign['HtmlUrl'] = $url.$fileId.'.html';
FB::log($campaign);

$results = $cm->createCampaign($campaign);

$cm->removeCampaignFiles($fileId);
if ($results->http_status_code == 201) {
	
	// grab campaign ID
	$campaignID = $results->response;
	FB::log($campaignID);
	// save a copy of everything in cache since we can't get this through the API
	$campaign['Content'] = $content;
	$cm->setCampaignCache($campaignID, $campaign);
	return $modx->error->success('',$results);
} else {
	return $modx->error->failure('Campaign Monitor rejected the campaign: '. $results->response->Message);
}