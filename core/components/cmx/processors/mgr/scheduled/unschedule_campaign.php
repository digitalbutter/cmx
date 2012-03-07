<?php

$campaignid = $modx->getOption('id', $_REQUEST, '');

$cm = new CMHandler($modx);

$response = $cm->unschedule($campaignid);
FB::log($response);
if ($response->http_status_code == '200') {
	// success
	return $modx->error->success('', $response);
} else {
	return $modx->error->failure(''.$response);
}